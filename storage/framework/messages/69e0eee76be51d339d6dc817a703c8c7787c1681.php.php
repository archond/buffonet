<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Rating;
use Illuminate\Support\Facades\Mail;
use \Validator;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class RatingController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('clear_rating_filters')) {
            $request->session()->forget('rating_search_by_contact');
            $request->session()->forget('rating_search_by_email');
            $request->session()->forget('rating_sort');
        }



        if ($request->has('rating_search_by_contact') || $request->get('rating_search_by_contact') === '') {
            $request->session()->put('rating_search_by_contact', $request->get('rating_search_by_contact'));
        }
        if ($request->has('rating_search_by_email') || $request->get('rating_search_by_email') === '') {
            $request->session()->put('rating_search_by_email', $request->get('rating_search_by_email'));
        }
        if ($request->has('rating_sort') || $request->get('rating_sort') === '') {
            $request->session()->put('rating_sort', $request->get('rating_sort'));
        }


        $ratings = Rating::with(['contact' => function ($q) {
            $q->with(['contactDetailValue' => function ($q) {
                $q->whereHas('contactDetail', function ($q) {
                    $q->where('name', 'title');
                });
            }]);
        }])
            ->withTrashed()
            ->with('user');


        if ($request->session()->has('rating_search_by_contact')) {

            $searchedString = $request->session()->get('rating_search_by_contact');

            $ratings = $ratings->whereHas('contact', function($q) use($searchedString){
                $q->whereHas('contactDetailValue', function($q) use($searchedString){
                    $q->whereHas('contactDetail', function ($q) use($searchedString){
                        $q->where('name', 'title');
                    })->where('value', 'LIKE', '%'.$searchedString.'%');
                });
            });
        }

        if ($request->session()->has('rating_search_by_email')) {
            $ratings = $ratings->where('email', 'LIKE','%'.$request->session()->get('rating_search_by_email').'%' );
        }


        if($request->session()->has('rating_sort') ){
            switch ($request->session()->get('rating_sort')) {
                case "sent_date_a":
                    $ratings = $ratings->orderBy('sent_date', 'asc');
                    break;
                case "sent_date_d":
                    $ratings = $ratings->orderBy('sent_date', 'desc');
                    break;
                case "complete_date_a":
                    $ratings = $ratings->orderBy('complete_date', 'asc');
                    break;
                case "complete_date_d":
                    $ratings = $ratings->orderBy('complete_date', 'desc');
                    break;

            }
        }
        

        $ratings = $ratings->orderBy('id', 'desc')->paginate(config('constants.PAGINATE_PER_PAGE'));


        foreach ($ratings as $rating) {
            if (isset($rating->user->id)) {
                $rating->author_name = 'Admin: ' . $rating->user->name;
                $rating->email = $rating->user->email;

            }
            $rating->language = $rating->language ? $rating->language->name : _('Language is not set');
        }


