<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticTypes extends Model
{
    protected $table = 'analytic_types';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
