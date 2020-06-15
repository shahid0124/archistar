<?php

namespace App\Strategies\SearchBy;

use App\Strategies\Properties;

class Suburb extends Properties
{
    /**
     * @param $columnType
     * @param $columnValue
     * @return static
     */
    public static function init($columnType, $columnValue)
    {
        if ($columnType == 'suburb') {
            return new static ($columnType, $columnValue);
        }
    }
}
