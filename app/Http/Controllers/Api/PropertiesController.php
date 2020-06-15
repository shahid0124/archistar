<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Strategies\SearchBy\Country;
use App\Strategies\SearchBy\State;
use App\Strategies\SearchBy\Suburb;
use Illuminate\Http\Request;
use App\Http\Resources\AnalyticsTypeResource;

class PropertiesController extends Controller
{
    /**
     * Post api/properties
     * This method is used to create a property in the database
     *
     * @param Properties $properties
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Properties $properties, Request $request)
    {
        $data = $this->validate($request, [
            'state' => 'required',
            'suburb' => 'required',
            'country' => 'required'
        ]);

        $properties->create($data);

        $this->http_status = 200;
        $this->message = ['message' => 'Property Created'];

        return $this->respond();
    }

    /**
     * This method is used to return the analytics for a give property
     * Get api/properties/{property_id}
     *
     * @param $property_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function get($property_id)
    {
        $this->findProperty($property_id, $properties);

        $propertyAnalytics = $properties->propertyAnalytics()->get();

        return AnalyticsTypeResource::collection($propertyAnalytics);
    }

    /**
     * Get api/properties/summary_by_suburb/{suburb}
     *
     * @param $suburb
     * @return mixed
     */
    public function getSummaryBySuburb($suburb)
    {
        return $this->calculateAnalytic('suburb', $suburb);
    }

    /**
     * Get api/properties/summary_by_country/{country}
     *
     * @param $country
     * @return mixed
     */
    public function getSummaryByCountry($country)
    {
        return $this->calculateAnalytic('country', $country);
    }

    /**
     * Get api/properties/summary_by_state/{state}
     *
     * @param $state
     * @return mixed
     */
    public function getSummaryByState($state)
    {
        return $this->calculateAnalytic('state', $state);
    }

    /**
     * Calls strategy and initiates it with the particular object
     *
     * @param $columnType
     * @param $columnValue
     * @return mixed
     */
    protected function calculateAnalytic($columnType, $columnValue)
    {
        foreach ([Country::class, State::class, Suburb::class] as $classKey => $classValue) {
            $obj = $classValue::init($columnType, $columnValue);
            if ($obj) {
                return $obj->propertiesSummaryAnalytics();
            }
        }
    }
}
