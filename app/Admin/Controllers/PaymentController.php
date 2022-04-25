<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Onlinepayment;
use App\Admin\Forms\Receivetoll;
use App\Http\Controllers\Controller;
use App\Models\Paystacklog;
use App\Models\Paystackmodel;
use App\Models\Tollpoint;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Paystack;
use Unicodeveloper\Paystack\redirectNow;

class PaymentController extends Controller
{
    

    public function makepayment(Content $content){

        $lan = Tollpoint::all();

        return $content
            ->title('Pay Toll Online')
            ->row(function (Row $row) use ($lan){

                $row->column(5, function (Column $column) use ($lan){
                    $column->append(view('pay',compact('lan')));
                });

            });

    }



    public function tollrecord(Content $content)
    {
       $lan = Tollpoint::all();

        return $content
            ->title('Record Toll')
            ->row(new Receivetoll());

    }


     /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        request()->session()->put('paypoint', request()->paypoint);

        try{
            return Paystack::getAuthorizationUrl()->redirectNow();

        }catch(\Exception $e) {

            $error = new MessageBag([
                'title'   => 'Error',
                'message' => 'Please make sure, you are connected to the internet',
            ]);

            return back()->with(compact('error'));

            // return Redirect::back()->withError('Error','Please make sure, you are connected to the internet');
        }        
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        //return dump($paymentDetails);

        $status = $paymentDetails['status'];
        $msg = $paymentDetails['message'];
        $id = $paymentDetails['data']['id'];
        $trstatus = $paymentDetails['data']['status'];
        $trid = $paymentDetails['data']['reference']; 
        $indexnumber = $paymentDetails['data']['metadata']['index'];
        $amount = $paymentDetails['data']['amount'];
        $msg = $paymentDetails['data']['message'];
        $reponse = $paymentDetails['data']['gateway_response'];
        $paymentdate = $paymentDetails['data']['paid_at'];
        $channel = $paymentDetails['data']['channel'];
        $currency = $paymentDetails['data']['currency'];
        $ipaddress = $paymentDetails['data']['ip_address'];
        $feecharge = $paymentDetails['data']['fees'];
        //bank for Authourisation
        $auth_code = $paymentDetails['data']['authorization']['authorization_code'];
        $card_type = $paymentDetails['data']['authorization']['card_type'];
        $bank = $paymentDetails['data']['authorization']['bank'];
        $country_code = $paymentDetails['data']['authorization']['country_code'];
        $brand = $paymentDetails['data']['authorization']['brand'];
        $first4 = $paymentDetails['data']['authorization']['bin'];
        $last4 = $paymentDetails['data']['authorization']['last4'];

        //customer_code
        $customer_code = $paymentDetails['data']['customer']['customer_code'];
        $customer_email = $paymentDetails['data']['customer']['email'];

        //log
        $logstarttime = $paymentDetails['data']['log']['start_time'];
        $logspenttime = $paymentDetails['data']['log']['time_spent'];
        $logattempts = $paymentDetails['data']['log']['attempts'];
        $logerrors = $paymentDetails['data']['log']['errors'];

        $hsty = $paymentDetails['data']['log']['history'];

        if ($status) {

            $data = [
                'tistatus' => $trstatus,
                'tid' => $id,
                'pid' =>  request()->session()->get('paypoint'),
                'reference' => $trid,
                'user_id' => $indexnumber,
                'amount' => $amount,
                'message' => $msg,
                'reponse' => $reponse,
                'paymentdate' => $paymentdate,
                'channel' => $channel,
                'currency' => $currency,
                'ipaddress' => $ipaddress,
                'feecharge' => $feecharge,
                'authcode' => $auth_code,
                'cardtype' => $card_type,
                'bank' => $bank,
                'countrycode' => $country_code,
                'brand' => $brand,
                'first4' => $first4,
                'last4' => $last4,
                'customercode' => $customer_code,
                'customeremail' =>$customer_email,
                'logstarttime' => $logstarttime,
                'logspenttime' => $logspenttime,
                'logattempts' => $logattempts,
                'logerrors' => $logerrors 
            ];


            $new = new Paystackmodel($data);
            $new->save();


            foreach ($hsty as $row) {

                $logs = [
                    'pid' => $new->id,
                    'type' => $row['type'],
                    'message' => $row['message'],
                    'time' => $row['time']
                ];

                $lognew = new Paystacklog($logs);
                $lognew->save();
            }
            //add logs
            

            if ($trstatus == 'success') {
                $amnt = $amount / 100;
                //$user = User::findorfail(auth()->user()->id);
                //$user->deposit($amnt, ['Trantype' => 'WALLET TOPUP/DEPOSITE', 'Reference' => 'DEPOSITE']);
            }
            
            
        }


        $error = new MessageBag([
                'title'   => 'Successfully',
                'message' => 'Paid Successfully!',
            ]);

        return back()->with(compact('error'));

        //return Redirect()->route('paystack-all-transactions-student');

        
    }

    public function getAlltransactions()
    {
        $paymentDetails = Paystack::getAllTransactions();

        dd($paymentDetails);
    }


    public function getAlltransactions_student()
    {
        $paymentDetails = Paystackmodel::where('user_id',Auth::user()->id)->latest()->get();

        return view('Accounts.paystack_transaction_history',['paymentDetails' => $paymentDetails]);
    }


    public function transaction_refid($refid)
    {
        $paymentDetails = Paystackmodel::with('paystacklog')->where('reference',$refid)->first();

        return view('Accounts.paystack_transaction_details',['paymentinfo' => $paymentDetails]);
    }




    public function subAccount()
    {
        $paymentDetails = Paystack::createSubAccount();
    }
    

    public function fetchsubAccDetails()
    {
        $paymentDetails = Paystack::fetchSubAccount();
    }

    public function listSubAccounts()
    {
        $paymentDetails = Paystack::listSubAccounts();
    }









}
