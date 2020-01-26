<?php

namespace App\Http\Controllers\API;
use App\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::latest()->paginate(10);
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
        'address_line_1' => 'required|max:100',
        'address_line_2' => 'max:100',
        'zip' => 'required|max:7',
        'city' => 'required|max:50',
        'country' => 'required|max:10',
        'contact_firstname' => 'required|max:10',
        'contact_lastname' => 'required|max:10',
        'contact_mail' => 'required|email|max:100',
        'contact_phone' => 'required|max:15'
      ]);

      $customer = Customer::create($validatedData);
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
        $customer = Customer::findOrFail($id);

        $this->validate($request,[
          'type_id' => 'required',
          'name' => 'required|max:100',
          'address_line_1' => 'required|max:100',
          'address_line_2' => 'max:100',
          'zip' => 'required|max:7',
          'city' => 'required|max:50',
          'country' => 'required|max:10',
          'contact_firstname' => 'required|max:10',
          'contact_lastname' => 'required|max:10',
          'contact_mail' => 'required|email|max:100',
          'contact_phone' => 'required|max:15'
        ]);

        $customer->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $customer = Customer::findOrFail($id);
      $customer->delete();
    }

    /**
     * Search the specified input from searchbar in Customers.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search()
    {

      if ($search = \Request::get('q')) {
        $customers = Customer::where(function($query) use ($search){
          $query->where('name','LIKE',"%$search%")
                ->orWhere('contact_mail','LIKE',"%$search%");
        })->paginate(20);
      }else {
        return Customer::latest()->paginate(10);
      }

      return $customers;
    }

}
