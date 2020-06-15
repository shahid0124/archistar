<?php

namespace App\Strategies\SearchBy;

use App\Strategies\Properties;

class Country extends Properties
{
    /**
     * @param $columnType
     * @param $columnValue
     * @return static
     */
    public static function init($columnType, $columnValue)
    {
        if ($columnType == 'country') {
            return new static ($columnType, $columnValue);
        }
    }
}
