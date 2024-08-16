<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class AddExtraAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Add Product';
    }


    public function shouldActionDisplayOnDataType()
{
    return $this->dataType->slug == 'products';
}
    public function getIcon()
    {
        return 'voyager-plus';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-left edit',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.products.extras',['product'=>$this->data]);
    }
}