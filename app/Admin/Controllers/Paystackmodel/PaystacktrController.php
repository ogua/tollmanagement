<?php

namespace App\Admin\Controllers\Paystackmodel;

use App\Models\Paystackmodel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class PaystacktrController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'All Transaction';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Paystackmodel());

        $grid->paginate(10);


        $grid->column('reference', 'Reference')->expand(function ($model) {

            $headers = ['Email', 'First Four', 'Last Four', 'Time Started', 'Time Ended','Attempts'];

            $logstime = $model['logstarttime'];
            $calstime = date("i:s", $logstime);
            if ($logstime > 60) {
               $narration = 'Minutes Spent On Page';
            }else{
                $narration = 'Seconds Spent On Page';
            }

            $logetime = $model['logspenttime'];
            $caletime = date("i:s", $logetime);
            if ($logetime > 60) {
               $enarration = 'Minutes Spent On Page';
            }else{
                $enarration = 'Seconds Spent On Page';
            }

            $rows = [
               [$model['customeremail'], $model['first4'], $model['last4'],$calstime.' '.$narration ,$caletime.' '.$enarration,$model['logattempts']]
            ];

            return new Table($headers,$rows);
        });

        $grid->column('tollpoint.name', __('Paid TO'));

        $grid->column('tollpoint.region', __('Region'));

        $grid->column('amount', __('Amount'))->display(function($amnt){
            return $amnt / 100;
        });

        $grid->column('tid', __('Tr ID'));
        
        //$grid->column('reference', __('Reference'));
        // $grid->column('reference', 'Reference');

        

        $grid->column('paymentdate', __('Payment Date'))->display(function($paymentdate){
            return date('m-d-Y',strtotime($paymentdate));
        });
        $grid->column('channel', __('Channel'));
        $grid->column('bank', __('Bank'));

        $grid->column('tistatus', __('Tr Status'))->display(function($status){
            if ($status == 'success') {
                 return "<i class='label label-info'>{$status}</i>";
            }else{
                 return "<i class='label label-danger'>{$status}</i>";
            }
           
        });
        
        $grid->disableCreateButton();

        $grid->disableActions();

        $grid->filter(function($filter){

            $filter->disableIdFilter();
            $filter->between('created_at', 'Payment Time')->datetime();
            $filter->scope('created_at', 'Transactions Per Day')
            ->WhereDate('created_at',date('y-m-d'));

        });



        return $grid;
    }




    protected function alltransactions()
    {
        $grid = new Grid(new Paystackmodel());

        $grid->column('amount', __('Amount'));
        $grid->column('tid', __('Tid'));
        $grid->column('tistatus', __('Tistatus'));
        $grid->column('reference', __('Reference'));
        $grid->column('paymentdate', __('Payment Date'));
        $grid->column('channel', __('Channel'));
        $grid->column('currency', __('Currency'));
        $grid->column('cardtype', __('Card Type'));
        $grid->column('bank', __('Bank'));
        
        $grid->column('created_at', __('Created at'))->display(function($created_at){
            return date('m-d-Y',strtotime($created_at));
        });


        $grid->filter(function($filter){

            $filter->disableIdFilter();

        });




        return $grid;
    }


    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Paystackmodel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('tid', __('Tid'));
        $show->field('tistatus', __('Tistatus'));
        $show->field('reference', __('Reference'));
        $show->field('user_id', __('User id'));
        $show->field('amount', __('Amount'));
        $show->field('message', __('Message'));
        $show->field('reponse', __('Reponse'));
        $show->field('paymentdate', __('Paymentdate'));
        $show->field('channel', __('Channel'));
        $show->field('currency', __('Currency'));
        $show->field('ipaddress', __('Ipaddress'));
        $show->field('feecharge', __('Feecharge'));
        $show->field('authcode', __('Authcode'));
        $show->field('cardtype', __('Cardtype'));
        $show->field('bank', __('Bank'));
        $show->field('countrycode', __('Countrycode'));
        $show->field('brand', __('Brand'));
        $show->field('first4', __('First4'));
        $show->field('last4', __('Last4'));
        $show->field('customercode', __('Customercode'));
        $show->field('customeremail', __('Customeremail'));
        $show->field('logstarttime', __('Logstarttime'));
        $show->field('logspenttime', __('Logspenttime'));
        $show->field('logattempts', __('Logattempts'));
        $show->field('logerrors', __('Logerrors'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Paystackmodel());

        $form->text('tid', __('Tid'));
        $form->text('tistatus', __('Tistatus'));
        $form->text('reference', __('Reference'));
        $form->text('user_id', __('User id'));
        $form->text('amount', __('Amount'));
        $form->text('message', __('Message'));
        $form->text('reponse', __('Reponse'));
        $form->text('paymentdate', __('Paymentdate'));
        $form->text('channel', __('Channel'));
        $form->text('currency', __('Currency'));
        $form->text('ipaddress', __('Ipaddress'));
        $form->text('feecharge', __('Feecharge'));
        $form->text('authcode', __('Authcode'));
        $form->text('cardtype', __('Cardtype'));
        $form->text('bank', __('Bank'));
        $form->text('countrycode', __('Countrycode'));
        $form->text('brand', __('Brand'));
        $form->text('first4', __('First4'));
        $form->text('last4', __('Last4'));
        $form->text('customercode', __('Customercode'));
        $form->text('customeremail', __('Customeremail'));
        $form->text('logstarttime', __('Logstarttime'));
        $form->text('logspenttime', __('Logspenttime'));
        $form->text('logattempts', __('Logattempts'));
        $form->text('logerrors', __('Logerrors'));

        return $form;
    }
}
