<?php

namespace App\Strategies\SearchBy;

use App\Strategies\Properties;

class State extends Properties
{
    /**
     * @param $columnType
     * @param $columnValue
     * @return static
     */
    public static function init($columnType, $columnValue)
    {
        if ($columnType == 'state') {
            return new static ($columnType, $columnValue);
        }
    }
}
