<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class GeneratePhysicalTicketAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Generate physical ticket';
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'products';
    }
    public function getIcon()
    {
        return 'voyager-ticket';
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

       return route('voyager.products.ticketCreatePhysical',$this->data);
    }
}
