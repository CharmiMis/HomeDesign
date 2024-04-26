<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Lib\Curl\CurlRequestClass;
use App\Models\PublicGallery;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PrecisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function failedResponseData(Request $request){
        $response = $request->response;
        $payload = $request->payload;
        $payloadData = $request->payloadData;
        $prompt = $request->prompt;
        Log::info($response,$payload);
        while ($response['status'] === 'IN_PROGRESS' || $response['status'] === 'IN_QUEUE') {
            sleep(5); // Wait for 5 seconds before making the next request
            $responseFailId = $response['id'];
            $url = \Config::get('app.GPU_SERVERLESS_FAIL_SKY_COLOR') . $responseFailId;
            $response = $this->curlRequest->serverLessCurlRequests($url, $payload);
            Log::info($response);
        }
        if (isset($response['output']['errors'])) {
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        } else {
            $result = $response['output']['output_images'];

            $storeData = $this->getDataToSaveForPrecision($response, $payloadData,$prompt);
            $dataSaved = $this->saveData($storeData);
            if($dataSaved){
                return json_encode(['Sucess' => $result]);
            }else{
                Log::error($dataSaved);
                return json_encode(['error' => "Something went wrong. Please try again in some time."]);
            }
        }
    }

    public function runpodPrecion(Request $request){

        $payloadData = $request->all();
        $payloadImage = json_decode($request->payload, true);
        $prompt = $payloadImage['prompt'];
        if ($request->session()->has('inputImageSession')) {
            $googleStorageFileImageUrl['url'] = $request->session()->get('inputImageSession');
            $uniqueFileName = str_replace(['https://storage.googleapis.com/generativeartbucket/UserGenerations/cristian/input-', '.png'],'',
                                $googleStorageFileImageUrl['url']
                            );
            $request->session()->forget('inputImageSession');
        } else {
            $uniqueFileName = $this->generateUniqueFileName();
            $googleStorageFileImageUrl = $this->storeImageToGoogleBucket($payloadImage['init_images'],$uniqueFileName);
        }
        $googleStorageFileMaskUrl = $this->storeImageToGoogleBucket($payloadImage['mask'],$uniqueFileName,$isMask = true);
        $segmentType = filter_var($payloadData['segmentType'], FILTER_VALIDATE_BOOLEAN);

        if($googleStorageFileImageUrl === false || $googleStorageFileMaskUrl === false){
            return response()->json(['error' => "Fail to upload File on Cloud Storage" ]);
        }

        $payload = [
            "input" => [
                "image" => $googleStorageFileImageUrl['url'],
                "mask_image" => $googleStorageFileMaskUrl['url'],
                "design_type" => intval($payloadData['designtype']),
                "room_type" => $payloadData['roomtype'],
                "design_style" => $payloadData['design_style'],
                "prompt" => !empty($payloadImage['prompt']) ? $payloadImage['prompt'] : "",
                "no_design" => intval($payloadData['no_of_Design']),
                "segment_type" => $segmentType,
                "unique_id" => $uniqueFileName,
            ]
        ];
        $url = \Config::get('app.GPU_SERVERLESS_PRECISION');
        $response = $this->serverLessCurlRequests($url, $payload);
        if (isset($response['output']['errors'])) {
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        } else {
            $result = $response['output']['output_images'];

            $storeData = $this->getDataToSaveForPrecision($response, $payloadData,$prompt);
            $dataSaved = $this->saveData($storeData);
            if($dataSaved){
                return json_encode(['Sucess' => $result]);
            }else{
                Log::error($dataSaved);
                return json_encode(['error' => "Something went wrong. Please try again in some time."]);
            }
        }
    }

    public function generateUniqueFileName(){
        $time = date("Y-m-d-H-i-s", strtotime("now"));
        $uuid = Str::uuid();

        return $uuid.'-'.$time;
    }

    public function storeImageToGoogleBucket($image,$uniqueFileName,$isMask = null){
        $bucketname = 'generativeartbucket';
        $file_name = 'UserGenerations/cristian/input-'. $uniqueFileName .'.png';
        if($isMask){
            $file_name = 'UserGenerations/cristian/mask/input-'. $uniqueFileName .'.png';
        }
        $base64String = preg_replace('#^data:image/\w+;base64,#i', '', $image);
        $fileContents = base64_decode($base64String);

        try {
            $storage = new StorageClient([
                'keyFile' => json_decode(file_get_contents(public_path('plated-howl-370821-cf0e409bcbaa.json')), true)
            ]);
            $bucket = $storage->bucket('generativeartbucket');
            $bucket->upload($fileContents, ['name' => $file_name,]);
            $uploadedFile = $bucket->object($file_name);
            $fileExists = $uploadedFile->exists();
            if ($fileExists) {
                return [
                    'url' => 'https://storage.googleapis.com/'.$bucketname.'/'.$file_name,
                ];
            } else {
                return false;
            }
        } catch(\UnableToWriteFile|UnableToSetVisibility $e) {
            \Log::error("Unable to write a file in google bucket".$e->getMessage());
            return false;
        }
    }

    public function getDataToSaveForPrecision($response,$payloadData,$prompt){

        $storeData = [
            "original_image" => $response['output']['input_image'],
            "generated_image" => $response['output']['output_images'],
            "style" => !empty($payloadData['design_style']) ? $payloadData['design_style'] : "N/A",
            "room_type" => !empty($payloadData['roomtype']) ? $payloadData['roomtype'] : "N/A",
            "mode" => $payloadData['modeType'],
            "user_uid" => Auth::id(),
            "is_public" => 0,
            "designtype" => intval($payloadData['designtype']),
            "prompt" => !empty($prompt) ? $prompt : "",
            "hd_image" => 0,
        ];

        return $storeData;
    }

    public function saveData($storeData){
        $data = $storeData;
        $validator  = Validator::make($storeData, [
            'original_image' => 'required',
            'generated_image' => 'required',
            'style' => 'required',
            'room_type' => 'required',
            'user_uid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 403);
        }
        if ($data['mode'] == 1) {
            $inpainting = 1;
        }elseif ($data['mode'] == 2){
            $inpainting = 2;
        }elseif ($data['mode'] == 3){
            $inpainting = 3;
        }
        elseif ($data['mode'] == 4){
            $inpainting = 4;
        }
        elseif ($data['mode'] == 5){
            $inpainting = 5;
        }
        elseif ($data['mode'] == 6){
            $inpainting = 6;
        }
         else {
            $inpainting = 0;
        }
        $generatedImages = $data['generated_image'];
        foreach ($generatedImages as $generatedImage) {
            PublicGallery::create([
                'original_image' => $data['original_image'],
                'generated_image' => $generatedImage,
                'style' => $data['style'],
                'room_type' => $data['room_type'],
                'mode' => $data['mode'],
                'user_uid' => $data['user_uid'],
                'is_public' => $data['is_public'] ? $data['is_public'] : 0,
                'is_inpainting' => $inpainting,
                'design_type' => $data['designtype'] ? $data['designtype'] : 0,
                'prompt' => $data['prompt'] ? $data['prompt'] : '-',
                'hd_image' => $data['hd_image'],
            ]);
        }
        return response()->json(['message' => "Image Added", 'success' => true]);
    }

    public function serverLessCurlRequests($url,$payload){
        $bearer_token = "64V8P6UDM32OR1YJF0YXZOQX1BRI6HOQ0ZVDR67A";

        $headers = [
            'Authorization: Bearer ' . $bearer_token,
            'Content-Type: application/json'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status == 200) {
            $data = json_decode($response, true);
            return $data;
        } else {
            $data = json_decode($response, true);
            return $data;
        }
    }

    public function getInPaintingDesigns(Request $request)
    {
        try {
            $user = auth()->user();
            $designs_query = PublicGallery::where('user_uid', $user->id)
                ->where('design_type', $request->designType)
                ->where('is_inpainting', $request->inpainting)
                ->select('id','original_image', 'generated_image', 'style', 'mode', 'room_type','is_favorite','is_inpainting','hd_image');
            $designs = $designs_query->orderBy('id', 'desc')->paginate(32);
            $data = ['designs' => $designs];
            $imageHtml = view('precision.show-inpainting-data', $data)->render();

            return response()->json([
                'success' => true,
                'data' => $imageHtml,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function downloadFile(Request $request)
    {

        try {

            $path = $request->source;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            return response()->json([
                'status' => true,
                'data' => [
                    'base64' => $base64
                ]
            ]);

            //code...
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'status' => false,
                'data' => []
            ], 500);
        }
    }

    public function getBase64ImageUrl(Request $request)
    {
        $b64image = base64_encode(file_get_contents($request->imageURL));
        return response()->json(['b64image' => $b64image]);
    }
}
