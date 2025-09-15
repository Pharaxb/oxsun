<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController as BaseController;
use App\Http\Resources\v1\AgeCollection;
use App\Http\Resources\v1\CityCollection;
use App\Http\Resources\v1\DistrictCollection;
use App\Http\Resources\v1\OperatorCollection;
use App\Http\Resources\v1\ProvinceCollection;
use App\Models\Age;
use App\Models\City;
use App\Models\District;
use App\Models\Operator;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdFilterController extends BaseController
{
    /**
     * List of Provinces.
     *
     * List of all provinces.
     *
     * @response array{success: bool, data: array{id: int, name: string, is_active: bool}, message: string, code: int}
     */
    public function getProvinces(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'active' => 'nullable|boolean'
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        if (isset($request->active)) {
            $active = $request->active;
            $provinces = Province::where('is_active', $active)->orderBy('name', 'asc')->get();
        }
        else {
            $provinces = Province::orderBy('name', 'asc')->get();
        }
        return $this->sendResponse(new ProvinceCollection($provinces), 'provinces fetched.');

    }

    /**
     * List of Cities.
     *
     * List of all cities.
     *
     * @response array{success: bool, data: array{id: int, name: string, is_active: bool}, message: string, code: int}
     */
    public function getCities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_id' => 'required|integer',
            'active' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        $provinceId = $request->province_id;
        if (isset($request->active)) {
            $active = $request->active;
            $cities = City::where('province_id', $provinceId)->where('is_active', $active)->orderBy('name', 'asc')->get();
        }
        else {
            $cities = City::where('province_id', $provinceId)->orderBy('name', 'asc')->get();
        }
        return $this->sendResponse(new CityCollection($cities), 'cities fetched.');
    }

    /**
     * List of Districts.
     *
     * List of all districts.
     *
     * @response array{success: bool, data: array{id: int, name: string, is_active: bool}, message: string, code: int}
     */
    public function getDistricts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|integer',
            'active' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        $cityId = $request->city_id;
        if (isset($request->active)) {
            $active = $request->active;
            $districts = District::where('city_id', $cityId)->where('is_active', $active)->orderBy('name', 'asc')->get();
        }
        else {
            $districts = District::where('city_id', $cityId)->orderBy('name', 'asc')->get();
        }
        return $this->sendResponse(new DistrictCollection($districts), 'districts fetched.');
    }

    /**
     * List of Operators.
     *
     * List of all mobile operators.
     *
     * @response array{success: bool, data: array{id: int, brand: string, name: string}, message: string, code: int}
     */
    public function getOperators()
    {
        $operators = Operator::all();
        return $this->sendResponse(new OperatorCollection($operators), 'operators fetched.');
    }

    /**
     * List of Ages.
     *
     * List of all ages.
     *
     * @response array{success: bool, data: array{id: int, group: string}, message: string, code: int}
     */
    public function getAges()
    {
        $ages = Age::all();
        return $this->sendResponse(new AgeCollection($ages), 'ages fetched.');
    }
}
