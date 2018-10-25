<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Contact;
use App\Stage;
use App\ContactDetailValue;
use Debugbar;
use App\ContactDetail;
use App\Mainobject;
use App\Tag;
use App\InputField;
use Image;
use File;
use App\Rating;

//use Intervention\Image\Facades\Image;

class ContactController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $requestedDataString = null)
    {


        $data = $request->all();

        $inputs = $data;


        $stages = Stage::with('contactDetails')->get();

        foreach ($stages[0]->contactDetails as $key => $detail)
        {
            $tableColumns[$key] = $detail['name'];
        }

        $searchDetails = ContactDetail::whereIn('input_field_id', [1, 2])->get();

        $contacts = new Contact();


        $data['search_value'] = !isset($data['search_value']) ? null : $data['search_value'];


        if (isset($data['search_detail']) && $data['search_value'])
        {
            $contacts = $contacts
                ->whereHas('contactDetailValues', function ($q) use ($data)
                {
                    $q->whereIn('contactdetail_id', $data['search_detail'])
                        ->where('value', 'LIKE', '%' . $data['search_value'] . '%');
                });
        } else
        {
            $contacts = $contacts
                ->whereHas('contactDetailValues', function ($q) use ($data)
                {
                    $q->where('value', 'LIKE', '%' . $data['search_value'] . '%');
                });
        }

        $contacts = $contacts
            ->with('contactDetailValues.contactDetail.options')
            ->with('contactDetailValues.valuesSelectedOption')
            ->get();


        $contacts = $contacts->each(function ($model, $key)
        {
            $model->contactDetailValues->each(function ($detailModel, $key1) use ($model)
            {

                $detailModel->setAttribute($detailModel->contactDetail['name'], $detailModel['value']);

                $detailModel->setAttribute('detail_name', $detailModel->contactDetail['name']);

                $existingValue = $model->getAttribute($detailModel->contactDetail['name']);

                if ($existingValue)
                {
                    $newValue = array_merge((array)$existingValue, [$detailModel['value']]);

                } else
                {
                    if (!count($detailModel->toArray()['values_selected_option']))
                    {
                        $newValue = [$detailModel['value']];
                    } else
                    {
                        $newValue = [$detailModel->toArray()['values_selected_option']['name']];
                    }
                }

                $model->setAttribute($detailModel->contactDetail['name'], $newValue);

                if (($detailModel->contactDetail['options']))
                {
                    $model->setAttribute('options', $detailModel->contactDetail['options']);
                }
            });
        });

        return view('contacts.index', compact('contacts', 'tableColumns', 'data', 'inputs', 'searchDetails', 'requestedDataString'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $stages = Stage::with('contactDetails.inputField', 'contactDetails.options')
//            ->get();

        $stages = Stage::with('contactDetails.inputField', 'contactDetails.options')
            ->with(['contactDetails.values' => function ($q)
            {
                $q->where('contact_id', '23dsgdsgsd')->orderBy('id', 'asc');
            }])
            ->get();


        $contactDetailValues = ContactDetailValue::where('contact_id', 'eqeqe')->get();
        $stages = $this->setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues);

        $stages = $this->setCategoryParentCategories($stages);
        $mainObjects = MainObject::get();

//        $categoryArrayTree = (new CategoryController)->getCategoryArrayTree(0, true);

        foreach ($this->languages as $language)
        {
            $tagList[$language->id] = '';
        }

        return view('contacts.create', compact('stages', 'mainObjects', 'categoryArrayTree', 'tagList'));
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
//         return $data;

//        $data['category_id'] = $data['parent_id'];

//        return $data;

        if (!isset($data['mainobject_id']))
        {
            return 'Error: mainobject_id data missing!';
        }

        $mainObject = Mainobject::find($data['mainobject_id']);


        if (empty($mainObject))
        {
            return 'Error: mainobject_id not exist!';
        }

        $data['mainobject_id'] = $mainObject->id;

        $contact = new Contact();

//        $contact = $contact->insert($request->only('language_id', 'mainobject_id', 'category_id', 'name'));
//        $contact = $contact->create($data);

        $contact->language_id = $data['language_id'];
        $contact->mainobject_id = $data['mainobject_id'];


        $contact->save();

        $this->inserContactValues($contact->id, $data);

        return redirect()->route('contacts.index')->with('success', true)->with('form_message', 'Contact is ctreated successfully!');


    }

    public function storeRequest(Request $request, $contactId, $requestId)
    {
        $data = $request->all();


        if (isset($data['parent_id']))
        {

            $data['category_id'] = $data['parent_id'];
        }


        $data['request_id'] = $requestId;


        $contact = Contact::find($contactId);

        $this->inserContactValues($contact->id, $data);

        return;

        // return redirect()->route('contacts.index')->with('success', true)->with('form_message', 'Contact is ctreated successfully!');


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $contact = Contact::with(['tags' => function ($q)
        {
            /*
            $q->where('language_id', $this->selectedLanguage->id);
            */
            $q;
        }])
            ->with('rating')
            ->find($id);

        $mainObjects = MainObject::get();

        $stages = Stage::with('contactDetails.inputField', 'contactDetails.options')
            ->with(['contactDetails.values' => function ($q) use ($id)
            {
                $q->where('contact_id', $id)->orderBy('id', 'asc');
            }])
            ->get();

        $contactDetailValues = ContactDetailValue::where('contact_id', $id)->get();


        $stages = $this->setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues);

        $stages = $this->setCategoryParentCategories($stages);

//        return $stages;

        foreach ($this->languages as $language)
        {
            $tagList[$language->id] = $contact->tags->filter(function ($model) use ($language)
            {
                return $model->language_id == $language->id;
            });

            $tagList[$language->id] = implode(',', $tagList[$language->id]->pluck('name', 'id')->toArray());
        }

//        $categoryArrayTree = (new CategoryController)->getCategoryArrayTree($contact->category_id, true);
        $categoryArrayTree = '';// sisvairāk nav vajadzīgs!


        return view('contacts.edit', compact('contact', 'stages', 'mainObjects', 'categoryArrayTree', 'tagList'));

    }

    public function setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues)
    {
//        return 123;
        //pārbaudam, vai ja details == is_translatable un nav kādas valodas, tad to pievienojam tukšu masīvā!!!
//        dd(444);
//        dd($stages);
        /** @var Collection $stages */
        $stages = $stages->each(function ($stage, $stageId) use ($contactDetailValues)
        {
            $contactDetailsCollection = collect();
            $contactDetailsCollection = $stage->contactDetails;



            $stage->contactDetails->each(function ($detail, $detailId) use ($stage, &$contactDetailsCollection, $contactDetailValues, $stageId)
            {
                $detail->order = (int)$detail->order;
                if ($detail['is_translatable'] == 1)
                {
                    //pārbaudam, vai modelīm ir values visās valodās, ja nav, tad pievienojam tukšas values!

                    $contDetValues = $contactDetailValues->filter(function ($value) use ($detail)
                    {
                        return $value->contactdetail_id == $detail->id;
                    });

                    //esam ieguvuši konkrētās detaļas visas values,
                    //tagad iesim cauri iegūtajām valuem un salidzinasim ar sistēmā esošajām valodām

                    foreach ($this->languages as $language)
                    {
                        //var_dump($contDetValues );
                        if (!in_array($language['id'], $contDetValues->pluck('language_id')->toArray()))
                        {
                            // ja konkrētai valodai nav datubāzē values, tad mēs to izveidojam modelī

                            // $contactDetailsValueCollectio

                            $detailCollection = new ContactDetail;
                            $detailCollection->setAttribute('id', $detail->id);
                            $detailCollection->setAttribute('stage_id', $detail->stage_id);

                            $detailCollection->setAttribute('input_field_id', $detail->input_field_id);
                            $detailCollection->setAttribute('parent_id', $detail->parent_id);
                            $detailCollection->setAttribute('model', $detail->model);
                            $detailCollection->setAttribute('is_translatable', $detail->is_translatable);
                            $detailCollection->setAttribute('is_collectable', $detail->is_collectable);
                            $detailCollection->setAttribute('is_uniq_value', $detail->is_uniq_value);
                            $detailCollection->setAttribute('name', $detail->name);
                            $detailCollection->setAttribute('order', (float)$detail->order + 0.1);
                            $detailCollection->setAttribute('values', [[
                                "id"               => str_random(5),
                                "contact_id"       => "",
                                "contactdetail_id" => $detail->id,
                                "language_id"      => $language->id,
                                "value"            => null
                            ]]);

                            $inputFieldCollection = new \App\InputField();
                            $inputFieldCollection->setAttribute('id', $detail->inputField->id);
                            $inputFieldCollection->setAttribute('name', $detail->inputField->name);

                            $contactDetailsValuesCollection = new ContactDetailValue();
                            $contactDetailsValuesCollection->setAttribute('id', str_random(5));
                            $contactDetailsValuesCollection->setAttribute('contact_id', '');
                            $contactDetailsValuesCollection->setAttribute('contactdetail_id', $detail->id);
                            $contactDetailsValuesCollection->setAttribute('language_id', $language->id);
                            $contactDetailsValuesCollection->setAttribute('value', null);

                            $detailCollection->setRelation('inputField', $inputFieldCollection);

                            $contactDetailsCollection->push($detailCollection);
                        }
                    }

                }

                return $detail;
            });

            $contactDetailsCollection = $contactDetailsCollection->filter(function ($detail)
            {
                if ($detail['is_translatable'] == 1 && count($detail->values) == 0)
                {
                    return false;
                } else
                {
                    return true;
                }
            });


            $coll = $contactDetailsCollection->sortBy('order');


            $stage->setRelation('contactDetails', $coll);
//            $stage->setAttribute('contactDetails', $coll);
//            dd($stage->contactDetailsMy);
//            var_dump($stage);die;
            return $stage;
        });
//        dd($stages);
//        var_dump($stages);die;



        return $stages;
    }

    public function setCategoryParentCategories($stages)
    {
        $stages = $stages->each(function ($stage, $stageId)
        {
            $stage = $stage->contactDetails->each(function ($detail, $detailId) use ($stage)
            {
                if ($detail->model == 'Category')
                {


                    $detail->setAttribute('top_categories', ['options' => $this->setOptions(0)]);

                    $detail = $detail->values->each(function ($value)
                    {
                        $value = $this->setCategoryValue($value);
                        $value = $this->setParentCategory($value);

                        return $value;
                    });


                }


                return $detail;
            });

            return $stage;
        });

        return $stages;
    }

    public function setCategoryValue($value)
    {
        $category = Category::with(['translation' => function ($q)
        {
            $q->where('language_id', $this->selectedLanguage->id);
        }])->find($value->value);
        if (!empty($category))
        {
            $value->setAttribute('translations', $category->translation);
        }

        return $value;
    }

    public function setParentCategory($value)
    {
        $category = Category::find($value->value);
        if (!empty($category))
        {
            $parentCategory = Category::find($category->parent_id);
            if (!empty($parentCategory))
            {
                $value->setAttribute('parent', $parentCategory);
                $value->parent->setAttribute('value', $parentCategory->id);
                $value->parent = $this->setCategoryValue($value->parent);

                $value->parent = $this->setParentCategory($value->parent);
                $value->setAttribute('options', $this->setOptions($parentCategory->id));
            } else
            {
                $value->setAttribute('options', $this->setOptions(0));
            }
        }

        return $value;
    }

    public function setOptions($id)
    {
        $categories = Category::with(['translation' => function ($q)
        {
            $q->where('language_id', $this->selectedLanguage->id);
        }])->where('parent_id', $id)->get();

        return $categories;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id, $backRoute = null, $requestId = null)
    public function update(Request $request, $id)
    {


        $data = $request->all();
//         return $data;

        $contact = Contact::find($id);

        $contact->update($data);


        $this->inserContactValues($contact->id, $data);


        return redirect()->route('contacts.index')->with('success', true)->with('form_message', 'Contact is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decryptedId = \Crypt::decrypt($id);
        $contact = Contact::find($decryptedId);
        $contact->contactDetailValues()->delete();
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', true)->with('form_message', 'Contact is deleted successfully!');


    }


    public function inserContactValues($id, $data)
    {
        if(isset($data['contact_detail']))
        {
            foreach ($data['contact_detail'] as $contactDetailId => $valueArray)
            {

                $detail = ContactDetail::with('inputField')->find($contactDetailId);

                $array['contact_id'] = $id;
                $array['contactdetail_id'] = $contactDetailId;

                $filteredArray = [];


                // Tags sākas  ---->
                $tagArray = [];
                if ($detail->inputField->name == 'tags')
                {
                    foreach ($valueArray['translated'] as $tagString)
                    {

                        $tags = explode(',', $tagString[0]);

                        foreach ($tags as $tagName)
                        {

                            if ($tagName != '')
                            {
                                $tagName = trim(strtolower($tagName));
                                $tag = Tag::where('name', $tagName)->where('language_id', $tagString['language_id'])->first();

                                if (empty($tag))
                                {
                                    $arr = [
                                        'name'        => $tagName,
                                        'language_id' => $tagString['language_id']
                                    ];
                                    $tag = new Tag();
                                    $tag = $tag->create($arr);
                                }

                                $tagsArray[] = $tag->id;

                            }
                        }

                        Contact::find($id)->tags()->sync(isset($tagsArray) ? $tagsArray : []);
                    }
                }
                // Tags beidzās ---<


                $contactDetail = ContactDetail::find($contactDetailId);

                if (isset($valueArray['delete_values_id']))
                {
                    foreach ($valueArray['delete_values_id'] as $valId)
                    {
                        $contactValue = ContactDetailValue::find($valId);
                        $pathToImage = public_path('/') . $contactValue['value'];
                        File::delete($pathToImage);
                        $contactValue->delete();
                    }
                }


                if ($contactDetail['is_uniq_value'] == 1)
                {

                    if (isset($valueArray['val']))
                    {
                        $contactValue = ContactDetailValue::find(isset($valueArray['values_id'][0]) ? $valueArray['values_id'][0] : 'qsdqd');
                        if (empty($contactValue))
                        {
                            $contactValue = new ContactDetailValue();
                            $contactValue->contact_id = $id;
                            $contactValue->contactdetail_id = $contactDetail->id;
                        }
                        $contactValue->value = $valueArray['val'][0];
                        $contactValue->save();
                    }

                    ContactDetailValue::where('contact_id', $id)
                        ->where('id', '!=', $contactValue->id)
                        ->where('contactdetail_id', $contactDetailId)
                        ->delete();

                } else if ($contactDetail['is_collectable'] == 1)
                {

                    if (isset($valueArray['val']))
                    {
                        foreach ($valueArray['val'] as $key => $value)
                        {

                            if ($value != '')
                            {
                                if (isset($valueArray['values_id'][$key]))
                                {
                                    $contactValue = ContactDetailValue::find($valueArray['values_id'][$key]);
                                }
                                if (empty($contactValue))
                                {
                                    $contactValue = new ContactDetailValue();
                                }
                                $contactValue->value = $value;
                                $contactValue->contact_id = $id;
                                $contactValue->language_id = isset($valueArray['language_id'][$key]) ? $valueArray['language_id'][$key] : null;
                                $contactValue->contactdetail_id = $contactDetail->id;
                                $contactValue->save();
                            }
                        }

                    }
                } else if ($contactDetail->inputField->name == 'file')
                {
                    if (isset($valueArray['val']))
                    {
                        foreach ($valueArray['val'] as $key => $value)
                        {
                            if (is_file($value))
                            {
                                $filename = time() . '.' . $value->getClientOriginalExtension();

                                $path0 = 'uploads/files/' . $filename;
                                $path1 = public_path($path0);

                                $img = Image::make($value);
                                $img->save($path1);

                                $contactValue = new ContactDetailValue();
                                $contactValue->value = $path0;
                                $contactValue->contact_id = $id;
                                $contactValue->contactdetail_id = $contactDetail->id;
                                $contactValue->save();
                            }

                        }
                    }
                } else
                {
                    if (isset($valueArray['val']))
                    {
                        $ContactDetailValueIdsArray = [];
                        foreach ($valueArray['val'] as $key => $value)
                        {
                            if ($value != '')
                            {
                                $contactValue = ContactDetailValue::find(isset($valueArray['values_id'][$key]) ? $valueArray['values_id'][$key] : 'qqdqdqdqd');
                                if (empty($contactValue))
                                {
                                    $contactValue = new ContactDetailValue();
                                }
                                $contactValue->value = $value;
                                $contactValue->contact_id = $id;
                                $contactValue->contactdetail_id = $contactDetail->id;
                                $contactValue->language_id = isset($valueArray['language_id'][$key]) ? $valueArray['language_id'][$key] : null;
                                $contactValue->save();
                                $ContactDetailValueIdsArray[] = $contactValue->id;
                            }


                        }

                        ContactDetailValue::where('contact_id', $id)
                            ->whereNotIn('id', $ContactDetailValueIdsArray)
                            ->where('contactdetail_id', $contactDetailId)
                            ->delete();

                        unset($ContactDetailValueIdsArray);
                    }
                }

            }
        }
        $ratings = new Rating();
        if (isset($data['author_name'])
            && isset($data['accurancy'])
            && isset($data['quality'])
            && isset($data['communication'])
//            && isset($data['review'])

            && $data['author_name']
            && $data['accurancy']
            && $data['quality']
            && $data['communication']
//            && $data['review']
        )
        {
            $ratings->author_is_legal = $data['author_is_legal'];
            $ratings->author_name = $data['author_name'];
            $ratings->author_phone = $data['author_phone'];
            $ratings->accurancy = $data['accurancy'];
            $ratings->quality = $data['quality'];
            $ratings->communication = $data['communication'];
            $ratings->review = $data['review'];
            $ratings->contact_id = $id;
            $ratings->save();
        }


    }
}


