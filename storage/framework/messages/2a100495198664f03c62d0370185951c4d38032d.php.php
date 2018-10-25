<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;

use App\Http\Requests;

class CountryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->all();

        $countries = Country::with('cities')->orderBy('name', 'asc');

        if(isset($data['search_country'])){
            if($data['search_country'] == ''){
                $request->session()->forget('search_country');
            }else{
                $request->session()->put('search_country', $request->get('search_country'));
            }
        }

        if($request->session()->has('search_country') && $request->session()->get('search_country')){
            $countries = $countries->where('name', 'LIKE', '%'.$request->session()->get('search_country').'%');
        }

        $countries = $countries->paginate(config('constants.PAGINATE_PER_PAGE'));

        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('countries.create');
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
        $validator = Validator::make($data, Country::storeRules());
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Country::create($data);

        return redirect()->route('countries.index')->with('success', true)->with('form_message', 'Country is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::with(['cities' => function ($q)
        {
            $q->orderBy('name', 'asc');
        }])->find($id);

        return view('countries.cities.index', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);

        return view('countries.edit', compact('country'));
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
//        dd(Country::updateRules($id));
        $validator = Validator::make($data, Country::updateRules($id));
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Country::find($id)->update($data);

        return redirect()->route('countries.index')->with('success', true)->with('form_message', 'Country is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decriptedId = Crypt::decrypt($id);
        $country = Country::find($decriptedId);
        if ($country)
        {
            $country->cities()->delete();
            $country->delete();
            return redirect()->route('countries.index')->with('success', true)->with('form_message', 'Country is deleted successfully!');
        } else{
            return redirect()->route('countries.index')->with('warning', true)->with('form_message', 'Country is NOT deleted successfully!');
        }

    }

    public function getCities($id){
        return City::where('country_id', $id)->get();
    }
}
