<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class ArrayDateField extends AbstractHandler
{
    protected $codename = 'array_date';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.array_date', [
            'row' => $row,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent,
            'options' => $options,
        ]);
    }
}
