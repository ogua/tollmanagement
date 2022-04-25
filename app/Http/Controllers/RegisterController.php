<?php

namespace App\Http\Controllers;

use App\Models\Tollpoint;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    
    public function register()
    {
        
        $userModel = config('admin.database.users_model');
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');

        $form = new Form(new $userModel());

        $form->setAction('/user-register/save');

        $userTable = config('admin.database.users_table');
        $connection = config('admin.database.connection');

        $form->tab('Login Information', function ($form) use ($userTable, &$connection,&$roleModel,&$permissionModel) {
    
        $form->text('username', trans('admin.username'))
            ->creationRules(['required', "unique:{$connection}.{$userTable}"])
            ->updateRules(['required', "unique:{$connection}.{$userTable},username,{{id}}"]);

        $form->text('name', trans('admin.name'))->rules('required');

        $form->select('tid', 'Select Toll Post')->options(Tollpoint::all()->pluck('name','id'));

        $form->image('avatar', trans('admin.avatar'));
        $form->password('password', trans('admin.password'))->rules('required|confirmed');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });

        $form->ignore(['password_confirmation']);

        $form->multipleSelect('roles', trans('admin.roles'))->options($roleModel::all()->pluck('name', 'id'));
        $form->multipleSelect('permissions', trans('admin.permissions'))->options($permissionModel::all()->pluck('name', 'id'));

            
        })->tab('Profile Information', function ($form) {

            $form->select('profile.title', __('Title'))->options(['Mrs' => 'Mrs', 'Mr' => 'Mr', 'Ms' => 'Ms', 'Miss' => 'Miss']);
            $form->text('profile.surname', __('Surname'));
            $form->text('profile.first_name', __('First name'));
            $form->text('profile.othernames', __('Othernames'));
            $form->hidden('fullname', __('Fullname'));
            $form->select('profile.gender', __('Gender'))->options(['Male' => 'Male', 'Female' => 'Female']);;
            $form->mobile('profile.mobile', __('Mobile'))->options(['mask' => '999 999 9999']);
            $form->email('profile.email', __('Email'));
            $form->text('profile.location', __('Location'));
            $form->file('profile.license', __('License'));
                               
           
           
        });

        $form->saving(function (Form $form) {

            admin_toastr(trans('admin.update_succeeded'));
        });

        $form->saved(function () {

            admin_toastr(trans('admin.update_succeeded'));

            return redirect(admin_url('profile'));
        });

        $form->tools(
            function (Form\Tools $tools) {
                $tools->disableList();
                $tools->disableDelete();
                $tools->disableView();
            }
        );

        $header = 'Register User';

        return view('registeruser',compact('form','header'));
        return new Box($form);
        return view(new Box($form));



    }


    public function saveform()
    {
        return $this->register()->store();
    }



}
