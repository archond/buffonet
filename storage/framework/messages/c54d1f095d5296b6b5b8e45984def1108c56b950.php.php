<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CategoryTranslation;
use App\Language;
use App\Category;

class CategoryTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($categoryId, $translationData)
    {
        $languages = Language::get();  
        $category = Category::find($categoryId);

        foreach($languages as $language){ 
            if( !isset($translationData[$language->id]) || !$translationData[$language->id] ){
                $translation = $category->slug.' in '.strtoupper($language->abbr).' language'; 
            } else{
                $translation = $translationData[$language->id];
            }

            $data[] = [
            'language_id'=>$language->id,
            'name'=>$translation,
            'category_id'=>$categoryId
            ];

            // CategoryTranslation::create($data);
        }
        CategoryTranslation::insert($data);
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, $translationData)
    {

        $translation = CategoryTranslation::with('category')->find($id);

        if( !isset($translationData) || !$translationData ){

            $language= Language::find($translation->language_id);

            $translation->name = $translation->category->slug.' in '.strtoupper($language->abbr).' language'; 
        } else{
            $translation->name = $translationData;
        }

        $translation->save();
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
