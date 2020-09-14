<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('countries.index', ['countries' => Country::orderBy('title')->get()]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country = new Country();
        // can be used for seeing the insides of the incoming request
        // var_dump($request->all()); die();
        if($request['title'] === null) {
            return Redirect::back()->withErrors(['Privaloma įvesti šalies pavadinimą!']);
        } else if($request['distance'] === null) {
            return Redirect::back()->withErrors(['Privaloma įvesti atstumą iki šalies!']);
        } else if($request['description'] === null) {
            return Redirect::back()->withErrors(['Privalomas šalies aprašas!']);
         } else {
        $country->fill($request->all());
        $country->save();
        return redirect()->route('country.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('countries.edit', ['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        
        $country->fill($request->all());
        $country->save();
        return redirect()->route('country.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        if (count($country->towns)){ 
            return back()->withErrors(['error' => ['Can\'t delete country with cities assigned, please unassign cities first!']]);
        }
        $country->delete();
        return redirect()->route('country.index');
    }
}