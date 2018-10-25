<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\City;
use App\Country;
use App\Http\Controllers\Auth\PasswordController;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Contact;
use App\Stage;
use App\RequesStage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Image;
use Mail;
use Crypt;
use App\ContactDetailValue;
use App\Mainobject;
use Xinax\LaravelGettext\Facades\LaravelGettext;


class RequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('clear_request_filters')) {
            $request->session()->forget('search_by_email');
            $request->session()->forget('search_by_title');
            $request->session()->forget('search_by_status');
            $request->session()->forget('request_sort');
        }

        if ($request->has('search_by_email') || $request->get('search_by_email') === '') {
            $request->session()->put('search_by_email', $request->get('search_by_email'));
        }
        if ($request->has('search_by_title') || $request->get('search_by_email') === '') {
            $request->session()->put('search_by_title', $request->get('search_by_title'));
        }
        if ($request->has('search_by_status') || $request->get('search_by_email') === '') {
            $request->session()->put('search_by_status', $request->get('search_by_status'));
        }

        if ($request->has('request_sort')) {
            $request->session()->put('request_sort', $request->get('request_sort'));
        }


        $myRequests = \App\Request::with(['contact.contactDetailValues']);


        if ($request->session()->has('search_by_email')) {
            $myRequests->where('email', 'LIKE', '%' . $request->session()->get('search_by_email') . '%');
        }


        if ($request->session()->has('search_by_title')) {
            $searchedTitle = $request->session()->get('search_by_title');

            $myRequests->whereHas('contact', function ($q) use ($searchedTitle) {
                $q->whereHas('contactDetailValues', function ($q) use ($searchedTitle) {
                    $q->where('contactdetail_id', 4)->where('value', 'LIKE', '%' . $searchedTitle . '%');
                });
            });
        }


        if ($request->session()->has('search_by_status') && $request->session()->get('search_by_status') != '0' && $request->session()->get('search_by_status') != '') {

            switch ($request->session()->get('search_by_status')) {
                case "is_confirmed_by_admin":
                    $myRequests = $myRequests->where('is_confirmed_by_admin', 1);
                    break;
                case "is_not_complete":
                    $myRequests = $myRequests->whereNull('complete_date')->whereNull('is_confirmed_by_admin')->whereNull('is_denied_by_admin');
                    break;
                case "is_denied_by_admin":
                    $myRequests = $myRequests->whereNotNull('is_denied_by_admin');
                    break;
                case "is_complete":
                    $myRequests = $myRequests->whereNotNull('complete_date')->whereNull('is_confirmed_by_admin')->whereNull('is_denied_by_admin');
                    break;
                default:
                    $myRequests = $myRequests;
            }
        }

        if ($request->session()->has('request_sort')) {
            switch ($request->session()->get('request_sort')) {
                case "sent_date_a":
                    $myRequests = $myRequests->orderBy('sent_date', 'asc');
                    break;
                case "sent_date_d":
                    $myRequests = $myRequests->orderBy('sent_date', 'desc');
                    break;
                case "complete_date_a":
                    $myRequests = $myRequests->orderBy('complete_date', 'asc');
                    break;
                case "complete_date_d":
                    $myRequests = $myRequests->orderBy('complete_date', 'desc');
                    break;

            }
        }


        $myRequests = $myRequests->orderBy('id', 'desc')->paginate(config('constants.PAGINATE_PER_PAGE'));

        foreach ($myRequests as $myRequest) {

            foreach ($myRequest['contact']['contactDetailValues'] as $val) {
                if ($val['contactdetail_id'] == 1) {
                    $existingValue = $myRequest['contact_email'];
                    $existingValueArray = is_array($existingValue) ? $existingValue : [];
                    $newValueArray = array_prepend($existingValueArray, $val['value']);
                    $myRequest->setAttribute('contact_email', $newValueArray);
                }

                // else 

                if ($val['contactdetail_id'] == 4) {
                    $existingValue = $myRequest['contact_title'];
                    $existingValueArray = is_array($existingValue) ? $existingValue : [];
                    $newValueArray = array_prepend($existingValueArray, $val['value']);
                    $myRequest->setAttribute('contact_title', $newValueArray);
                }

            }
        }


        $requestStatuses = [
            0 => _('All'),
            'is_not_complete' => _('Waiting for client'),
            'is_complete' => _('Waiting for admin'),
            'is_confirmed_by_admin' => _('Confirmed by admin'),
            'is_denied_by_admin' => _('Denied by admin'),

        ];

