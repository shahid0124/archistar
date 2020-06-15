<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $message = [];

    /**
     * @var integer/string
     */
    protected $http_status = 0;

    /**
     * @var array
     */
    protected $statusCodes = [
        'ok' => 200,
        'created' => 201,
        'removed' => 204,
        'not_valid' => 400,
        'not_found' => 404,
        'conflict' => 409,
        'permissions' => 401
    ];

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond()
    {
        return response()->json($this->message,
            is_int($this->http_status) ? $this->http_status : $this->statusCodes[$this->http_status]);
    }

    /**
     * @throws ValidationException
     */
    protected function throwRespond()
    {
        $dumyValidater = $this->getValidationFactory()->make([], []);
        throw new ValidationException($dumyValidater, $this->respond());
    }

    /**
     * This method is used to check if property exists on server side or not
     *
     * @param $property_id
     * @param Properties|null $properties
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function findProperty($property_id, Properties &$properties = null)
    {
        $properties = Properties::find($property_id);

        if (!$properties) {
            $this->http_status = 404;
            $this->message = ['message' => 'Property Not found.'];

            return $this->throwRespond();
        }
    }
}
