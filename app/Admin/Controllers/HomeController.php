<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tolllanes;
use App\Models\Tollpoint;
use App\Models\Vehicles;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {

        $user = Administrator::all()->count();
        $vehi = Vehicles::all()->count();
        $tolpoint = Tollpoint::all()->count();
        $tollanes = Tolllanes::all()->count();
        
        if (Admin::user()->isRole('user')) {
            return redirect()->to('/admin/makepayment');
        }elseif(Admin::user()->isRole('toll-user')){
           return redirect()->to('/admin/tollrecord');
        }
        return $content
            ->title('Admin Dashboard')
            ->row(Dashboard::title())
            ->row(function ($row) use ($user,&$vehi,&$tollanes,&$tolpoint) {
            $row->column(3, new InfoBox('New Users', 'users', 'aqua', '/admin/auth/users', $user));
             $row->column(3, new InfoBox('Total Toll Lanes', 'file', 'red', '/admin/auth/users', $tollanes));
            $row->column(3, new InfoBox('Total Vehicles', 'shopping-cart', 'green', '/demo/orders', $vehi));
            $row->column(3, new InfoBox('Total Toll Points', 'book', 'yellow', '/demo/articles', $tolpoint));
           
           });
    }
}
