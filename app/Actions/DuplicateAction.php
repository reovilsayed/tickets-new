<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class DuplicateAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Duplicate';
    }


    public function shouldActionDisplayOnDataType()
{
    return $this->dataType->slug == 'products';
}
    public function getIcon()
    {
        return 'voyager-data';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.products.duplicate',['product'=>$this->data]);
    }
}