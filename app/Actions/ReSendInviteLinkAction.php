<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ReSendInviteLinkAction extends AbstractAction
{
    public function getTitle()
    {
        return  $this->dataType->slug == 'invites' ? 'ReSendLink' : 'Personal Invite';
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'invites' || $this->dataType->slug == 'products';
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
        if($this->dataType->slug == 'invites'){
            return route('invite.product_details', ['invite' => $this->data,'security'=>$this->data->security_key]);
        }else{
            return route('voyager.products.invite', ['product'=>$this->data]);
        }
    }
}
