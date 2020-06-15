<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnalyticTypes;
use App\Models\Properties;
use App\Models\PropertyAnalytics;
use Illuminate\Http\Request;

class PropertyAnalyticsController extends Controller
{
    /**
     * post /api/properties/{property_id}/analytics/{analytics_id}
     *
     * @param $property_id
     * @param $analytics_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create($property_id, $analytics_id, Request $request)
    {
        $data = $this->validate($request, [
            'value' => 'nullable'
        ]);

        $this->findProperty($property_id, $properties);

        $this->findAnalytics($analytics_id, $analyticTypes);

        $this->checkAnalyticsForCreate($analytics_id, $properties);

        $properties->propertyAnalytics()->attach(['analytic_type_id' => $analytics_id], ['value' => $data['value']]);

        $this->http_status = 200;

        $this->message = ['message' => 'Analytics attached to property'];

        return $this->respond();
    }

    /**
     *  patch /api/properties/{property_id}/analytics/{analytics_id}
     *
     * @param $property_id
     * @param $analytics_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($property_id, $analytics_id, Request $request)
    {
        $data = $this->validate($request, [
            'analytic_type_id' => 'required',
            'value' => 'nullable'
        ]);

        $this->findProperty($property_id, $properties);

        $this->findAnalytics($analytics_id, $analyticTypes);

        $this->checkAnalyticsForUpdate($analytics_id, $properties);

        $properties->propertyAnalytics()->detach($analytics_id);

        $properties->propertyAnalytics()->attach(['analytic_type_id' => $data['analytic_type_id']],
            ['value' => $data['value']]);

        $this->http_status = 200;
        $this->message = ['message' => 'Property Analytics has been updated'];

        return $this->respond();
    }

    /**
     * Check analytics before create
     *
     * @param $analytics_id
     * @param $properties
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function checkAnalyticsForCreate($analytics_id, $properties)
    {
        $propertyAnalytic = $properties->propertyAnalytics()->where('analytic_type_id', $analytics_id)->first();

        if ($propertyAnalytic) {
            $this->http_status = 422;
            $this->message = ['message' => 'Property Analytics Already Exists'];

            return $this->throwRespond();
        }
    }

    /**
     * Checks analytics exists before update
     *
     * @param $analytics_id
     * @param $properties
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function checkAnalyticsForUpdate($analytics_id, $properties)
    {
        $propertyAnalytic = $properties->propertyAnalytics()->where('analytic_type_id', $analytics_id)->first();

        if (!$propertyAnalytic) {
            $this->http_status = 404;
            $this->message = ['message' => 'Property Analytics Does Not Exist'];

            return $this->throwRespond();
        }
    }

    /**
     * This method is used to make sure particular analytic is present in analytic types
     *
     * @param $analytics_id
     * @param AnalyticTypes|null $analyticTypes
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function findAnalytics($analytics_id, AnalyticTypes &$analyticTypes = null)
    {
        $analyticTypes = AnalyticTypes::find($analytics_id);

        if (!$analyticTypes) {
            $this->http_status = 404;
            $this->message = ['message' => 'Analytics Type Does Not Exist'];

            return $this->throwRespond();
        }
    }
}
