<?php

namespace App\Admin\Controllers\Tollpoint;

use App\Models\Tolllanes;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TolllanesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Toll lanes';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tolllanes());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));

        // $grid->column('language');

        // $grid->rows(function (Grid\Row $row) {

        //     $row->column('language', "<a href='/demo/world/language?CountryCode={$row->Code}' class='btn btn-info'><i class'fa fa-eye'></i>languages</a>");

        // });

        $grid->column('created_at', __('Created at'))->display(function($created_at){
            return date('m-d-Y',strtotime($created_at));
        });


        $grid->filter(function($filter){

            $filter->disableIdFilter();

        });


        // $grid->actions(function (Grid\Displayers\Actions $actions) {

        //     if ($actions->getKey() % 2 == 0) {
        //         $actions->disableDelete();
        //         $actions->append('<a href=""><i class="fa fa-paper-plane"></i></a>');
        //     } else {
        //         $actions->disableEdit();
        //         $actions->prepend('<a href=""><i class="fa fa-paper-plane"></i></a>');
        //     }
        // });

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
        $show = new Show(Tolllanes::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
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
        $form = new Form(new Tolllanes());

        $form->text('name', __('Name'));

        return $form;
    }
}
