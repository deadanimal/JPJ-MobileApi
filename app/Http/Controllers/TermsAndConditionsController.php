<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTermsAndConditionsRequest;
use App\Http\Requests\UpdateTermsAndConditionsRequest;
use App\Models\TermsAndConditions;

class TermsAndConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tnc = TermsAndConditions::all();
        return response()->json($tnc);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTermsAndConditionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermsAndConditionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TermsAndConditions  $termsAndConditions
     * @return \Illuminate\Http\Response
     */
    public function show(TermsAndConditions $termsAndConditions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermsAndConditions  $termsAndConditions
     * @return \Illuminate\Http\Response
     */
    public function edit(TermsAndConditions $termsAndConditions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTermsAndConditionsRequest  $request
     * @param  \App\Models\TermsAndConditions  $termsAndConditions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermsAndConditionsRequest $request, TermsAndConditions $termsAndConditions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermsAndConditions  $termsAndConditions
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermsAndConditions $termsAndConditions)
    {
        //
    }
}
