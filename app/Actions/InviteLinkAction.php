<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class InviteLinkAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Link';
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'invites';
    }
    public function getIcon()
    {
        return 'voyager-paper-plane';
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
        return route('invite.product_details', ['invite' => $this->data,'security'=>$this->data->security_key]);
    }
}
