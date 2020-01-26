<?php

namespace App\Http\Controllers\API;
use App\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //return Reference::all();
      return Reference::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'type_id' => 'required',
        'name' => 'required|max:100',
        'description' => 'max:150',
        'price' => 'required|max:100'
      ]);

      $reference = Reference::create($validatedData);
      return $validatedData;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $reference = Reference::findOrFail($id);

      $this->validate($request,[
        'type_id' => 'required',
        'name' => 'required|max:100',
        'description' => 'max:150',
        'price' => 'required|max:100'
      ]);

      $reference->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $reference = Reference::findOrFail($id);
      $reference->delete();
    }
}
