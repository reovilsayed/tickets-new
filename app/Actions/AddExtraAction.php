<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class AddExtraAction extends AbstractAction
{
    public function getTitle()
    {
        switch ($this->dataType->slug) {
            case 'products':
                return 'Add Product';
            case 'invites':
                return 'Add Product';
        }
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'products' || $this->dataType->slug == 'invites';
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

        switch ($this->dataType->slug) {
            case 'products':
                return route('voyager.products.extras', ['product' => $this->data]);
            case 'invites':
                return route('voyager.invites.add-product', ['invite' => $this->data]);
        }
    }
}
