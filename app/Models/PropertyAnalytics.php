<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAnalytics extends Model
{
    protected $table = 'property_analytics';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
