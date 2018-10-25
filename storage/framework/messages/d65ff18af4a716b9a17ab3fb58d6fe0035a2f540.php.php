<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\CategoryTranslation;
use App\Language;
use Debugbar;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {


        // var 2 


        // Debugbar::startMeasure('render0','with no childern');
        $categories = Category::
        with(['translation'=>function($q){
            $q->where('language_id', $this->selectedLanguage->id);
        }])->
        with('translation')
            ->get();



        $topCategories = $categories->filter(function ($model)
        {
            return $model->parent_id == 0;
        });

        foreach ($topCategories as $key => $category)
        {
            $category['children'] = $this->addChildrenCategories($category['id'], $categories);
        }

        // Debugbar::stopMeasure('render0');

        // return 'qq';
        // return $topCategories;

        $categories = $topCategories;

        return view('categories.index', compact('categories'));
    }

    private function addChildrenCategories($categoryId, $categories)
    {
        $childrenCategories = $categories->filter(function ($model) use ($categoryId, $categories)
        {
            return $model->parent_id == $categoryId;
        });

        foreach ($childrenCategories as $key => $category)
        {
            $category['children'] = $this->addChildrenCategories($category['id'], $categories);
        }

        return $childrenCategories;
    }

    // public function setChildes($child){
    //     $return = $child->setAttribute('children', Category::where('parent_id', $child->id)->with(['translation'=>function($q){
    //         $q->where('language_id', $this->selectedLanguage->id);
    //     }])->get() );

    //     foreach($child['children'] as $child){
    //         $this->setChildes($child);
    //     }
    //     return $return;
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $languages = Language::get();

        $categories = Category::with('translation', 'allChildren')->top()->get();

        $categoryArrayTree = $this->getCategoryArrayTree(0, true);

        // return $categoryArrayTree; 

        return view('categories.create', compact('languages', 'categories', 'categoryArrayTree'));
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
        $data['parent_id'] = $data['category_id'];
        $category = new Category();
        $category = $category->create($data);
        (new CategoryTranslationController)->store($category->id, $data['name']);

        // add "cits" as subcategory
//        $arrayOther = [
//            'slug'      => 'other',
//            'parent_id' => $category->id,
//            'name'      => [
//                '1' => 'Cits',
//                '2' => 'Other',
//                '3' => 'Другой'
//            ]
//        ];
//        $category = $category->create($arrayOther);
//        (new CategoryTranslationController)->store($category->id, $arrayOther['name']);

        return redirect()->route('categories.index')->with('success', true)->with('form_message', 'Category is ctreated successfully!');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::with('translations')->find($id);
//        return $category;

        $translation = [];

        foreach ($category->translations as $translated)
        {
            $translation[$translated->language_id] = $translated['name'];
        }
//        return $translation;

        $categoryArrayTree = $this->getCategoryArrayTree($id, false);

        // dd($categoryArrayTree);
//         return $categoryArrayTree;


        return view('categories.edit', compact('category', 'translation', 'categoryArrayTree'));
    }


    public function parent($id)
    {
        if ($id > 0)
        {
            return Category::find($id);
        }
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

//        return $data;

        $category = Category::find($id);

        $data['parent_id'] = $data['category_id'];

        $category->update($data);

        foreach ($data['name'] as $languageId => $translated)
        {

            $translationId = CategoryTranslation::where('category_id', $category->id)->where('language_id', $languageId)->first()->id;
            (new CategoryTranslationController)->update($translationId, $translated);
        }


        return redirect()->route('categories.index')->with('success', true)->with('form_message', _('Category is updated successfully!') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id =  Crypt::decrypt($id);
        $category = Category::with('translations')->find($id);
        foreach($category->translations as $translation){
            $translation->delete();
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', true)->with('form_message', _('Category is deleted successfully!') );
    }

    public function getChildren($id = null)
    {


        if (!$id)
        {
            return 'no children';
        }

        $categories = Category::with('children')->find($id);
        if (is_null($categories))
        {
            return 'no children';
        }

        $categories = $categories->children;

        foreach ($categories as $key => $category)
        {
            $categories[$key] = $category->translations->filter(function ($model)
            {

                return ($model->language_id == $this->selectedLanguage->id);
            });
        }

        $categories = array_flatten($categories);


        return $categories;
    }

    public function getCategoryArrayTree($categoryId, $showCurrentCategoryAsSelected = false)
    {
        $arrayTree = [];

        $arrayTree[] = [
            'id'                            => (int)$categoryId,
            'showCurrentCategoryAsSelected' => $showCurrentCategoryAsSelected,
        ];

        $cat = Category::find($categoryId);

        for ($i = 1; $i < 19; $i++)
        {   // 19 - maximum of level deep
            if (isset($cat->parent_id))
            {
                $cat = $this->parent($cat->parent_id);
                $arrayTree[$i] = ['id' => $cat['id'] ? $cat['id'] : 0];
            }
        }

        foreach ($arrayTree as $key => $item)
        {
            $arrayTree[$key]['parent_selected_id'] = isset($arrayTree[($key - 1)]) ? $arrayTree[($key - 1)]['id'] : "";
            $arrayTree[$key]['parent'] = $this->parentBrothers($item['id']);
        }

//        dd($arrayTree);
        return $arrayTree;
    }

    public function parentBrothers($id)
    {
        if ($id > -1)
        {
            // $parentId =  Category::find($id)->parent_id;
            return Category::whereParentId($id)->with(['translation' => function ($q)
            {
                $q->where('language_id', $this->selectedLanguage->id);
            }])->get()->toArray();
        }
    }
}
