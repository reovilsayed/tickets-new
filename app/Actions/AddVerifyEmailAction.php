<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class AddVerifyEmailAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Verify Email';
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'users';
    }

    public function getIcon()
    {
        return 'voyager-check';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-danger pull-left edit',
            'onclick' => "return confirm('Are you sure?')",
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.email.verify', $this->data);
    }

    public function shouldActionDisplayOnRow($user)
    {
        return !$user->hasVerifiedEmail();
    }
}
