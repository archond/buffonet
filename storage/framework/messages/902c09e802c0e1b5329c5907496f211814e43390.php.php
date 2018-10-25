<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Validator;

class CityController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with('country')->orderBy('name', 'asc')->get();

        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('countryId'))
        {
            $country = Country::find($request->countryId);
        } else
        {
            $country = null;
        }

        $countries = Country::orderBy('name', 'asc')->get();

        return view('cities.create', compact('countries', 'country'));
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
        $validator = Validator::make($data, City::$storeRules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        City::create($data);
        if (isset($data['countryId']))
        {

            return redirect()->route('countries.show', ['id' => $data['country_id']])->with('success', true)->with('form_message', 'City is created successfully!');
        }

        return redirect()->route('cities.index')->with('success', true)->with('form_message', 'City is created successfully!');
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
    public function edit(Request $request, $id)
    {
        if ($request->has('countryId'))
        {
            $country = Country::find($request->countryId);
        } else
        {
            $country = null;
        }

        $city = City::find($id);
        $countries = Country::orderBy('name', 'asc')->get();

        return view('cities.edit', compact('city', 'countries', 'country'));
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

        $city = City::find($id);
        $validator = Validator::make($data, City::$updateRules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $city->update($data);

        if (isset($data['countryId']))
        {

            return redirect()->route('countries.show', ['id' => $city['country_id']])->with('success', true)->with('form_message', 'City is updated successfully!');
        }

        return redirect()->route('cities.index')->with('success', true)->with('form_message', 'City is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $request->all();
//        return $data;
        $decriptedId = Crypt::decrypt($id);
        $city = City::find($decriptedId);
        if ($city)
        {
            $city->delete();
            if (isset($data['countryId']))
            {
                return redirect()->route('countries.show', ['id' => $data['countryId']])->with('success', true)->with('form_message', 'City is deleted successfully!');
            }
            return redirect()->route('countries.index')->with('success', true)->with('form_message', 'City is NOT deleted successfully!');
        } else{
            if (isset($data['countryId'])){
                return redirect()->route('countries.show', ['id' => $data['countryId']])->with('success', true)->with('form_message', 'City is deleted successfully!');
            }
            return redirect()->route('countries.index')->with('warning', true)->with('form_message', 'City is NOT deleted successfully!');
        }

    }
}
