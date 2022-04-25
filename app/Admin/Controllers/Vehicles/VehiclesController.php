<?php

namespace App\Admin\Controllers\Vehicles;

use App\Models\Userprofile;
use App\Models\Vehicles;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VehiclesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vehicles';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Vehicles());

        if (Admin::user()->isAdministrator()) {
            $grid->model()->orderBy('id', 'desc');
     }else{
        $grid->model()->where('user_id', Admin::user()->id)
        ->orderBy('id', 'desc');
    }
        
        $grid->column('pic', __('Image'))->image('',100,100);
        $grid->column('name', __('Name'));
        $grid->column('vtype', __('Type'));
        $grid->column('vmodel', __('Model'));
        $grid->column('color', __('Color'));
        $grid->column('plate', __('Plate'));
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
        $show = new Show(Vehicles::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('pic', __('Pic'));
        $show->field('name', __('Name'));
        $show->field('vtype', __('Vtype'));
        $show->field('vmodel', __('Vmodel'));
        $show->field('color', __('Color'));
        $show->field('plate', __('Plate'));
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
        $form = new Form(new Vehicles());

        $form->hidden('user_id', __('User id'));
        $form->image('pic', __('Pic'));
        $form->text('name', __('Name'));
        $form->text('vtype', __('Type'));
        $form->text('vmodel', __('Model'));
        $form->color('color', __('Color'));
        $form->text('plate', __('Plate'));

        $form->saving(function (Form $form) {

            $pro = Userprofile::where('user_id',Admin::user()->id)->first();

            if ($pro->status < 1) {
                 admin_error('Make sure your profile has been approved before adding vehicles.');
                 return back();
            }

            $form->user_id = Admin::user()->id;


        });

        return $form;
    }
}
