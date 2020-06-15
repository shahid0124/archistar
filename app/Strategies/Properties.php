<?php

namespace App\Strategies;

use App\Contracts\Properties as PropertiesInterface;
use App\Http\Resources\PropertyAnalyticsResource;
use Illuminate\Support\Facades\DB;

abstract class Properties implements PropertiesInterface
{
    /**
     * @var $columnType
     */
    protected $columnType;
    /**
     * @var $columnValue
     */
    protected $columnValue;

    /**
     * Properties constructor.
     *
     * @param $columnType
     * @param $columnValue
     */
    public function __construct($columnType, $columnValue = null)
    {
        $this->columnType = $columnType;

        $this->columnValue = $columnValue;
    }

    /**
     * @return PropertyAnalyticsResource|\Illuminate\Http\JsonResponse
     */
    public function propertiesSummaryAnalytics()
    {
        if ($this->queryBuilder()->doesntExist()) {
            return response()->json(['message' => 'No Relative Records Exists for this Input'], 404);
        }

       $propertyAnalytics =  collect([
            'min_value' => $this->queryBuilder()->min('value') ?? 0,
            'max_value' => $this->queryBuilder()->max('value') ?? 0,
            'average_value' => $this->queryBuilder()->avg('value') ?? 0,
            'percentage_property_with_value' => ($this->queryBuilder()->whereNotNull('value')->count() / $this->queryBuilder()->count()) * 100 ?? 0,
            'percentage_property_without_value' => ($this->queryBuilder()->whereNull('value')->count() / $this->queryBuilder()->count()) * 100 ?? 0
        ]);

        return new PropertyAnalyticsResource($propertyAnalytics);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryBuilder()
    {
        return DB::table('properties')
            ->join('property_analytics', 'id', '=', 'property_id')
            ->where($this->columnType, $this->columnValue);
    }
}
