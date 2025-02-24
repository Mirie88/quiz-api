<?php

namespace App\Http\Controllers;

use App\Models\responses;
use App\Http\Requests\StoreresponsesRequest;
use App\Http\Requests\UpdateresponsesRequest;

class ResponsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            Responses::with([ 'user', 'quiz', 'question'])->get(),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
          $r = $request->validate([
              
          ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(responses $responses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(responses $responses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateresponsesRequest $request, responses $responses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(responses $responses)
    {
        //
    }
}
