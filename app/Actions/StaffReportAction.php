<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class StaffReportAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Report';
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'users';
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
            'class' => 'btn btn-sm btn-primary pull-right edit',
        ];
    }

    public function shouldActionDisplayOnRow($row)
    {

        return $row->role_id == 4 ? true : false;
    }
    public function getDefaultRoute()
    {
        return route('voyager.users.staff', ['user' => $this->data]);
    }
}
