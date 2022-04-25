<?php

namespace App\Admin\Forms;

use App\Models\Receivetran;
use App\Models\Tollpoint;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Receivetoll extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Record Toll';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());

        $data = [
            'amount'  => $request->amount,
            'receivedbyid'  => Admin::user()->id,
            'transtype'  => 'Toll Payment',
            'reference'  => $request->name
        ];

        $new = new Receivetran($data);
        $new->save();

        admin_success('Payment Recorded Successfully');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        //check role
        $adm = Administrator::with('tollpoint')->where('id',Admin::user()->id)->first();

        //dd($adm);

        if (Admin::user()->isAdministrator()) {

           $this->select('name', 'Select Toll Post')->options(Tollpoint::all()->pluck('name','id'));
        }else{

           $this->hidden('name')->default($adm->tollpoint->id ?? '');
        }


        $this->currency('amount', __('Amount'))->symbol('Gh¢')->default(3)->readonly();
        
    }



}
