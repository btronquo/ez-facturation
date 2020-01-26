<?php

namespace App\Http\Controllers\API;
use App\BillingDetail;
use App\Billing;
use App\Customer;
use App\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillingDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return BillingDetail::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data=$request->all();
      $data_references = $request['data']['references'];

      foreach($data_references as $key => $input) {
        $billingdetail = new BillingDetail();
        $billingdetail->billing_id = $request['data']['billId'];
        $billingdetail->reference_id = $data_references[$key]['id'];
        $billingdetail->quantity = $data_references[$key]['quantity'];
        $billingdetail->unit_price = $data_references[$key]['price'];
        $billingdetail->comment = empty($data_references[$key]['comment']) ? null : $data_references[$key]['comment'];
        $billingdetail->save();
      }
      return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      // $data = new BillingDetail();
      // // on recupere les infos de base concernant la bill $id
      // $data->Billing::findOrFail($id);

      //$data = Billing::first()->customers->name;

      //$data = Billing::find(5)->editor->name;




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
        //
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
