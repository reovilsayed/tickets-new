<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class AddExtraAction extends AbstractAction
{
    public function getTitle()
    {
<<<<<<< HEAD
        switch ($this->dataType->slug) {
            case 'products':
                return 'Add Extra';
            case 'invites':
                return 'Add Product';
        }
=======
        return 'Add Product';
>>>>>>> b12c83ea804e88344e85628fbf5aefe7d0f996b6
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
