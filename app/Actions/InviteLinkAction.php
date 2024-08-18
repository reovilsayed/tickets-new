<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class StaffReportAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Link';
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'users';
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
            'class' => 'btn btn-sm btn-primary pull-right edit',
        ];
    }


    public function getDefaultRoute()
    {
        return route('voyager.users.staff', ['user' => $this->data]);
    }
}