//        return $requestStatuses;
        return view('requests.index', compact('myRequests', 'requestStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();

//        return $input;

        if (!isset($input['contacts'])) {
            return redirect()->route('contacts.index')->with('error', true)->with('form_message', 'Please select at least one contact before!');
        }

        foreach ($input['contacts'] as $key => $contact) {
            $array[$key]['contact_id'] = $contact;
        }


        if (isset($input['getEmails'])) {

            $requestedDataString = $this->getDataString(1, $input['contacts']);

            return view('contacts.data-string', compact('requestedDataString'));

        } elseif (isset($input['getPhones'])) {

            $requestedDataString = $this->getDataString(2, $input['contacts']);
            return view('contacts.data-string', compact('requestedDataString'));

        } elseif (isset($input['createAskForRating'])) {
            return (new RatingController())->create($request);

        } elseif (isset($input['createRequestForContactInfo'])) {
            return $this->createRequestArray($request);
        }

        $requestedDataString = '';

        return (new ContactController())->index($request, $requestedDataString);


    }


    public function createAskRequest($contactId)
    {
        $contact = Contact::with(['contactDetailValues' => function ($q) {
            $q->whereHas('contactDetail', function ($q) {
//                $q->where('name', 'e-mail');
                $q;
            })->with('contactDetail');
        }])
            ->find($contactId);

        $stages = Stage::with(['translation' => function ($q) {
            $q->where('language_id', $this->selectedLanguage);
        }])->get();

        $emails = $contact->contactDetailValues->where('contactDetail.name', 'e-mail')->pluck('value')->toArray();

        $title = $contact->contactDetailValues->where('contactDetail.name', 'title')->pluck('value')->toArray();

        $emails = '"' . implode('","', $emails) . '"';

        $title = '"' . implode('","', $title) . '"';

//        return $title;

        return view('requests.create', compact('contact', 'stages', 'emails', 'title'));

    }

    public function createRequestArray($request)
    {
        $contacts = Contact::with(['contactDetailValues' => function ($q) {
            $q->whereHas('contactDetail', function ($q) {
//                $q->where('name', 'e-mail');
                $q;
            })->with('contactDetail');
        }])->whereIn('id', $request['contacts'])
            ->get();


        $stages = Stage::with(['translation' => function ($q) {
            $q->where('language_id', $this->selectedLanguage);
        }])->get();

//        $emails = $contact->contactDetailValues->where('contactDetail.name', 'e-mail')->pluck('value')->toArray();

        $title = '';

        $contacts = $contacts->each(function ($contact) use ($title) {

            $title = $contact->contactDetailValues->where('contactDetail.name', 'title')->first()['value'];

            $contact->setAttribute('title', $title);


            return $contact;
        });

        $title = $contacts->pluck('title')->toArray();

        $title = implode(',', $title);

        $contacts = $request['contacts'];
//        return $contacts;

        return view('requests.createArray', compact('contacts', 'title', 'stages'));

    }

    public function getDataString($contactdetail_id, $contactArray)
    {


        if ($contactdetail_id == 2) {
            $data = ContactDetailValue::with('contact.mainobejects')->where('contactdetail_id', $contactdetail_id)->whereIn('contact_id', $contactArray)->orderBy('contact_id')->get();


            $contacts = Contact::with(['contactDetailValues'=>function($q) use($contactdetail_id){
                $q->where('contactdetail_id', $contactdetail_id);
            }])
                ->with('mainobejects')
                ->whereIn('id', $contactArray)->get();



            $data = $contacts->each(function($contact){
                $contact->contactDetailValues[] = new ContactDetailValue(['value'=>$contact->mainobejects->phone, 'contact_id'=>$contact->id] ) ;
                return $contact;
            });

            $dataArray= $data->pluck('contactDetailValues');


            $data= [];
            foreach($dataArray as $dataArraySub){
                foreach($dataArraySub as $dataArraySubSub){
                    $data[] =$dataArraySubSub;
                }
            }



        } else {
            $data = ContactDetailValue::where('contactdetail_id', $contactdetail_id)->whereIn('contact_id', $contactArray)->get();
        }

        foreach ($data as $value) {
            if (isset($prevValueContactId) && $prevValueContactId != $value->contact_id) {
                $arrayData[] = '<br>';
            }
            $arrayData[] = $value['value'];
            $prevValueContactId = $value->contact_id;
        }

        $arrayData = isset($arrayData) ? $arrayData : [];

        $arrayData = array_filter($arrayData);

//        dd($arrayData);

        $arrayWithUnicValues = [];
        foreach ($arrayData as $value) {
            if ($value == '<br>' || !in_array($value, $arrayWithUnicValues)) {
                $arrayWithUnicValues[] = $value;
            }
        }

        // ja blakus divi elemn ar <br> - tad vienu lieko dzēšam ārā
        $prevVal = '';
        foreach($arrayWithUnicValues as $key => $val){
            if($val =='<br>' && $val == $prevVal ){
                unset($arrayWithUnicValues[$key]);
            }
            $prevVal = $val;
        }

        $string = implode(',', $arrayWithUnicValues);

        $string = str_replace('<br>,', '<br>', $string);

        return $string;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = $request->all();
        $contactId = $data['contact_id'];

        $emailsList = isset($data['emails_list']) ? $data['emails_list'] : null;
        $emailsList = trim($emailsList, '[]');

        $emailsList = str_replace('"', '', $emailsList);
        $emailsList = explode(',', $emailsList);

        $emailsList = array_unique($emailsList);

        $locale = \App::getLocale();
        $contactLocale = Contact::find($contactId)->language->abbr;
        $laravelGettextLocale = config('app.locales.' . $contactLocale);
        LaravelGettext::setLocale($laravelGettextLocale);
        foreach ($emailsList as $email) {
            $array = [
                'email' => $email,
                'sent_date' => \Carbon\Carbon::now()->format('Y-m-d H:m:i'),
                'contact_id' => $contactId,
                'message_text' => $data['message_text']
            ];
            $myRequest = \App\Request::create($array);
            $myRequest->stage()->attach($data['stages']);


            Mail::send('emails.request', ['request' => $myRequest], function ($m) use ($email) {
                $m->from('no-replay@app.com', config('constants.APP_NAME'));

                $m->to($email, '"' . $email . '"')->subject(_('Request for your contact info'));

            });

        }
        $laravelGettextLocale = config('app.locales.' . $locale);
        LaravelGettext::setLocale($laravelGettextLocale);

        return redirect()->route('contacts.show', $contactId)->with('success', true)->with('form_message', 'Request is sent successfully');
    }

    public function storeArray(Request $request)
    {
        $data = $request->all();
//        return $data;

        $contactIdsArray = explode(',', $data['contacts']);

        $contacts = Contact::whereIn('id', $contactIdsArray)
            ->whereHas('contactDetailValue', function ($q) {
                $q->where('contactdetail_id', 1);
            })
            ->with(['contactDetailValue' => function ($q) {
                $q->where('contactdetail_id', 1);
            }])->get();


//        return $contacts;

        foreach ($contacts as $contact) {
            $email = $contact->contactDetailValue->value;
//            dd($email );
            $email = str_replace(',', '', $email);


            $array = [
                'email' => $email,
                'sent_date' => \Carbon\Carbon::now()->format('Y-m-d H:m:i'),
                'contact_id' => $contact['id'],
                'message_text' => $data['message_text']
            ];
            $myRequest = \App\Request::create($array);
            $myRequest->stage()->attach($data['stages']);


            Mail::send('emails.request', ['request' => $myRequest], function ($m) use ($email) {
                $m->from('no-replay@app.com', confg('constants.APP_NAME'));

                $m->to($email, '"' . $email . '"')->subject(_('Request for your contact info'));

            });

        }
//        $laravelGettextLocale = config('app.locales.' . $locale);
//        LaravelGettext::setLocale($laravelGettextLocale);

//        $contacts = $contactIdsArray;

        return redirect()->route('contacts.index')->with('success', true)->with('form_message', 'Requests are sent successfully');
    }

    public function sendRequests()
    {
        $myRequests = \App\Request::with('contact.language', 'emails', 'title')->notSent()->get();

        // return $myRequests;

        $locale = \App::getLocale();

        foreach ($myRequests as $request) {
            $contactLocale = $request->contact->language->abbr;
            $laravelGettextLocale = config('app.locales.' . $contactLocale);

            LaravelGettext::setLocale($laravelGettextLocale);


            Mail::send('emails.request', ['request' => $request], function ($m) use ($request) {
                $m->from('no-replay@app.com', config('constants.APP_NAME'));

                foreach ($request['emails'] as $email) {

                    $m->to($email['value'], $request['name'])->subject(_('Request for your contact info'));

                }
            });

            $request->sent_date = \Carbon\Carbon::now();
            $request->save();
        }

        $laravelGettextLocale = config('app.locales.' . $locale);

        LaravelGettext::setLocale($laravelGettextLocale);
    }

    public function requestForm($encodedId)
    {
        $requestId = Crypt::decrypt($encodedId);

        $myRequest = \App\Request::find($requestId);

        $contactId = $myRequest->contact_id;

//        $languageId = $myRequest->contact->language_id;
        $languageId = $this->selectedLanguage->id;

        $selectedCategories = Category::whereHas('contactValues', function ($q) use ($contactId) {
            $q->where('contact_id', $contactId);
        })
//            ->with('parents')
            ->with('parentCategory.parentCategory.parentCategory.parentCategory')
            ->with('brothers')
            ->get();


        $topCategories = Category::top()->with('brothers')->first();

        $categories = [];

        $selectedCategories->each(function ($category, $key) use (&$categories) {
            $categories[$category->parent_id]['selectedIds'][] = $category->id;
            $categories[$category->parent_id]['parent'] = $category->parentCategory;
            $categories[$category->parent_id]['brothers'] = $category->brothers;

        });


        $locale = \App::getLocale();
//        $contactLocale = $myRequest->contact->language->abbr;
//
//
//        \App::setLocale($contactLocale);


        if ($myRequest->complete_date) {
            return 'Sorry, you request is competed already on ' . $myRequest->complete_date . ' (UTC("Europe/London") time)';
        }

        $stages = \App\Request::with('stage.contactDetails.inputField', 'stage.contactDetails.options')
            ->with(['stage.contactDetails.translation' => function ($q) use ($languageId) {
                $q->where('language_id', $languageId);

            }])
            ->with(['stage.contactDetails.values' => function ($q) use ($contactId) {
                $q->where('contact_id', $contactId)->orderBy('id', 'asc');
            }])
            ->with(['stage.translation' => function ($q) use ($languageId) {
                $q->where('language_id', $languageId);
            }])
            ->find($requestId)->stage;


        $contactDetailValues = ContactDetailValue::where('contact_id', $contactId)->get();

        $addresses = Address::with('country.cities', 'city')->where('contact_id', $contactId)->get();


        $stages = (new ContactController())->setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues);

        $stages = (new ContactController())->setCategoryParentCategories($stages);

        $contact = Contact::with(['tags' => function ($q) {
            // $q->where('language_id', $this->selectedLanguage->id);
            $q;
        }])
            ->find($contactId);


        foreach ($this->languages as $language) {
            $tagList[$language->id] = $contact->tags->filter(function ($model) use ($language) {
                return $model->language_id == $language->id;
            });


            $tagList[$language->id] = $tagList[$language->id]->pluck('id')->toArray();
        }


        $countries = Country::orderBy('name', 'asc')->get();
        $tagListAllCollection = Tag::orderBy('name')->get();

        $tagListAll = [];
        foreach ($this->languages as $language) {
            $tagListAll[$language->id] = $tagListAllCollection->filter(function ($tag) use ($language) {
                return $tag->language_id == $language->id;
            });
        }

//        \App::setLocale($locale);

        $contact = Contact::with('mainObejects')->find($contactId);

        return view('requests.feedback.edit', compact('stages', 'encodedId', 'tagList', 'tagListAll', 'countries', 'showAverageRating', 'showRatingDataInForm', 'languageId',
            'topCategories', 'categories', 'addresses', 'contact'));


    }

    public function feedbackUpdate(Request $request, $encodedId)
    {
        $requestId = Crypt::decrypt($encodedId);
        $myRequest = \App\Request::find($requestId);
        $conactId = $myRequest->contact_id;

        $data = $request->all();
//        return $data;


        if (isset($data['contact_detail'])) {
            foreach ($data['contact_detail'] as $detailKey => $detail) {
                if (isset($detail['val'])) {
                    foreach ($detail['val'] as $valueKey => $value) {
                        if (is_object($value) AND $value instanceof UploadedFile) {
                            if (is_file($value)) {
                                $filename = time() . '-' . uniqid() . '.' . $value->getClientOriginalExtension();
                                $path0 = 'uploads/files-request/' . $filename;
                                $path1 = public_path($path0);

                                $img = Image::make($value);
                                $img->save($path1);

                                $data['contact_detail'][$detailKey]['val'][$valueKey] = $path0;

                            }

                        }
                    }
                }
            }
        }
//        return $data;
        $myRequest->request_data = serialize($data);

        $myRequest->save();

        // dd('!');  
        // (new ContactController() )->storeRequest($request, $conactId, $requestId);

        $myRequest->complete_date = \Carbon\Carbon::now();
        $myRequest->save();

        return view('requests.feedback.success');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function adminProcessView($requestId)
    {

        $myRequest = \App\Request::find($requestId);

//        return $myRequest;

//        return unserialize($myRequest->request_data);
        $contactId = $myRequest->contact_id;


        $topCategories = Category::top()->with('brothers')->first();

        ///------------------------------------------------------------------------------> $categories
        $selectedCategories = Category::whereHas('contactValues', function ($q) use ($contactId) {
            $q->where('contact_id', $contactId);
        })
            ->with('parentCategory.parentCategory.parentCategory.parentCategory')
            ->with('brothers')
            ->get();

        $categories = [];

        $selectedCategories->each(function ($category, $key) use (&$categories) {
            $categories[$category->parent_id]['selectedIds'][] = $category->id;
            $categories[$category->parent_id]['parent'] = $category->parentCategory;
            $categories[$category->parent_id]['brothers'] = $category->brothers;
        });

        ///------------------------------------------------------------------------------<

        ///------------------------------------------------------------------------------> $addresses
        $addresses = Address::with('country.cities', 'city')->where('contact_id', $contactId)->get();
//        return $addresses;
//        dd($addresses);
        ///------------------------------------------------------------------------------<

//        $rating = (new RatingController())->averagerating($contactId = $contactId);

        $mainObjects = MainObject::get();

        $contact = Contact::with(['tags'])->find($contactId);

        $tagListAllCollection = Tag::orderBy('name')->get();
        $tagListAll = [];
        foreach ($this->languages as $language) {
            $tagListAll[$language->id] = $tagListAllCollection->filter(function ($tag) use ($language) {
                return $tag->language_id == $language->id;
            });
        }

        // esošie dati---->

        $stages = \App\Request::with('stage.contactDetails.inputField', 'stage.contactDetails.options')
            ->with(['stage.translation' => function ($q) {
                $q->where('language_id', $this->selectedLanguage->id);
            }])
            ->with(['stage.contactDetails.translation' => function ($q) {
                $q->where('language_id', $this->selectedLanguage->id);
            }])
            ->with(['stage.contactDetails.values' => function ($q) use ($contactId) {
                $q->where('contact_id', $contactId)->orderBy('id', 'asc');
            }])
            ->find($requestId)->stage;

        $contactDetailValues = ContactDetailValue::where('contact_id', $contactId)->get();


        $stages = (new ContactController())->setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues);

        $stages = (new ContactController())->setCategoryParentCategories($stages);
        foreach ($this->languages as $language) {
            $tagList[$language->id] = $contact->tags->filter(function ($model) use ($language) {
                return $model->language_id == $language->id;
            });
//            $tagList[$language->id] = implode(',', $tagList[$language->id]->pluck('name', 'id')->toArray());
            $tagList[$language->id] = $tagList[$language->id]->pluck('id')->toArray();
        }

        // esošie dati beidzās----<
//        dd($stages);

        // jaunie dati---->
        $newData = unserialize($myRequest->request_data);

//        return $newData;


        ///------------------------------------------------------------------------------> $categoriesNew
//        return $newData['selected_categories'];
        $selectedCategoroiesIdsNew = isset($newData['selected_categories']) ? $newData['selected_categories'] : [];

        $selectedCategoriesNew = Category::whereIn('id', $selectedCategoroiesIdsNew)
            ->with('parentCategory.parentCategory.parentCategory.parentCategory')
            ->with('brothers')
            ->get();

        $categoriesNew = [];

        $selectedCategoriesNew->each(function ($category, $key) use (&$categoriesNew) {
            $categoriesNew[$category->parent_id]['selectedIds'][] = $category->id;
            $categoriesNew[$category->parent_id]['parent'] = $category->parentCategory;
            $categoriesNew[$category->parent_id]['brothers'] = $category->brothers;
        });

//        return $categoriesNew;
        ///------------------------------------------------------------------------------<


        ///------------------------------------------------------------------------------> $addressesNew Start
        $collection = collect();
        
        $selectedCountriesIdsNew = isset($newData['markers']['country_id']) ? $newData['markers']['country_id'] : [];
        foreach ($selectedCountriesIdsNew as $key => $countryId) {

            if ($newData['markers']['country_id'][$key] != '' && $newData['markers']['city_id'][$key] != '') {
                $countryNew = Country::with(['cities'])->find($countryId);
                $cityId = $newData['markers']['city_id'][$key];
                $cityNew = City::find($cityId);

                $address = new Address;
                $address->setAttribute('id', $newData['markers']['address_id'][$key]);
                $address->setAttribute('contact_id', $contact->id);
                $address->setAttribute('country_id', $countryId);
                $address->setAttribute('city_id', $cityId);
                $address->setAttribute('map_center', $newData['markers']['map_center'][$key]);
                $address->setAttribute('map_zoom', $newData['markers']['map_zoom'][$key]);
                $address->setAttribute('marker_position', $newData['markers']['marker_position'][$key]);
//                $address->setAttribute('marker_city', $newData['markers']['marker_city'][$key]);
                $address->setAttribute('marker_address', $newData['markers']['marker_address'][$key]);
                $address->setAttribute('marker_zip', $newData['markers']['marker_zip'][$key]);

                $address->setRelation('country', $countryNew);
                $address->setRelation('city', $cityNew);

                $collection->push($address);
            }

        }
//        return $collection;

        $addressesNew = $collection;

        ///------------------------------------------------------------------------------< $addressesNew Finish

        ///------------------------------------------------------------------------------> Tag List new Start
        // dabūsim jaunos Taglistu
        if (isset($newData['contact_detail'][42]['translated'])) {
            foreach ($newData['contact_detail'][42]['translated'] as $key => $value) {
                $langId = $value['language_id'];
                if (isset($value['language_id'])) {
                    unset($value['language_id']);
                }

                $existingTagsArrayId = $tagListAll[$langId]->pluck('id')->toArray();
                /**
                 * add custom Tags in list
                 */
                foreach ($value as $v) {
                    if (!in_array($v, $existingTagsArrayId)) {
                        $tagListAll[$langId]->push(collect(['id' => $v, 'name' => $v, 'language_id' => $langId]));
                        $tagListAll[$langId]->push(collect(['id' => 'qq', 'name' => 'qq', 'language_id' => $langId]));
                    }
                }

                $tagListNew[$langId] = $value;
            }
        } else {
            $tagListNew = [];
        }


        //jauno taglist esam dabūjuši
        ///------------------------------------------------------------------------------< Tag List new Finish


        // jaunie dati beidzās----<

        ///------------------------------------------------------------------------------>  sākam esošo datu apvienošanu ar jaunajiem datiem  Start
        $stages->each(function ($stage) use ($newData) {
            $stage = $stage->contactDetails->each(function ($detail) use ($newData) {

                if (isset($newData['contact_detail'])) {
                    foreach ($newData['contact_detail'] as $newDataKey => $newDataValue) {
//                    var_dump($newDataValue);

                        if ($newDataKey == $detail->id AND isset($newDataValue['values_id']) AND isset($newDataValue['val'])) {
                            // here is with values_id
                            $detail->setAttribute('valuesNew', $newDataValue);

                            foreach ($newDataValue['values_id'] as $newValKey => $newValId) {
                                if (isset($newDataValue['val'][$newValKey]) && $newDataValue['val'][$newValKey] != '') {

//                                    if($newValId != 3217) dd($newDataValue);
//                                    if($newValId != '' && $newValId != 3217) dd($newDataValue);


                                    $array = [
                                        'contact_id' => '??',
//                                        'id' => $newValId,
                                        'contactdetail_id' => $detail->id,
                                        'language_id' => isset($newDataValue['language_id'][$newValKey]) ? $newDataValue['language_id'][$newValKey] : '???',
                                        'value' => $newDataValue['val'][$newValKey]
                                    ];



                                    $dataArray[] = (new ContactDetailValue($array))->setAttribute('id', $newValId);

//                                    if($newValId != '' && $newValId != 3217) dd($dataArray);
                                }
                            }

                            $detail->setAttribute('valuesUpdated', isset($dataArray) ? $dataArray : []);

                        } elseif ($newDataKey == $detail->id AND isset($newDataValue['val'])) {
                            // here is with-out values_id
                            $detail->setAttribute('valuesNew', $newDataValue);

                            if (isset($detail['values'])) {
                                foreach ($detail['values'] as $existingVal) {
                                    $dataArray[] = $existingVal;
                                }
                            }

                            foreach ($newDataValue['val'] as $newValKey => $val) {
                                if ($val != '') {
                                    $array = [
                                        'contact_id' => '??',

                                        'contactdetail_id' => $detail->id,
                                        'language_id' => isset($newDataValue['language_id'][$newValKey]) ? $newDataValue['language_id'][$newValKey] : '???',
                                        'value' => $val
                                    ];

                                    $dataArray[] = new ContactDetailValue($array);
                                }
                            }

                            $detail->setAttribute('valuesUpdated', isset($dataArray) ? $dataArray : []);

                            if (isset($newDataValue['delete_values_id'])) {
                                $detail->setAttribute('delete_values_id', $newDataValue['delete_values_id']);
                            }

                        }

                        if ($detail->name == 'rating') {
                            $detail->SetAttribute('newValue', $newData);
//                                [
//                                'accurancy'=> ,
//                                'quality'=>,
//                                'comunication'=>,
//                                'author_is_legal'=> ,
//                                'author_name'=> ,
//                                'review'=> ,

                        }
                    }
                }

                return $detail;
            });

            return $stage;
        });

//        var_dump($stages[5]->contactDetails[0]);die;
//        dd($stages[5]->contactDetails[0]);
        $contactDetailValues = ContactDetailValue::where('contact_id', $stages[0]['contact_id'])->get();
        $countries = Country::orderBy('name', 'asc')->get();

        ///------------------------------------------------------------------------------<  sākam esošo datu apvienošanu ar jaunajiem datiem  Finish

//        return $newData;

//        return $addressesNew;

        return view('requests.feedback.admin.show', compact('contact', 'stages', 'categoryArrayTree', 'tagList', 'tagListNew', 'tagListAll', 'countries', 'contactDetailValues',
            'newData', 'myRequest', 'rating', 'topCategories', 'categories', 'categoriesNew', 'addresses', 'addressesNew'));
    }

    /**
     * @param Request $request
     * @param $contactId
     * @return \Illuminate\Http\RedirectResponse
     */

    public function adminProcessSave(Request $request, $requestId, $contactId)
    {

//        return $request->all();
        (new ContactController)->update($request, $contactId, $adminProcessSave = true);

        $myRequest = \App\Request::find($requestId);
        $myRequest->is_confirmed_by_admin = 1;
        $myRequest->admin_processed_date = \Carbon\Carbon::now();
        $myRequest->save();

        return redirect()->route('requests.index')->with('success', true)->with('form_message', 'Contact is updated successfully - request is Accepted by Admin!');
    }

    public function adminProcessReject($requestId)
    {
//        return $requestId;
        $myRequest = \App\Request::find($requestId);
        $myRequest->is_denied_by_admin = 1;
        $myRequest->admin_processed_date = \Carbon\Carbon::now();
        $myRequest->save();
        return redirect()->route('requests.index')->with('success', true)->with('form_message', 'Request data is rejected successfully - request is Rejeted by Admin!');
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
    public function destroy($id)
    {
        //
    }
}
