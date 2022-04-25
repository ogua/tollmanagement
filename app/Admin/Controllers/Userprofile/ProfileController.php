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
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    

    protected function profileform()
    {
        $form = new Form(new Userprofile());

        $check = Userprofile::where('user_id',Admin::user()->id)->first();


        $form->hidden('user_id', __('User id'))->default(Admin::user()->id);

        //$form->image('pic', __('Pic'));
        $form->select('title', __('Title'))->options(['Mrs' => 'Mrs', 'Mr' => 'Mr', 'Ms' => 'Ms', 'Miss' => 'Miss']);
        $form->text('surname', __('Surname'));
        $form->text('first_name', __('First name'));
        $form->text('othernames', __('Othernames'));
        $form->hidden('fullname', __('Fullname'));
        $form->select('gender', __('Gender'))->options(['Male' => 'Male', 'Female' => 'Female']);;
        $form->mobile('mobile', __('Mobile'))->options(['mask' => '999 999 9999']);
        $form->email('email', __('Email'));
        $form->text('location', __('Location'));
        $form->file('license', __('License Front'));
        $form->file('lenback', __('License Back'));

        if (!$check) {

            $form->setAction(admin_url('user-profiles/save'));

        }else{

            $form->setAction(admin_url('user-profiles/update'));
        }

        

        $form->saving(function (Form $form) {

            $form->fullname = $form->surname.' '.$form->first_name.' '.$form->othernames;
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


        return $form;
    }


    public function saveform()
    {
        return $this->profileform()->store();
    }


    public function registeruser()
    {
        return dump('working');
    }


    public function updateform()
    {
        $check = Userprofile::where('user_id',Admin::user()->id)->first();
        return $this->profileform()->update($check->id);
    }


     public function getprofileSetting(Content $content)
    {
        
        //$box = new Box('Box Title', 'Box content');
        $img = Admin::user()->avatar;

        $check = Userprofile::where('user_id',Admin::user()->id)->first();

        return $content
            ->title('User Profile')
            ->row(function (Row $row) use ($img,&$check) {

                $row->column(4, view('profile.img',compact('img')));

                $row->column(8, function (Column $column) use ($check){
                    //$column->row(new Box('',new profilesetting()));
                    if ($check) {
                        $column->row(new Box('',$this->profileform()->edit($check->id)));
                    }else{
                        $column->row(new Box('',$this->profileform()));
                    }
                    

                });
            });


    }



    

}
