<?php

namespace App\Admin\Forms;

use App\Models\Userprofile;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class profilesetting extends Form
{
    /**
     * The form title.
     *
     * @var string
     */

    //public $title = 'User Profile';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        dump($request->all());

        

        admin_success('Processed successfully.');

        //return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        //$this->column('pro')->image(Admin::user()->avatar,100, 100);
        //$this->image('pic', __('Pic'))->image('ogua/lamere.png');
        $this->select('title', __('Title'))->options(['Mrs' => 'Mrs', 'Mr' => 'Mr', 'Ms' => 'Ms', 'Miss' => 'Miss']);
        $this->text('surname', __('Surname'));
        $this->text('first_name', __('First name'));
        $this->text('othernames', __('Othernames'));
        $this->select('gender', __('Gender'))->options(['Male' => 'Male', 'Female' => 'Female']);
        $this->mobile('mobile', __('Mobile'))->options(['mask' => '999 999 9999']);
        $this->email('email', __('Email'));
        $this->text('location', __('Location'));
        $this->file('license', __('License Front'));
        $this->file('license', __('License Back'));

        // return $this;
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $userprofile = Userprofile::where('user_id', Admin::user()->id)
        ->first();

        if ($userprofile) {
            return $userprofile->toArray();
        }        
    }
}
