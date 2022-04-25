<?php

namespace App\Admin\Controllers\Accounts;

use App\Models\Receivetran;
use App\Models\Tollpoint;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReceivetranController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Received transactions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Receivetran());

        if (Admin::user()->isAdministrator()) {

            $grid->model()->orderBy('id', 'desc');

         }else{

            $grid->model()->where('receivedbyid', Admin::user()->id)
            ->orderBy('id', 'desc');
        }

        //$grid->model()->where('receivedbyid',Admin::user()->id);

        //$grid->column('tollpoint.id','tollpoint.id');

        $grid->column('amount', __('Amount'))->display(function($amount){
            return 'GH&cent; '.$amount;
        });
        $grid->column('user.name', __('Received By'));
        $grid->column('transtype', __('Transtype'));
        $grid->column('tollpoint.name', __('Location'));
        $grid->column('tollpoint.region', __('Region'))->display(function($region){
            return $region." REGION";
        });
       $grid->column('created_at', __('Created at'))->display(function($created_at){
            return date('m-d-Y',strtotime($created_at));
        });


        $grid->disableCreateButton();

        $grid->disableRowSelector();

        $grid->disableExport();

        $grid->disableActions();

        $grid->filter(function($filter){

        $filter->disableIdFilter();

        $filter->scope('created_at', 'Transactions Per Day')
        ->WhereDate('created_at',date('y-m-d'));

        $filter->between('created_at', __('Transaction Range'))->date();

        // $filter->equal('status', __('Membership Status'))->select(['1' => 'Active Members', '0' => 'Stopped Members']);

        // $filter->group('Transaction By Toll', function($group){

        //    $group->equal('tollpoint.region', 'Region')->select(['1' => 'Active Members', '0' => 'Stopped Members']);

        //    $group->equal('tollpoint.name', __('Location'))->select(['1' => 'Active Members', '0' => 'Stopped Members']);
        // });

        

        if (Admin::user()->isAdministrator()) {

            $filter->equal('reference', 'Location')->select(Tollpoint::all()->pluck('name','id')->toArray());
        }

        // $filter->equal('tollpoint.name', 'Location')->select(Tollpoint::all()->pluck('name','id')->toArray());



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
        $show = new Show(Receivetran::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('amount', __('Amount'));
        $show->field('receivedbyid', __('Receivedbyid'));
        $show->field('transtype', __('Transtype'));
        $show->field('reference', __('Reference'));
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
        $form = new Form(new Receivetran());

        $form->number('amount', __('Amount'));
        $form->text('receivedbyid', __('Receivedbyid'));
        $form->text('transtype', __('Transtype'));
        $form->text('reference', __('Reference'));

        return $form;
    }
}
