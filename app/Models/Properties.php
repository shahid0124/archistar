<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;
use Dyrynda\Database\Casts\EfficientUuid;

class Properties extends Model
{
    use GeneratesUuid;

    protected $casts = [
        'guid' => EfficientUuid::class,
    ];

    /**
     * @return string
     */
    public function uuidColumn(): string
    {
        return 'guid';
    }
    protected $table = 'properties';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'state',
        'suburb',
        'country'
    ];

    /**
     * Method to define the relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function propertyAnalytics()
    {
        return $this
            ->belongsToMany(AnalyticTypes::class,
                'property_analytics',
                'property_id',
                'analytic_type_id')->withPivot(['value']);
    }
}
