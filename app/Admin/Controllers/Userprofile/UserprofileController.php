<?php

namespace App\Admin\Controllers\Userprofile;

use App\Admin\Forms\profilesetting;
use App\Models\Userprofile;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;

class UserprofileController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User Profile';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Userprofile());

        //$grid->column('id', __('Id'));
        //$grid->column('user_id', __('User id'));
        $grid->column('user.avatar', __('Pic'))->image('',100,100);
        //$grid->column('title', __('Title'));
        // $grid->column('surname', __('Surname'));
        // $grid->column('first_name', __('First name'));
        // $grid->column('othernames', __('Othernames'));
        $grid->column('Full name')->display(function(){
            return $this->title.' '.$this->surname.' '.$this->first_name.' '.$this->othernames;
        });
        $grid->column('gender', __('Gender'));
        $grid->column('mobile', __('Mobile'));
        $grid->column('email', __('Email'));
        $grid->column('location', __('Location'));
        $grid->column('license', __('License Front'))->downloadable();
        $grid->column('lenback', __('License Back'))->downloadable();
        $grid->column('status', __('Status'))->editable('select', [0 => 'Rejected', 1 => 'Approved'])->help('Click To Apporve or Reject');
        $grid->column('created_at', __('Created at'))->display(function($created_at){
            return date('m-d-Y',strtotime($created_at));
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
        $show = new Show(Userprofile::findOrFail($id));

       
        $show->field('user.avatar', __('Pic'))->image();
        $show->field('title', __('Title'));
        $show->field('surname', __('Surname'));
        $show->field('first_name', __('First name'));
        $show->field('othernames', __('Othernames'));
        $show->field('gender', __('Gender'));
        $show->field('mobile', __('Mobile'));
        $show->field('email', __('Email'));
        $show->field('location', __('Location'));
        $show->field('license', __('License Front'))->file();
        $show->field('lenback', __('License Back'))->file();
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Userprofile());

        $form->hidden('user_id', __('User id'))->default(Admin::user()->id);
        //$form->image('pic', __('Pic'));
        $form->select('title', __('Title'))->options(['Mrs' => 'Mrs', 'Mr' => 'Mr', 'Ms' => 'Ms', 'Miss' => 'Miss']);
        $form->text('surname', __('Surname'));
        $form->text('first_name', __('First name'));
        $form->text('othernames', __('Othernames'));
        $form->text('fullname', __('Fullname'));
        $form->select('gender', __('Gender'))->options(['Male' => 'Male', 'Female' => 'Female']);;
        $form->mobile('mobile', __('Mobile'))->options(['mask' => '999 999 9999']);
        $form->email('email', __('Email'));
        $form->text('location', __('Location'));
        $form->file('license', __('License Front'));
        $form->file('lenback', __('License Back'));
        $form->hidden('status', __('Status'));
        
        return $form;
    }



}
