<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\Country;
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
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Validation\Validator;
use Image;
use File;
use App\Rating;
use Validator;

//use Intervention\Image\Facades\Image;

class ContactController extends Controller
{


    public $categories;

    public function __construct()
    {
        parent::__construct();

        $this->categories = Category::with(['translations' => function ($q) {
            if(!$this->selectedLanguage){
                $this->selectedLanguage->id = 1;
            }
            $q->where('language_id', $this->selectedLanguage->id);
        }])->get();

    }

    

    public function getCategoryParentId($id, $searchedCategoriesIdsArray = [])
    {

        $searchedCategoriesIdsArray[] = (int)$id;

        $id = $this->categories->filter(function ($cat) use ($id) {
            return $cat->id == $id;
        })->first();

        if ($id) {
            $id = (int)$id->parent_id;
        }

        if ($id == 0) {
            return $searchedCategoriesIdsArray;
        }

        if ($id != 0) {
            return $this->getCategoryParentId($id, $searchedCategoriesIdsArray);
        }

        return $searchedCategoriesIdsArray;
    }

    public function getCategoryChildrenId($id, &$searchedCategoriesIdsArray = [])
    {
        $searchedCategoriesIdsArray[] = (int)$id;

        $idsArray = $this->categories->filter(function ($category) use ($id) {
            return $category->parent_id == $id;
        })->toArray();

        foreach ($idsArray as $id) {
            $this->getCategoryChildrenId($id['id'], $searchedCategoriesIdsArray);
        }

        return $searchedCategoriesIdsArray;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $requestedDataString = null)
    {

//        \Artisan::call('cache:clear');

        $data = $request->all();

        if (isset($data['clear_index_filters'])) {
            $request->session()->forget('sort');
        }

        if (isset($data['sort'])) {
//            $request->session()->forget('sort');
            $request->session()->put('sort', $data['sort']);
        } elseif ($request->session()->has('sort')) {

            $data['sort'] = $request->session()->get('sort');
        }

        $inputs = $data;

        $searchDetails = ContactDetail::where(function ($q) {

            $q->where('is_searchable', 1);

        })->whereNotIn('name', ['video'])
            ->with(['translations' => function ($q) {
                $q->where('language_id', $this->selectedLanguage->id);
            }])
            ->get();


        $contacts = new Contact();

        $data['search_value_what'] = !isset($data['search_value_what']) ? null : $data['search_value_what'];
        $data['search_value_what2'] = !isset($data['search_value_what2']) ? null : $data['search_value_what2'];
        $data['search_value_where'] = !isset($data['search_value_where']) ? null : $data['search_value_where'];
        $data['search_value_category'] = !isset($data['search_value_category']) ? null : $data['search_value_category'];


        if (count(json_decode($data['search_value_what'])) == 0) {
            $data['search_value_what'] = null;
        }

        if (count(json_decode($data['search_value_what2'])) == 0) {
            $data['search_value_what2'] = null;
        }


        if (is_array($data['search_value_category'])) {
            foreach (array_reverse($data['search_value_category']) as $value) {
                if ($value && $value != '' && $value != '-' && !isset($searchedCategoryId)) {
                    $searchedCategoryId = $value;
                }
            }
        } else {
            $searchedCategoryId = null;
        }


        if (isset($searchedCategoryId) && $searchedCategoryId != "") {
            $categoriesChildrenArray = $this->getCategoryChildrenId($searchedCategoryId);
//        dd($categoriesChildrenArray);

            $searchedCategory = Stage::wherehas('contactDetails', function ($q) {
                $q->where('id', 41);
            })
                ->with('contactDetails.inputField', 'contactDetails.options')
                ->with(['translations' => function ($q) {
                    $q->where('language_id', $this->selectedLanguage->id);
                }])
                ->with(['contactDetails.translations' => function ($q) {
                    $q->where('language_id', $this->selectedLanguage->id);
                }])
                ->get();

            foreach ($searchedCategory as $tree) {
                foreach ($tree->contactDetails as $detail) {
                    $val = new Collection();
                    $model = new \App\ContactDetailValue(['contactdetail_id' => "41", 'value' => $searchedCategoryId, 'language_id' => $this->selectedLanguage->id]);
                    $val->add($model);
                    $detail->setRelation('values', $val);
                }
            }

            $searchedCategory = $this->setCategoryParentCategories($searchedCategory);

            $searchedCategory = $searchedCategory->first();


            $searchedCategory = isset($searchedCategory->contactDetails) ? $searchedCategory->contactDetails->first()->values->first() : null;
        }


        if (!isset($searchedCategoryId) || !$searchedCategoryId) {
            $searchedCategory = null;
        }


        if (isset($data['search_detail']) && $data['search_value_what']) {


            if (in_array('42', $data['search_detail'])) /* is tags un-selected [42-tags] */ {
                $contacts = $contacts->whereHas('contactDetailValues', function ($q) use ($data) {
                    $q = $q->whereIn('contactdetail_id', $data['search_detail']);

                    foreach (json_decode($data['search_value_what']) as $what) {
                        $q = $q->where('value', 'LIKE', '%' . $what . '%');
                    }
                });


                $contacts = $contacts->orWhere(function ($q) use ($data) {
                    $q->whereHas('tags', function ($q) use ($data) {
                        foreach (json_decode($data['search_value_what']) as $what) {
                            $q = $q->where('name', 'LIKE', '%' . $what . '%');
                        }
                    });
                });

                // jā ir phone, ad meklējam arī main-objctos
                if (in_array('2', $data['search_detail'])) {
                    $contacts = $contacts->orWhere(function ($q) use ($data) {
                        $q->whereHas('mainobejects', function ($q) use ($data) {
                            foreach (json_decode($data['search_value_what']) as $what) {
                                $q = $q->where('phone', 'LIKE', '%' . $what . '%');
                            }
                        });
                    });
                }


            } else {

                $contacts = $contacts->whereHas('contactDetailValues', function ($q) use ($data) {

                    $q = $q->whereIn('contactdetail_id', $data['search_detail']);

                    foreach (json_decode($data['search_value_what']) as $what) {
                        $q = $q->where('value', 'LIKE', '%' . $what . '%');
                    }

                });

                // jā ir phone, ad meklējam arī main-objctos
                if (in_array('2', $data['search_detail'])) {
                    $contacts = $contacts->orWhere(function ($q) use ($data) {
                        $q->whereHas('mainobejects', function ($q) use ($data) {
                            foreach (json_decode($data['search_value_what']) as $what) {
                                $q = $q->where('phone', 'LIKE', '%' . $what . '%');
                            }
                        });
                    });
                }
            }

        } else {
            $contacts = $contacts->where(function ($q) use ($data) {
                $q->whereHas('contactDetailValues', function ($q) use ($data) {
                    if (!is_array(json_decode($data['search_value_what']))) {
                        $q;
                    } else {
                        foreach (json_decode($data['search_value_what']) as $what) {
                            $q = $q->where('value', 'LIKE', '%' . $what . '%');
                        }
                    }


                })->orWhere(function ($q) use ($data) {
                    $q->whereHas('tags', function ($q) use ($data) {
                        if (!is_array(json_decode($data['search_value_what']))) {
                            $q;
                        } else {
                            foreach (json_decode($data['search_value_what']) as $what) {
                                $q = $q->where('name', 'LIKE', '%' . $what . '%');
                            }
                        }

                    });
                })->orWhere(function ($q) use ($data) {
                    $q->whereHas('mainobejects', function ($q) use ($data) {
                        if (is_array(json_decode($data['search_value_what']))) {
                            foreach (json_decode($data['search_value_what']) as $what) {
                                $q = $q->where('phone', 'LIKE', '%' . $what . '%');
                            }
                        } else {
                            $q;
                        }

                    });
                });
            });

        }


        if (isset($data['search_value_category']) && $data['search_value_category'] && $data['search_value_category'] != '' && isset($categoriesChildrenArray)) {
            $contacts = $contacts->where(function ($q) use ($categoriesChildrenArray) {
                $q->whereHas('contactDetailValues', function ($q) use ($categoriesChildrenArray) {
                    $q->where('contactdetail_id', 41)->whereIn('value', $categoriesChildrenArray);
                });
            });

        }

        if (isset($data['search_value_type']) && $data['search_value_type'] && $data['search_value_type'] != '') {
            $searchedType = $data['search_value_type'];

            $contacts = $contacts->where(function ($q) use ($searchedType) {
                $q->whereHas('contactDetailValues', function ($q) use ($searchedType) {
                    $q->where('contactdetail_id', 3)->where('value', $searchedType);
                });
            });


        }

        if (isset($data['search_value_what2']) && $data['search_value_what2'] && $data['search_value_what2'] != '') {
            $searchedValuesArray = json_decode($data['search_value_what2']);
//            dd($searchedValuesArray);

            $contacts = $contacts->where(function ($q) use ($searchedValuesArray) {

                $q->whereHas('tags', function ($q) use ($searchedValuesArray) {


                    $q->where(function ($q) use ($searchedValuesArray) {
                        $q = $q->where('name', 'qeqwdqwfdwfwefe');

                        foreach ($searchedValuesArray as $searchedValue) {
                            $q = $q->orWhere('name', 'LIKE', '%' . $searchedValue . '%');
                        }
                    });


                });

            });


        }


        if (isset($data['search_value_where']) && $data['search_value_where'] != '') {
            $searchString = $data['search_value_where'];

            $contacts = $contacts->where(function ($q) use ($searchString) {
                $q = $q->whereHas('addresses', function ($q) use ($searchString) {

                    $q->where(function ($q) use ($searchString) {
                        $q->where('marker_address', 'LIKE', '%' . $searchString . '%')
                            ->orWhere('marker_zip', 'LIKE', '%' . $searchString . '%');
                    });

                })->orWhereHas('addresses.city', function ($q) use ($searchString) {
                    $q->where('name', 'LIKE', '%' . $searchString . '%');

                })->orWhereHas('addresses.country', function ($q) use ($searchString) {

                    $q->where('name', 'LIKE', '%' . $searchString . '%');

                });
            });


            $contacts = $contacts
                ->with(['addresses' => function ($q) use ($searchString) {
                    $q->where(function ($q) use ($searchString) {
                        $q->whereHas('city', function ($q) use ($searchString) {
                            $q->where('name', 'LIKE', '%' . $searchString . '%');
                        })
                            ->orWhereHas('country', function ($q) use ($searchString) {
                                $q->where('name', 'LIKE', '%' . $searchString . '%');
                            });
                    })
                        ->orWhere(function ($q) use ($searchString) {
                            $q->where('marker_address', 'LIKE', '%' . $searchString . '%')->orWhere('marker_zip', 'LIKE', '%' . $searchString . '%');
                        })
                        ->with('city')->with('country');
                }]);


        } else {
            $contacts = $contacts
                ->with('addresses.city')
                ->with('addresses.country');
        }


        $contacts = $contacts
            ->select("*")->selectRaw('(quality + communication + accurancy)/3 as rating_overall')
            ->with('contactDetailValues.contactDetail.options.translation')
            ->with('contactDetailValues.valuesSelectedOption')
            ->with('mainobejects')
            ->with('tags')
            ->with('categories')
            ->orderBy('id', 'desc')
//            ->whereId(65)
            ->get();

        $contacts = $contacts->each(function ($contact) {
            $contact->addresses->each(function ($address) {

                $array = explode(',', $address->marker_position);

                if (count($array) == 2) {
                    $address->setAttribute('lat', $array[0]);
                    $address->setAttribute('lng', $array[1]);
                }

                return $address;
            });

            return $contact;
        });

//        return $contacts;


        $contacts = $contacts->each(function ($model, $key) {
            $model->contactDetailValues->each(function ($detailModel, $key1) use ($model) {

                $detailModel->setAttribute($detailModel->contactDetail['name'], $detailModel['value']);

                $detailModel->setAttribute('detail_name', $detailModel->contactDetail['name']);

                $existingValue = $model->getAttribute($detailModel->contactDetail['name']);

                if ($existingValue) {
                    $newValue = array_merge((array)$existingValue, [$detailModel['value']]);
                } else {
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

        $contacts = $contacts->each(function ($contact) {

            $contact = $contact->categories->each(function ($category) use ($contact) {

                $existingParentsCategoryArray = $contact->getAttribute('parent_categories') ? $contact->getAttribute('parent_categories') : [];

                if (!in_array($category->parents, $existingParentsCategoryArray)) {
                    $existingParentsCategoryArray[] = $category->parents;
                }

                $contact->setAttribute('parent_categories', $existingParentsCategoryArray);
                return $category;
            });

            return $contact;
        });


//        return $contacts;


        if (isset($data['sort'])) {
            if ($data['sort'] == 'rating_a') {
                $contacts = $contacts->sortBy('rating_overall');
            } elseif ($data['sort'] == 'rating_d') {
                $contacts = $contacts->sortByDesc('rating_overall');
            } elseif ($data['sort'] == 'title_a') {
                $contacts = $contacts->sortBy('title.0');
            } elseif ($data['sort'] == 'title_d') {
                $contacts = $contacts->sortByDesc('title.0');
            } elseif ($data['sort'] == 'date_a') {
                $contacts = $contacts->sortBy('created_at');
            } elseif ($data['sort'] == 'date_d') {
                $contacts = $contacts->sortByDesc('created_at');
            }
        }


        $start = $request->has('page') && is_int((int)$request->get('page')) ? ($request->get('page') - 1) * config('constants.PAGINATE_PER_PAGE') : 0;
        $end = $start + config('constants.PAGINATE_PER_PAGE');

        $contactArray = $contacts->toArray();
        $contacts0 = array_slice($contactArray, $start, $end);

        $params = $request->except('page');
        $path = route($request->route()->getName(), $params);

        //        public function __construct($items, $total, $perPage, $currentPage = null, array $options = [])
        $contacts = new LengthAwarePaginator($contacts0, $contacts->count(), config('constants.PAGINATE_PER_PAGE'), null, ['path' => $path]);

        $detail = ContactDetail::find(41); // 41 -> category


        $detail->setRelation('top_categories', ['options' => Category::top()->get()]);

        $contactTypes = ContactDetail::with('options.translation')->find(3);


//        return $contacts->where('id', 44);


//        return $contactTypes;


//        return $contacts;

        return view('contacts.index', compact('contacts', 'tableColumns', 'tableColumnsTranslation', 'data', 'inputs', 'searchDetails',
            'requestedDataString', 'detail', 'searchedCategory', 'contactTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topCategories = Category::top()->with('brothers')->first();

        $stages = Stage::with('contactDetails.inputField', 'contactDetails.options')
            ->with(['contactDetails.values' => function ($q) {
                $q->where('contact_id', '23dsgdsgsd')->orderBy('id', 'asc');
            }])
            ->get();

        $stages = $stages->filter(function ($stage) {
            return $stage->name != 'Reitingi';
        });

        $categories = [];


        $contactDetailValues = ContactDetailValue::where('contact_id', 'eqeqe')->get();
        $stages = $this->setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues);

        $stages = $this->setCategoryParentCategories($stages);
        $mainObjects = MainObject::get();

        $countries = Country::orderBy('name')->get();

        foreach ($this->languages as $language) {
            $tagList[$language->id] = '';
        }


        $tagListAllCollection = Tag::orderBy('name')->get();

        $tagListAll = [];
        foreach ($this->languages as $language) {
            $tagListAll[$language->id] = $tagListAllCollection->filter(function ($tag) use ($language) {
                return $tag->language_id == $language->id;
            });
        }

//        return $stages;

        return view('contacts.create', compact('stages', 'mainObjects', 'categoryArrayTree', 'tagList', 'tagListAll', 'countries', 'showAverageRating', 'showRatingDataInForm', 'topCategories', 'categories'));
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


        if (!isset($data['mainobject_id'])) {
            return 'Error: mainobject_id data missing!';
        }

        $mainObject = Mainobject::find($data['mainobject_id']);


        if (empty($mainObject)) {
            return 'Error: mainobject_id not exist!';
        }

        $data['mainobject_id'] = $mainObject->id;

        $contact = new Contact();

        $contact->language_id = $data['language_id'];
        $contact->mainobject_id = $data['mainobject_id'];


        $contact->save();

        $this->inserContactValues($contact->id, $data);

        return redirect()->route('contacts.index')->with('success', true)->with('form_message', 'Contact is ctreated successfully!');


    }

    public function storeRequest(Request $request, $contactId, $requestId)
    {
        $data = $request->all();


        if (isset($data['parent_id'])) {

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
        $contact = Contact::select("*")->selectRaw('(quality + communication + accurancy)/3 as rating_overall')
            ->with(['tags' => function ($q) {
                $q;
            }])
            ->with(['rating' => function ($q) {
                $q->whereNotNull('complete_date')->with('user')->orderBy('id', 'desc');
            }])->with(['addresses.city', 'addresses.country'])
            ->with('contactDetailValues.contactDetail.options')
            ->with(['mainobejects.contacts.contactDetailValue' => function ($q) {
                $q->where('contactdetail_id', '4');
            }])
            ->find($id);


//        return $contact;

        $contact->addresses->each(function ($address) {

            $array = explode(',', $address->marker_position);

            $address->setAttribute('lat', $array[0]);
            $address->setAttribute('lng', $array[1]);

            return $address;
        });

        $contact->contactDetailValues->each(function ($value, $key) use ($contact) {
            $field = $contact->getAttribute($value->contactDetail->name);
            if ($field) {
                $field = is_array($field) ? $field : [$field];
            } else {
                [];
            }

            if ($value->contactDetail->options->count() > 0) {
                $selectedOptionId = $value->value;
                $val = $value->contactDetail->options->filter(function ($option) use ($selectedOptionId) {
                    return $option->id == $selectedOptionId;
                });

                $newVal = isset($val->first()->name) ? $val->first()->name : _('option do nt exist or is deleted');
            } else {
                $newVal = $value->value;
            }


            $field[] = $newVal;

            $contact->setAttribute($value->contactDetail->name, $field);

            return $value;
        });

//        return $contact;


//        $mainObjects = MainObject::get();

        $stages = Stage::with('contactDetails.inputField', 'contactDetails.options')
            ->with(['contactDetails.translation' => function ($q) {
                $q->where('language_id', $this->selectedLanguage->id);
            }])
            ->with(['contactDetails.values' => function ($q) use ($id) {
                $q->where('contact_id', $id)->orderBy('id', 'asc');
            }])
            ->get();

        $stages = $stages->each(function ($stage) {
            $stage = $stage->contactDetails->each(function ($detail) {
                if ($detail->name == 'comment') {
                    $detail->values = $detail->values->sortByDesc('id');
                }
                return $detail;
            });
            return $stage;
        });

//        return $stages[3];
//        return $stages;
        $contactDetailValues = ContactDetailValue::where('contact_id', $id)->get();


        $stages = $this->setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues);

//        $stages = $this->setCategoryParentCategories($stages);

        foreach ($this->languages as $language) {
            $tagList[$language->id] = $contact->tags->filter(function ($model) use ($language) {
                return $model->language_id == $language->id;
            });

            $tagList[$language->id] = implode(',', $tagList[$language->id]->pluck('name', 'id')->toArray());
        }

        foreach ($contact->rating as $rating) {
            if (isset($rating->user->id)) {
                $rating->author_name = 'Admin: ' . $rating->user->name;
            }
        }

        $selectedCategories = Category::whereHas('contactValues', function ($q) use ($id) {
            $q->where('contact_id', $id);
        })
//            ->with('parents')
            ->with('parentCategory.parentCategory.parentCategory.parentCategory')
            ->with('brothers')
            ->get();

//        $topCategories = Category::top()->with('brothers')->first();

        $categories = [];


        $selectedCategories->each(function ($category, $key) use (&$categories) {
            $categories[$category->parent_id]['selectedIds'][] = $category->id;
            $categories[$category->parent_id]['parent'] = $category->parentCategory;
            $categories[$category->parent_id]['brothers'] = $category->brothers;

        });

//        return $contact;

//        return $categories;


        return view('contacts.show', compact('contact', 'stages', 'tagList', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $selectedCategories = Category::whereHas('contactValues', function ($q) use ($id) {
            $q->where('contact_id', $id);
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

//        return $categories;
//        dd($categories);


        $contact = Contact::with(['tags'])
            ->with('rating')
            ->with('mainobejects')
            ->find($id);

        $mainObjects = MainObject::get();

        $stages = Stage::with('contactDetails.inputField', 'contactDetails.options')
            ->with(['translation' => function ($q) {
                $q->where('language_id', $this->selectedLanguage->id);
            }])
            ->with(['contactDetails.translation' => function ($q) {
                $q->where('language_id', $this->selectedLanguage->id);
            }])
            ->with(['contactDetails.values' => function ($q) use ($id) {

                $q->where('contact_id', $id)->orderBy('id', 'asc');
            }])
            ->get();

        $stages = $stages->filter(function ($stage) {
            return $stage->name != 'Reitingi';
        });


        $stages = $stages->each(function ($stage) {
            $stage = $stage->contactDetails->each(function ($detail) {
                if ($detail->name == 'comment') {
                    $detail->values = $detail->values->sortByDesc('id');
                }
                return $detail;
            });
            return $stage;
        });

//        dd($stages->last()->contactDetails);


        $contactDetailValues = ContactDetailValue::where('contact_id', $id)->get();


        $countries = Country::orderBy('name')->get();

        $addresses = Address::with('country.cities', 'city')->where('contact_id', $id)->get();

        $stages = $this->setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues);

        $stages = $this->setCategoryParentCategories($stages);

        foreach ($this->languages as $language) {
            $tagList[$language->id] = $contact->tags->filter(function ($model) use ($language) {
                return $model->language_id == $language->id;
            });


            $tagList[$language->id] = $tagList[$language->id]->pluck('id')->toArray();
        }


        $tagListAllCollection = Tag::orderBy('name')->get();

        $tagListAll = [];
        foreach ($this->languages as $language) {
            $tagListAll[$language->id] = $tagListAllCollection->filter(function ($tag) use ($language) {
                return $tag->language_id == $language->id;
            });
        }

//        return $categories;
//        return $contact;

//        $categories =[];


//        dd($stages->last());


        return view('contacts.edit',
            compact('contact', 'stages', 'mainObjects', 'categoryArrayTree', 'tagList', 'tagListAll', 'countries', 'showAverageRating',
                'showRatingDataInForm', 'addresses', 'categories', 'topCategories'));

    }

    public function setCategoryParents($category)
    {

        $parentCat = Category::with('parentsParent')->find($category->id);
        dd($parentCat->parents->children);

        return $category->setAttribute('parent', $parentCat);
    }

    public function setTranslatableFieldsIfNotTranslations($stages, $contactDetailValues)
    {

        /** @var Collection $stages */
        $stages = $stages->each(function ($stage, $stageId) use ($contactDetailValues) {

            $stage->contactDetails->each(function ($detail, $detailId) use ($stage, &$contactDetailsCollection, $contactDetailValues, $stageId) {
                $detail->order = (int)$detail->order;
                if ($detail['is_translatable'] == 1) {
                    // pārbaudam cik ir values!
                    foreach ($this->languages as $language) {

                        if (!in_array($language->id, $detail->values->pluck('language_id')->toArray())) {
                            $array = [
                                'contact_id' => '',
                                'contactdetail_id' => '',
                                'language_id' => $language->id,
                                'value' => ''

                            ];
                            $model = new ContactDetailValue($array);
                            $detail->values[] = $model;
                        }
                    }

                }

                return $detail;
            });

            return $stage;
        });

        return $stages;
    }

    public function setCategoryParentCategories($stages)
    {
        if (!$stages) {
            dd($stages);
        }


        $stages = $stages->each(function ($stage, $stageId) {
            $stage = $stage->contactDetails->each(function ($detail, $detailId) use ($stage) {
                if ($detail->model == 'Category') {
                    $detail->setAttribute('top_categories', ['options' => $this->setOptions(0)]);

                    $detail = $detail->values->each(function ($value) {

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


        $category = $this->categories->find($value->value);

        if (!empty($category)) {
            $value->setAttribute('translations', $category->translation);
        }

        return $value;
    }

    public function setParentCategory($value)
    {

        $category = $this->categories->find($value->value);

        if (!empty($category)) {
            $parentCategory = $this->categories->find($category->parent_id);

            if (!empty($parentCategory)) {
                $value->setAttribute('parent', $parentCategory);
                $value->parent->setAttribute('value', $parentCategory->id);
                $value->parent = $this->setCategoryValue($value->parent);

                $value->parent = $this->setParentCategory($value->parent);
                $value->setAttribute('options', $this->setOptions($parentCategory->id));
            } else {
                $value->setAttribute('options', $this->setOptions(0));
            }
        }

        return $value;
    }

    public function setOptions($id)
    {
        $categories = $this->categories->filter(function ($category) use ($id) {
            return $category->parent_id == $id;
        });

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
    public function update(Request $request, $id, $adminProcessSave = false)
    {


        $data = $request->all();

//        dd($data['selected_categories']);
//        return $data;
//            dd($data);
        $contact = Contact::find($id);

        $contact->update($data);

        $this->inserContactValues($contact->id, $data);

        if ($adminProcessSave) {
            return;
        }


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

    public function commentStore($contactId, Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'comment' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data['contactdetail_id'] = 36;
        $data['contact_id'] = $contactId;
        $data['value'] = $data['comment'];
        ContactDetailValue::create($data);
        return redirect()->route('contacts.show', $contactId)->with('success', true)->with('form_message', _('Comment is added successfully'));
    }


    public function inserContactValues($id, $data)
    {
        if (isset($data['contact_detail'])) {
            foreach ($data['contact_detail'] as $contactDetailId => $valueArray) {

                $detail = ContactDetail::with('inputField')->find($contactDetailId);

                $array['contact_id'] = $id;
                $array['contactdetail_id'] = $contactDetailId;


                // Tags sākas  ---->

                if ($detail->inputField->name == 'tags') {

                    $allExistingTagsInDb = Tag::get()->pluck('id')->toArray();
                    $tagsForSync = [];
                    foreach ($valueArray['translated'] as $tagsArray) {
                        $langId = $tagsArray['language_id'];
                        unset($tagsArray['language_id']);

                        // iegūstam vērtības [], kas abos [] ir vienādas
                        $newExistingTagArray = array_intersect($tagsArray, $allExistingTagsInDb);

                        $tagsForSync = array_merge($tagsForSync, is_array($newExistingTagArray) ? $newExistingTagArray : []);

                        // pārbaudam, vai nav pievienoti jaunin tagi []
                        $newTagsNotExistingArray = array_diff($tagsArray, $allExistingTagsInDb);

                        foreach ($newTagsNotExistingArray as $newTag) {
                            $tag = Tag::create(['name' => $newTag, 'language_id' => $langId]);
                            $tagsForSync[] = (string)$tag->id;
                        }

                    }

                    Contact::find($id)->tags()->sync(isset($tagsForSync) ? $tagsForSync : []);
                }
                // Tags beidzās ---<


                $contactDetail = ContactDetail::find($contactDetailId);

                if (isset($valueArray['delete_values_id'])) {
                    foreach ($valueArray['delete_values_id'] as $valId) {
                        $contactValue = ContactDetailValue::find($valId);
                        $pathToImage = public_path('/') . $contactValue['value'];
                        File::delete($pathToImage);
                        if (is_object($contactValue)) {
                            $contactValue->delete();
                        }
                    }
                }


                if ($contactDetail['is_uniq_value'] == 1) {

                    if (isset($valueArray['val'])) {
                        $contactValue = ContactDetailValue::find(isset($valueArray['values_id'][0]) ? $valueArray['values_id'][0] : 'qsdqd');
                        if (empty($contactValue)) {
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

                } else if ($contactDetail['is_collectable'] == 1) {

                    if (isset($valueArray['val'])) {
                        foreach ($valueArray['val'] as $key => $value) {

                            if ($value != '') {
                                if (isset($valueArray['values_id'][$key])) {
                                    $contactValue = ContactDetailValue::find($valueArray['values_id'][$key]);
                                }
                                if (empty($contactValue)) {
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
                } else if ($contactDetail->inputField->name == 'file') {
                    if (isset($valueArray['val'])) {
                        foreach ($valueArray['val'] as $key => $value) {

//                            dd($value);
                            if (is_file($value)) {
                                if (!is_object($value)) {
                                    $value = new UploadedFile($value, $value);
                                }
//                                dd($value);

                                $filename = time() . '-' . uniqid() . '.' . $value->getClientOriginalExtension();

                                $path0 = 'uploads/files/' . $filename;
                                $path1 = public_path($path0);

                                $img = Image::make($value);
                                $img->save($path1);

                                \File::delete($value);

                                $contactValue = new ContactDetailValue();
                                $contactValue->value = $path0;
                                $contactValue->contact_id = $id;
                                $contactValue->contactdetail_id = $contactDetail->id;
                                $contactValue->save();
                            }

                        }
                    }
                } else {
                    if (isset($valueArray['val'])) {
                        $ContactDetailValueIdsArray = [];
                        foreach ($valueArray['val'] as $key => $value) {
                            if ($value != '') {
                                $contactValue = ContactDetailValue::find(isset($valueArray['values_id'][$key]) ? $valueArray['values_id'][$key] : 'qqdqdqdqd');
                                if (empty($contactValue)) {
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
        ) {
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


        if (isset($data['markers'])) {
//
//            $address = Address::get();
//           foreach($address as $adrr){
//               $adrr->delete();
//           }

            $contactExistingAddresesInDbArray = Address::where('contact_id', $id)->get()->pluck('id', 'id')->toArray();

//            dd($contactExistingAddresesInDbArray);

//            dd($data['markers']);
            foreach ($data['markers']['address_id'] as $key => $addressId) {
                if ($addressId != '' && $addressId != 0) {
                    $address = Address::find($addressId);
                    $updatedAddresesIds[$addressId] = $addressId;
                } else {
                    $address = new Address();
                    $address->contact_id = $id;
                }

//                if (isset($data['markers']['marker_address'][$key]) && $data['markers']['marker_address'][$key] != '') {
                if (isset($data['markers']['city_id'][$key]) && $data['markers']['city_id'][$key] != '') {
                    $address->country_id = $data['markers']['country_id'][$key];
                    $address->city_id = isset($data['markers']['city_id'][$key]) ? $data['markers']['city_id'][$key] : null;
                    $address->map_center = isset($data['markers']['map_center'][$key]) ? $data['markers']['map_center'][$key] : null;
                    $address->map_zoom = isset($data['markers']['map_zoom'][$key]) ? $data['markers']['map_zoom'][$key] : null;
                    $address->marker_position = isset($data['markers']['marker_position'][$key]) ? $data['markers']['marker_position'][$key] : null;

                    $address->marker_city = isset($data['markers']['marker_city'][$key]) ? $data['markers']['marker_city'][$key] : null;
                    $address->marker_address = isset($data['markers']['marker_address'][$key]) ? $data['markers']['marker_address'][$key] : null;
                    $address->marker_zip = isset($data['markers']['marker_zip'][$key]) ? $data['markers']['marker_zip'][$key] : null;

                    $address->save();
                }

            }

//            dd($data['markers']);
//            echo '<pre>';
//            var_dump($contactExistingAddresesInDbArray);
//            echo '</pre>';
//
//            echo '<pre>';
//            var_dump($updatedAddresesIds);
//            echo '</pre>';


            $arrayToDelete = array_except(isset($contactExistingAddresesInDbArray) ? $contactExistingAddresesInDbArray : [], isset($updatedAddresesIds) ? $updatedAddresesIds : []);
//            dd($arrayToDelete);
//            $arrayToDelete;


            Address::where('contact_id', $id)->whereIn('id', $arrayToDelete)->delete();


        }

//        dd($data['selected_categories']);

        //categories
        if (isset($data['selected_categories'])) // ja tiek nodots contactdetail_id 41, kas ir kategorija
        {
            ContactDetailValue::where('contact_id', $id)->where('contactdetail_id', 41)->delete();
            if (isset($data['selected_categories'])) {

                $data['selected_categories'] = array_unique($data['selected_categories']);
                foreach ($data['selected_categories'] as $category) {
                    $array = [
                        'contact_id' => $id,
                        'contactdetail_id' => 41,
                        'value' => $category,

                    ];
                    ContactDetailValue::create($array);
                }
            }

        }


    }

    public function sendMailCreate($contactId)
    {

        $contact = Contact::with(['contactDetailValues' => function ($q) {
            $q->whereHas('contactDetail', function ($q) {
                $q->where('name', 'e-mail');
            });
        }])->find($contactId);

        $emails = $contact->contactDetailValues->pluck('value')->toArray();

        foreach ($emails as $key => $email) {
            $emails[$key] = '"' . $email . '"';
        }

        $emails = implode(',', $emails);

        return view('contacts.mail.create', compact('emails', 'contact'));

    }

    public function sendMailSend($contactId, Request $request)
    {
        $data = $request->all();

        $emails = trim($data['emails_list'], '[]');
        $emails = str_replace('"', '', $emails);
        $emails = explode(',', $emails);

        Mail::send('emails.send-message-to-contact', ['data' => $data], function ($m) use ($emails, $data) {
            $m->from('no-replay@app.com', confog('constants.APP_NAME'));

            foreach ($emails as $email) {
                $m->to($email, '"' . $email . '"');
            }

            $m->subject(isset($data['subject']) ? $data['subject'] : _('No subject'));

        });

        return redirect()->route('contacts.show', $contactId)->with('success', true)->with('form_message', _('Message (mail) is sent successfully'));
    }
}