//        return $ratings;

        return view('ratings.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $data = $request->all();

        if (isset($data['contacts']) && $data['contacts']) {
            $contactsIdsArray = $data['contacts'];
        } else {
            $contactsIdsArray = [];
        }

        $contacts = Contact::whereIn('id', $contactsIdsArray)
            ->with(['contactDetailValues' => function ($q) {
                $q->whereHas('contactDetail', function ($q) {
                    $q->where('name', 'title');
                });
            }])
            ->get();


        return view('ratings.create', compact('contacts'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rating = Rating::with(['contact' => function ($q) {
            $q->with(['contactDetailValue' => function ($q) {
                $q->whereHas('contactDetail', function ($q) {
                    $q->where('name', 'title');
                });
            }]);
        }])
            ->with('user')
            ->withTrashed()
            ->find($id);

        if (isset($rating->user->id)) {
            $rating->author_name = 'Admin: ' . $rating->user->name;
            $rating->email = $rating->user->email;
        }

        $rating->language = $rating->language ? $rating->language->name : _('Language is not set');

        return view('ratings.show', compact('rating'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($encodedId)
    {
        $ratingId = Crypt::decrypt($encodedId);
        Rating::find($ratingId)->delete();

        return redirect()->route('ratings.index')->with('success', true)->with('form_message', _('Rating is deleted successfully'));
    }

    public function unDestroy($encodedId)
    {
        $ratingId = Crypt::decrypt($encodedId);
        Rating::where('id', $ratingId)->onlyTrashed()->restore();

        return redirect()->route('ratings.index')->with('success', true)->with('form_message', _('Rating is restored successfully'));
    }

    public function askForRating(Request $request)
    {



        $data = $request->all();
        $string = str_replace('"', '', $data['emails_list']);
        $string = str_replace('[', '', $string);
        $string = str_replace(']', '', $string);
        $string = explode(',', $string);
        $data['emails_list'] = $string;
//        return $data;


        $contactArray = [];
        if (isset($data['contact']) && is_array($data['contact'])) {
            $contactArray = $data['contact'];

        }

        $emailArray = [];

        if (isset($data['emails_list']) && is_array($data['emails_list'])) {
            $emailArray = $data['emails_list'];
//            dd($data);
//            dd($data['emails_list']);
            foreach ($emailArray as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    unset($email);
                }
            }
        }

        $contacts = Contact::whereIn('id', $contactArray)->with('language')->get();


        $contacts = Contact::whereIn('id', $contactArray)
            ->with(['contactDetailValue' => function ($q) {
                $q->whereHas('contactDetail', function ($q) {
                    $q->where('name', 'title');
                });
            }])
            ->with('language')
            ->get();


        foreach ($contacts as $contact) {
            foreach ($emailArray as $email) {

                $rating = new Rating();
                $rating->email = $email;
                $rating->sent_date = \Carbon\Carbon::now()->format('Y-m-d H:m:i');
                $rating->contact_id = $contact->id;

                $rating->save();


                $title = isset($contact->contactDetailValue->value) ? $contact->contactDetailValue->value : _('No title');

                $locale = \App::getLocale();
                $contactLocale = $contact->language->abbr;
                $laravelGettextLocale = config('app.locales.' . $contactLocale);
                LaravelGettext::setLocale($laravelGettextLocale);

                Mail::send('emails.request.ask-for-rating', ['contact' => $contact, 'email' => $email, 'rating' => $rating, 'title' => $title, 'message_text'=>$data['message_text'] ? $data['message_text']: '' ], function ($m) use ($request, $email) {

//                    dd($email);
                    $m->from('no-replay@app.com', config('constants.APP_NAME'));
                    $m->to($email, $email)->subject(_('Request ask to rate object(s)'));

                });
                $laravelGettextLocale = config('app.locales.' . $locale);
                LaravelGettext::setLocale($laravelGettextLocale);

            }

        }

        return redirect()->route('contacts.index')->with('success', true)->with('form_message', _('Rating request is sent successfully'));


    }

    public function ratingForm($encodedId)
    {

        $ratingId = Crypt::decrypt($encodedId);
//        return $ratingId;
        $rating = Rating::with('contact')
            ->with(['contact.contactDetailValues' => function ($q) {
                $q->whereHas('contactDetail', function ($q) {
                    $q->where('name', 'title');
                });
            }])
            ->with('contact.language')
            ->find($ratingId);

        $readonly = ($rating->complete_date) ? 'readonly' : null;


        return view('ratings.feedback.create', compact('rating', 'encodedId', 'readonly'));
    }

    public function ratingFormUpdate(Request $request, $encodedId)
    {
        $ratingId = Crypt::decrypt($encodedId);
        $data = $request->all();


        $validator = Validator::make($data, [
//            'language_id'   => 'required',
            'author_phone' => 'required',
            'author_name' => 'required',
            'review' => 'required',
            'accurancy' => 'required',
            'quality' => 'required',
            'communication' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

//        return $data;

        $data['complete_date'] = \Carbon\Carbon::now()->format('Y-m-d H:m:i');

        $rating = Rating::find($ratingId);
        $rating->update($data);

        return redirect()->route('request-ask-for-rating', $encodedId)->with('success', true)->with('form_message', _('Rating data is sent successfully, thank you'));
    }

    public function ratingFormSuccess($encodedId)
    {
        $ratingId = Crypt::decrypt($encodedId);

        return view('ratings.feedback.success');
    }

    public function adminDoRating($id)
    {


        $contactId = $id;

//        $rating = Rating::where('contact_id', $id)->where('user_id', Auth::user()->id)->first();

//        if (empty($rating))
//        {
//            $rating = new Rating();
//
//            $dataArray = [
//                'user_id'    => Auth::user()->id,
//                'contact_id' => $contactId,
//                'sent_date'  => \Carbon\Carbon::now()->format('Y-m-d H:m:i')
//            ];
//
//            $rating = $rating->create($dataArray);
//        }

        $rating = new Rating();

        $dataArray = [
            'user_id' => Auth::user()->id,
            'contact_id' => $contactId,
            'sent_date' => \Carbon\Carbon::now()->format('Y-m-d H:m:i')
        ];

        $rating = $rating->create($dataArray);


        $readonly = (isset($rating->complete_date) && $rating->complete_date) ? 'readonly' : null;

        return view('ratings.admin-do-rating.create', compact('rating', 'readonly', 'contactId'));
    }

    public function adminDoRatingUpdate(Request $request, $ratingId)
    {
        $ratingId = $ratingId;
        $data = $request->all();
//        return $data;

        $validator = Validator::make($data, [
            'review' => 'required',
            'accurancy' => 'required',
            'quality' => 'required',
            'communication' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data['complete_date'] = \Carbon\Carbon::now()->format('Y-m-d H:m:i');

        $rating = Rating::find($ratingId);
        $rating->update($data);

        return redirect()->route('contacts.index')->with('success', true)->with('form_message', _('Rating data is sent successfully, thank you'));
    }
}
