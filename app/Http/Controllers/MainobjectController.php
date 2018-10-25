<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mainobject;
use App\Stage;
use App\ContactDetail;
use App\Contact;
use App\ContactDetailValue;
use Debugbar;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Validator;

class MainobjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $requestedDataString = null)
    {


        $data = $request->all();

        $inputs = $data;

        // search_detail[]
        // search_value


        $stages = Stage::with('contactDetails')->get();

        foreach ($stages[0]->contactDetails as $key => $detail) {
            $tableColumns[$key] = $detail['name'];
        }

//        $searchDetails = ContactDetail::whereIn('input_field_id', [1, 2])->get(); // 1 un 2 ir text un textarea
        $searchDetails = ContactDetail::whereIn('is_searchable', [1])->get();

        // Debugbar::startMeasure('test', 'test');
        $mainobjects = new Mainobject();


        $data['search_value'] = !isset($data['search_value']) ? null : $data['search_value'];


        if (isset($data['search_detail']) && $data['search_value']) {
            $mainobjects = $mainobjects
                ->whereHas('contacts.contactDetailValues', function ($q) use ($data) {
                    $q->whereIn('contactdetail_id', $data['search_detail'])
                        ->where('value', 'LIKE', '%' . $data['search_value'] . '%');
                });

            if (in_array(2, $data['search_detail'])) {
                $mainobjects = $mainobjects->orWhere('phone', 'LIKE', '%' . $data['search_value'] . '%');
            }
        } else if ($data['search_value'] != null) {

            $mainobjects = $mainobjects
                ->whereHas('contacts.contactDetailValues', function ($q) use ($data) {
                    $q->where('value', 'LIKE', '%' . $data['search_value'] . '%');
                })->orWhere('phone', 'LIKE', '%' . $data['search_value'] . '%');
        }

        $mainobjects = $mainobjects

            ->with('contacts.contactDetailValues.contactDetail.options')
            ->with('contacts.contactDetailValues.valuesSelectedOption')
            ->orderBy('id', 'desc')
            ->paginate(config('constants.PAGINATE_PER_PAGE'));

//        return $mainobjects;


        // Debugbar::stopMeasure('test');


        // return $mainobjects;
        // Debugbar::startMeasure('test1', 'test1');

        foreach ($mainobjects as $mainObject) {
            $mainObject = $this->setValuesToTopObject($mainObject);
        }




         return view('mainobjects.index', compact(
                'mainobjects',
                'tableColumns',
                'data',
                'inputs',
                'searchDetails',
                'requestedDataString')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mainobjects.create');
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

        // parbaudam, vai ar tadu telefona numuru jau nav db:


        $mainObjs = Mainobject::with(['contacts' => function ($q) {
            $q->with(
                'language',
                'categories',
                'contactDetailValues.contactDetail.options',
                'contactDetailValues.valuesSelectedOption'
            );
        }])
            ->where('phone', 'LIKE', '%' . $data['phone'] . '%')
            ->get();
//         return $mainObjs;


        if (!empty($mainObjs) && $mainObjs->count() > 0) {
            $message = [
                'message_type' => 'warning',
                'message_type_value' => true,
                'form_message' => 'Main object exist allready'
            ];

            return $this->showResult($mainObjs, $message);
        }


        $mainObjs = Mainobject::wherehas('contacts', function ($query) use ($data) {
            $query->whereHas('contactDetailValues', function ($q) use ($data) {
                $q->where('value', $data['phone']);
            });
        })
            ->with(['contacts' => function ($query) use ($data) {
                $query->with('language', 'categories')->whereHas('contactDetailValues', function ($q) use ($data) {
                    // $q->where('value', 'LIKE', '%'.$data['phone'].'%');
                    $q->where('value', $data['phone']);
                })
                    ->with('contactDetailValues.contactDetail.options')
                    ->with('contactDetailValues.valuesSelectedOption');
            }])->get();



        // return $mainObjs;
        // te pārbaudam vai kontaktos ir šis telefons


//        return 'problēma';


        $v = Validator::make($data, Mainobject::$rulesOnCreate);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }


        $newMainObject = Mainobject::create($data);

        if (!empty($mainObjs && $mainObjs->count() > 0)) {
            return redirect()->route('mainobjects.index')->with('warning', true)->with('form_message', _('Phone number is used in on or more sub-objects. Main object is ctreated successfully!'));
        }

//        return redirect()->route('mainobjects.index')->with('success', true)->with('form_message', _('Main object is ctreated successfully!'));
        return redirect()->route('contacts.create', ['main-object-id' => $newMainObject->id])->with('success', true)->with('form_message', _('Main object is ctreated successfully!'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {


    //     $mainObjects = Mainobject::with('contacts.language')
    //     ->with('contacts.contactDetailValues.contactDetail.options')
    //     ->with('contacts.contactDetailValues.valuesSelectedOption')

    //     ->with(['contacts.category'=>function($q){
    //         $q->with(['translation'=>function($q){
    //             $q->where('language_id', $this->selectedLanguage->id);
    //         }]);
    //     }])
    //     // ->find($id);
    //     ->whereIn('id', $id)
    //     ->get();

    //     foreach($mainObjects as $mainObject){
    //         $mainObject = $this->setValuesToTopObject($mainObject);
    //     }
    //     return view('mainobjects.show', compact('mainObjects'));
    // }

    public function show($id)
    {
        $mainObjects = Mainobject::with('contacts.language')
            ->with('contacts.contactDetailValues.contactDetail.options')
            ->with('contacts.contactDetailValues.valuesSelectedOption')
            ->with('contacts.contactDetailValues.category.translation')
//            ->with(['contacts.category' => function ($q)
//            {
//                $q->with(['translation' => function ($q)
//                {
//                    $q->where('language_id', $this->selectedLanguage->id);
//                    $q;
//                }]);
//            }])
            // ->find($id);
            ->with('contacts.addresses.city')
            ->with('contacts.addresses.country')
            ->whereIn('id', (array)$id)
            ->get();


        // dd($mainObjects);
//        return $mainObjects;

        return $this->showResult($mainObjects);
    }

    public function showResult($mainObjects, $message = [])
    {


        foreach ($mainObjects as $mainObject) {

            $mainObject = $this->setValuesToTopObject($mainObject);

            $mainObject->contacts->each(function ($contact) {

                $categories = Category::with('translation')->whereIn('id', $contact->category)->get();

                if (!isset($catArray)) {
                    $catArray = [];
                }

                foreach ($categories as $category) {
                    $catArray[] = $category->translation->name;
                }


                $contact->setAttribute('categories', $catArray);
                return $contact;
            });


        }

//        $message = [
//            'message_type'       => 'success',
//            'message_type_value' => true,
//            'form_message'       => 'Main object exist allready'
//        ];

//        dd($message);

        if ($message) {
            Session::flash($message['message_type'], $message['message_type_value']);
            Session::push('flash.old', $message['message_type']);
            Session::flash('form_message', $message['form_message']);
            Session::push('flash.old', 'form_message');

        }

//        dd($mainObjects);

        return view('mainobjects.show', compact('mainObjects'));
    }

    public function setValuesToTopObject($objectWithContacts)
    {


        $objectWithContacts->contacts->each(function ($model, $key) {
            $model->contactDetailValues->each(function ($detailModel, $key1) use ($model) {

                $detailModel->setAttribute($detailModel->contactDetail['name'], $detailModel['value']);

                $detailModel->setAttribute('detail_name', $detailModel->contactDetail['name']);

                $existingValue = $model->getAttribute($detailModel->contactDetail['name']);

                if ($existingValue) {
                    $newValue = array_merge((array)$existingValue, [$detailModel['value']]);

                } else {
                    // pārbaudam vai ir optiono, ja ir, tad liekam izveletea option name nevis ID//
                    if (!count($detailModel->toArray()['values_selected_option'])) {
                        $newValue = [$detailModel['value']];
                    } else {
                        $newValue = [$detailModel->toArray()['values_selected_option']['name']];
                    }
                }


                $model->setAttribute($detailModel->contactDetail['name'], $newValue);

                if (($detailModel->contactDetail['options'])) {
                    $model->setAttribute('options', $detailModel->contactDetail['options']);
                }
            });
        });

        return $objectWithContacts;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mainobjects = Contact::find($id);

        // $stages = Stage::with('contactDetails.inputField', 'contactDetails.options')
        // ->with(['contactDetails.values'=>function($q) use ($id){
        //     $q->where('contact_id', $id)->orderBy('id', 'asc');
        // }])->get();

        $mainobject = Mainobject::find($id);


        return view('mainobjects.edit', compact('mainobject'));
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
        $data = $request->all();


        $v = Validator::make($data, [
            'phone' => 'required|unique:mainobjects,phone,' . $id,
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        Mainobject::find($id)->update($data);

        return redirect()->route('mainobjects.index')->with('success', true)->with('form_message', 'Main object is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($encryptedId)
    {
        $mainObejctId = Crypt::decrypt($encryptedId);
//        dd($mainObejctId);

        $mainObject = Mainobject::find($mainObejctId);

//        dd($mainObject);
//        dd($mainObject->contacts);


        foreach ($mainObject->contacts as $contact) {
            $contact->delete();
        }

        $mainObject->delete();

        return redirect()->route('mainobjects.index')->with('success', true)->with('form_message', 'Main object is deleted successfully!');

    }
}
