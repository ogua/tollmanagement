<?php

namespace App\Admin\Controllers\Tollpoint;

use App\Models\Tolllanes;
use App\Models\Tollpoint;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TollpointController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Toll Collection';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tollpoint());

        $grid->column('name', __('Name'));
        $grid->column('location', __('Location'));
        $grid->column('region', __('Region'))->display(function($region){
            return $region." REGION";
        });
        $grid->column('gpsaddress', __('Gps Address'));

        $grid->column('tolllanes', __('Toll Lanes'))->display(function ($tolllanes) {
        $tolllanes = array_map(function ($lane) {
            return "<span class='badge badge-success'>{$lane['name']}</span>";
            }, $tolllanes);

            return join('&nbsp;', $tolllanes);
        });

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
        $show = new Show(Tollpoint::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('location', __('Location'));
        $show->field('region', __('Region'));
        $show->field('gpsaddress', __('Gps Address'));
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
        $form = new Form(new Tollpoint());

        $form->text('name', __('Name'));
        $form->text('location', __('Location'));
        $form->select('region', __('Region'))->options(['AHAFO' => 'AHAFO', 'ASHANTI' => 'ASHANTI','BONO EAST' => 'BONO EAST','BRONG AHAFO' => 'BRONG AHAFO','CENTRAL' => 'CENTRAL','EASTERN' => 'EASTERN','GREATER ACCRA' => 'GREATER ACCRA','NORTH EAST' => 'NORTH EAST','' => 'NORTHERN','' => 'NORTHERN','OTI' => 'OTI','SAVANNAH' => 'SAVANNAH','UPPER EAST' => 'UPPER EAST','UPPER WEST' => 'UPPER WEST','WESTERN' => 'WESTERN','WESTERN NORTH' => 'WESTERN NORTH','VOLTA' => 'VOLTA']);

        $form->text('gpsaddress', __('Gps Address'));

        $form->multipleSelect('tolllanes','Available Lanes')->options(Tolllanes::all()->pluck('name', 'id'));

        return $form;
    }
}
