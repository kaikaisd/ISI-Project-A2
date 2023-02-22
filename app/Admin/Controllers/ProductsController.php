<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        //每一个 $grid-> 调用，对应后台表格里的一个列显示，这个代码和之前的《用户列表》章节十分类似
        $grid = new Grid(new Product());

        $grid->column('id', __('Id'));
        $grid->name('Product Name');
        $grid->isOnSale('On Sale')->display(function ($value) {
            return $value ? 'Yes' : 'No';
        });
        $grid->price('Price');
        $grid->sold_count('Sales');
        $grid->review_count('review');


        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
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
        $form = new Form(new Product);

        // 创建一个输入框，第一个参数 title 是模型的字段名，第二个参数是该字段描述
        $form->text('name', 'Product name')->rules('required');

        // 创建一个选择图片的框
        $form->image('pic', 'Picture')->rules('required|image');

        // 创建一个富文本编辑器
        $form->editor('description', 'Description')->rules('required');

        // 创建一组单选框
        $form->radio('isOnSale', 'On sale')->options(['1' => 'Yes', '0'=> 'No'])->default('0');

        // 直接添加一对多的关联模型
        $form->hasMany('skus', 'SKU list', function (Form\NestedForm $form) {
            $form->text('name', 'SKU name')->rules('required');
            $form->text('description', 'SKU Description')->rules('required');
            $form->text('price', 'Price')->rules('required|numeric|min:0.01');
            $form->text('quantity', 'Stock')->rules('required|integer|min:0');
        });

        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });



        return $form;
    }
}
