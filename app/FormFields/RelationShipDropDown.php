<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class RelationShipDropDown extends AbstractHandler
{
    protected $codename = 'relationdropdown';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.relationdropdown', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}