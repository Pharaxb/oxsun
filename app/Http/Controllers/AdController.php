<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdLocation;
use App\Models\Age;
use App\Models\Operator;
use App\Models\Province;
use App\Models\Setting;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Ramsey\Uuid\Uuid;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ads.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::where('is_active', true)->get();
        $operators = Operator::all();
        return view('ads.create', compact('provinces', 'operators'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|between:10,1000',
            'file' => [
                'required', 'file',
                function ($attribute, $value, $fail) {
                    $is_image = Validator::make(
                        ['upload' => $value],
                        ['upload' => 'image']
                    )->passes();

                    $is_video = Validator::make(
                        ['upload' => $value],
                        ['upload' => 'mimes:mp4,ogg,qt']
                    )->passes();

                    if (!$is_video && !$is_image) {
                        $fail(':attribute must be image or video.');
                    }

                    if ($is_video) {
                        $validator = Validator::make(
                            ['video' => $value],
                            ['video' => "max:102400"]
                        );
                        if ($validator->fails()) {
                            $fail(":attribute must be 100 megabyte or less.");
                        }
                    }

                    if ($is_image) {
                        $validator = Validator::make(
                            ['image' => $value],
                            ['image' => "max:10240"]
                        );
                        if ($validator->fails()) {
                            $fail(":attribute must be 10 megabyte or less.");
                        }
                    }
                },
            ],
            'circulation' => 'required|integer|min:100',
            'cost' => 'required|integer|min:10000',
            'min_age' => 'nullable|integer|between:10,100',
            'max_age' => 'nullable|integer|between:10,100',
            'selectedProvinces' => 'required',
            'selectedCities' => 'nullable',
            'selectedDistricts' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable'
        ])->validate();


        if ($request->has('ageFilter')) {
            $min_age = Age::where('group', $request->min_age)->value('id');
            $max_age = Age::where('group', $request->max_age)->value('id');
        }
        else {
            $min_age = null;
            $max_age = null;
        }

        $commission = Setting::where('key', 'commission')->value('value');

        $gender = ($request->gender == 'all') ? null : $request->gender;
        $operator = ($request->operator == '0') ? null : $request->operator;
        $start_date = ($request->start_date == null) ? Carbon::now()->format('Y-m-d') : Verta::parse($request->start_date)->formatGregorian('Y-m-d');
        $end_date = ($request->end_date == null) ? Carbon::now()->addDay(30)->format('Y-m-d') : Verta::parse($request->end_date)->formatGregorian('Y-m-d');
        $provinces = $request->selectedProvinces;
        $cities = $request->selectedCities;
        $districts = $request->selectedDistricts;
        $locationsArr = [
            'provinces' => $provinces,
            'cities' => $cities,
            'districts' => $districts,
        ];
        $locations = json_encode($locationsArr);

        $ad_data = [
            'uuid' => Uuid::uuid4()->toString(),
            'title' => $request->title,
            'description' => $request->description,
            'circulation' => $request->circulation,
            'cost' => $request->cost,
            'commission' => $commission,
            'locations' => $locations,
            'gender' => $gender,
            'operator_id' => $operator,
            'min_age_id' => $min_age,
            'max_age_id' => $max_age,
            'status_id' => 4,
            'is_verify' => 1,
            'admin_id' => auth()->user()->id,
            'comment'=> 'ثبت شده از طریق پنل مدیریت',
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        $mime = $request->file->getMimeType();
        if ($mime == "video/mp4" or $mime == "video/ogg" or $mime == "video/quicktime")
        {
            $ad_data['file_type'] = "V";
            $result = $this->uploadVideo($request->file);
            if($result['success'] == true)
            {
                $ad_data['file'] = $result['message'];
            }
            else
            {
                return $this->sendError('Upload problem', $result['message']);
            }
        }
        else
        {
            $ad_data['file_type'] = "P";
            $result = $this->uploadImage($request->file);
            if($result['success'] == true)
            {
                $ad_data['file'] = $result['message'];
            }
            else
            {
                return $this->sendError('Upload problem', $result['message']);
            }
        }

        try {
            $ad = Ad::create($ad_data);

            return redirect(route('ads.index'));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    private function uploadVideo($file)
    {
        $path = '/media/ads/oxsun/video/';
        $uuid = Uuid::uuid4()->toString();
        $filename = $uuid.".mp4";
        $fullPath = $path.$filename;
        try {
            FFMpeg::open($file)
                ->export()
                ->inFormat(new \FFMpeg\Format\Video\X264)
                ->resize(1080, 1350, 'inset')
                ->toDisk('public')
                ->save($fullPath);
        } catch (EncodingException $exception) {
            $errorLog = $exception->getErrorOutput();

            $result = ['success' => false, 'message' => $errorLog];
            return $result;
        }

        $result = ['success' => true, 'message' => $filename];
        return $result;
    }

    private function uploadImage($file)
    {
        $path = '/media/ads/oxsun/image/';
        $uuid = Uuid::uuid4()->toString();
        $fileExt = strtolower($file->getClientOriginalExtension());
        $filename = $uuid.".".$fileExt;
        $fullPath = $path.$filename;
        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }
        try {
            $image = ImageManager::gd()->read($file)
                ->cover(1080, 1350)->encode(new AutoEncoder(quality: 85));
            Storage::disk('public')->put($fullPath, (string) $image);
        }
        catch (\Exception $e) {
            $result = ['success' => false, 'message' => $e->getMessage()];
            return $result;
        }
        $result = ['success' => true, 'message' => $filename];
        return $result;
    }

    private function ad_locations($adId, $locations)
    {
        $locationsArr = json_decode($locations);
        if(isset($locationsArr->provinces)) {
            $provinces = $locationsArr->provinces;
            $provincesCount = count($provinces);
            if($provincesCount == 1) {
                $provinceId = $locationsArr->provinces[0];
                $cities = $locationsArr->cities;
                $citiesCount = count($cities);
                if ($citiesCount == 1) {
                    $cityId = $locationsArr->cities[0];
                    $districts = $locationsArr->districts;
                    $districtsCount = count($districts);
                    if ($districtsCount > 0) {
                        foreach ($districts as $district) {
                            AdLocation::create([
                                'ad_id' => $adId,
                                'province_id' => $provinceId,
                                'city_id' => $cityId,
                                'district_id' => $district
                            ]);
                        }
                    }
                    else {
                        foreach ($cities as $city) {
                            AdLocation::create([
                                'ad_id' => $adId,
                                'province_id' => $provinceId,
                                'city_id' => $city
                            ]);
                        }
                    }
                }
                elseif ($citiesCount > 1) {
                    foreach ($cities as $city) {
                        AdLocation::create([
                            'ad_id' => $adId,
                            'province_id' => $provinceId,
                            'city_id' => $city
                        ]);
                    }
                }
                else {
                    AdLocation::create([
                        'ad_id' => $adId,
                        'province_id' => $provinceId
                    ]);
                }

            }
            elseif ($provincesCount > 1) {
                foreach ($provinces as $province) {
                    AdLocation::create([
                        'ad_id' => $adId,
                        'province_id' => $province,
                    ]);
                }
            }
            else {
                AdLocation::create([
                    'ad_id' => $adId
                ]);
            }
        }
        else {
            AdLocation::create([
                'ad_id' => $adId
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        //
    }

    public function media($media)
    {
        $ad = Ad::where('uuid', $media)->where('status_id', 4)->firstOrFail();
        $fileType = ($ad->file_type == "P") ? "image" : "video";
        $fullPath = 'media/ads/'.$ad->user_id.'/'.$fileType.'/'.$ad->file;
        if (!Storage::disk('public')->exists($fullPath)) {
            abort(404, 'File not found');
        }
        return Storage::disk('public')->response($fullPath);

    }
}
