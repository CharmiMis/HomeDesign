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
            $response = $this->serverLessCurlRequests($url, $payload);
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

    public function runpodPrecion(Request $request)
    {
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
                "room_type" => strtolower($payloadData['roomtype']),
                "design_style" => strtolower($payloadData['design_style']),
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
            $result = [
                'Sucess' => [
                    'original_image' => $response['output']['input_image'],
                    'generated_image' => $response['output']['output_images'],
                ],
            ];

            $storeData = $this->getDataToSaveForPrecision($response, $payloadData, $prompt);
            $dataSaved = $this->saveData($storeData);
            if($dataSaved){
                $result['storedIds'] = $dataSaved['storedIds'];
                return json_encode($result);
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

    public function saveData($storeData)
    {
        $data = $storeData;
        $validator = Validator::make($storeData, [
            'original_image' => 'required',
            'generated_image' => 'required',
            'style' => 'required',
            'room_type' => 'required',
            'user_uid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 403);
        }
        if ($data['mode'] >= 1 && $data['mode'] <= 11) {
            $inpainting =  $data['mode'];
        }else {
            $inpainting = 0;
        }
        $generatedImages = $data['generated_image'];
        $storedIds = [];
        foreach ($generatedImages as $generatedImage) {
            $newRecord = PublicGallery::create([
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
            $storedIds[] = $newRecord->id;
        }
        return ['success' => true, 'message' => "Image Added", 'storedIds' => $storedIds];
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
                ->select('id','original_image', 'generated_image', 'style', 'mode', 'room_type','is_favorite','is_inpainting','hd_image','design_type');
            $designs = $designs_query->orderBy('id', 'desc')->paginate(9);
            // if ($designs->isEmpty()) {
            //     $demoImages = $this->getStaticImages($request->inpainting);
            //     $demoDesigns = collect($demoImages); // Convert array to collection to match pagination
            //     $data = ['demoDesigns' => $demoDesigns];
            //     $imageHtml = view('web2.user.show-demo-inpainting-data', $data)->render();
            // }else{
            //     $data = ['designs' => $designs];
            //     $imageHtml = view('web2.user.show-inpainting-data', $data)->render();
            // }
            $data = ['designs' => $designs];
            $imageHtml = view('web2.user.show-inpainting-data', $data)->render();
            // $validValues = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            // if (in_array($request->inpainting, $validValues)) {
            //     $imageHtml = view('web2.user.show-inpainting-data', $data)->render();
            // } else {
            //     $imageHtml = view('web.user.show-inpainting-data', $data)->render();
            // }

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

    public function inPainting(){
        return view('web2.user.in-painting');
    }

    public function getFullHdData(Request $request)
    {
        $imageUrl = $request->input('image');
        $imageData = PublicGallery::where("generated_image", $imageUrl)->first();
        $path = $imageUrl;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = pathinfo($path, PATHINFO_BASENAME);
        $data = file_get_contents($path);
        $base64 = base64_encode($data);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $arrayData = [];
        $arrayData = [
            'privateId' => $imageData->is_public,
            'user_uid' => $imageData->user_uid,
            'image' => $base64,
            'fileName' => $fileName,
            'room_type' => $imageData->room_type,
            'style' => $imageData->style,
            'mode' => $imageData->mode,
            'sec' => $imageData->design_type,
        ];
        return response()->json(['data' => $arrayData, 200]);
    }

    public function imageDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        // Perform validation on $ids if needed
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        try {
            // Use a single database query to delete multiple ids
            PublicGallery::whereIn('id', $ids)->delete();

            return response()->json(['message' => 'Images deleted successfully']);
        } catch (\Exception $e) {
            // Handle database error
            return response()->json(['message' => 'Error deleting images'], 500);
        }
    }

    public function runpodHostName(Request $request){
        $runpods = config('app.RUNPODS');

        $runpodType = $request->input('runpodType');
        $runpodId = '';
        $runpodName = '';

        $existingRunpod = Runpods::where('runpod_type', $runpodType)->first();
        $filteredRunpods = array_filter($runpods, function ($runpod) use ($runpodType) {
            return $runpod['runpod_type'] == $runpodType;
        });

        // Reset array keys to start from 0
        $filteredRunpods = array_values($filteredRunpods);

        if ($existingRunpod) {
            // Get the index of the existing runpod in the filtered array
            $existingIndex = array_search($existingRunpod->runpod_id, array_column($filteredRunpods, 'id'));
            // // Check if the index was found and if it's the last index
            if ($existingIndex !== false && $existingIndex == count($filteredRunpods) - 1) {
                // Wrap around to the first index if it's the last one
                $runpodId = $filteredRunpods[0]['id'];
                $existingRunpod->runpod_id = $runpodId;
                $existingRunpod->save();
                $runpodName = $filteredRunpods[0]['name'];
            } else {
                // Increase the index and get the new id
                $nextIndex = ($existingIndex + 1) % count($filteredRunpods);
                $runpodId = $filteredRunpods[$nextIndex]['id'];
                $existingRunpod->runpod_id = $runpodId;
                $existingRunpod->save();
                $runpodName = $filteredRunpods[$nextIndex]['name'];
            }
        }else{
            if ($filteredRunpods[0]['runpod_type'] == $runpodType) {
                $runpodId = $filteredRunpods[0]['id'];
                $runpodName = $filteredRunpods[0]['name'];
            }
            Runpods::create([
                'runpod_type' => $runpodType,
                'runpod_id' => $runpodId,
            ]);
        }
        return response()->json(['runpodName' => $runpodName]);
    }

    public function decorCount(){
        $decorFlagExit = UsersFlag::where('user_id', Auth::id())
            ->where('is_decor_count', 1)
            ->first();
        if ($decorFlagExit) {
            return response()->json(['success' => false, 'message' => 'Decor count already exists.']);
        } else {
            UsersFlag::create([
                'user_id' => Auth::id(),
                'is_decor_count' => 1,
            ]);
            return response()->json(['success' => true, 'message' => 'Decor count created successfully.']);
        }
    }

    public function runpodGetMasking(Request $request)
    {
        $queryparams = $request->except(['data']);
        $queryparams['id'] = Auth::id();
        $payload = $request->only('data');
        if ($request->session()->has('inputImageSession')) {
            $request->session()->forget('inputImageSession');
        }
        $uniqueFileName = $this->generateUniqueFileName();
        $googleStorageFileImageUrl = $this->storeImageToGoogleBucket($request->data,$uniqueFileName);
        $request->session()->put('inputImageSession', $googleStorageFileImageUrl['url']);

        $payload = [
            "input" => [
                "image" => $googleStorageFileImageUrl['url'],
                "width" => intval($request->width),
                "height" => intval($request->height),
            ]
        ];

        // $url = 'https://api.runpod.ai/v2/'.\Config::get('app.GPU_SERVERLESS_SEGMENTATION').'/runsync';
        $url = \Config::get('app.GPU_SERVERLESS_SEGMENTATION');
        $response = $this->serverLessCurlRequests($url, $payload);
        if (isset($response['output']['segmentation'])) {
            return json_encode($response['output']);
        } else {
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        }

        // $url = \Config::get('app.GPU_SERVER_HOST_SEG').'/get_masking?'.http_build_query($queryparams);
        // $headers = [
        //     'accept'=> 'multipart/form-data',
        //     'Access-Control-Allow-Origin'=> '*',
        // ];
        // $curlRequest = new CurlRequestClass();
        // return $curlRequest->curlRequests($url, $headers, $payload, 'POST');
    }

    public function runpodFullHD(Request $request)
    {
        $payloadData = $request->all();

        $request->merge(['id' => Auth::id()]);

        $uniqueFileName = $this->generateUniqueFileName();
        $googleStorageFileImageUrl = $this->storeImageToGoogleBucket($payloadData['data'],$uniqueFileName);

        if($googleStorageFileImageUrl === false){
            return response()->json(['error' => "Fail to upload File on Cloud Storage" ]);
        }

        $payload = [
            "input" => [
                "image" => $googleStorageFileImageUrl['url'],
                "unique_id" => $uniqueFileName,
            ]
        ];

        $url = \Config::get('app.GPU_SERVERLESS_HD_GENERATE');
        $response = $this->serverLessCurlRequests($url, $payload);
        if (isset($response['output']['errors'])) {
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        } else {
            $result = [
                'Sucess' => [
                    'original_image' => $response['output']['input_image'],
                    'generated_image' => $response['output']['output_images'],
                ],
            ];

            $storeData = $this->getDataToSaveForFullHDImage($response, $payloadData);
            $dataSaved = $this->saveData($storeData);
            if($dataSaved){
                $result['storedIds'] = $dataSaved['storedIds'];
                return json_encode($result);
            } else {
                Log::error($dataSaved);
                return json_encode(['error' => "Something went wrong. Please try again in some time."]);
            }
        }
    }

    public function getStaticImages($type){
        // Initialize arrays
        $imageData = [];

        // Define prefixes for each numeric type
        $prefixes = [
            0 => "redesign_00/",
            1 => "precision_01/",
            2 => "fillspaces_02/"
        ];

        // Ensure $type is valid and is one of the expected numeric values
        if (array_key_exists($type, $prefixes)) {
            $prefix = $prefixes[$type];
            for ($i = 0; $i <= 3; $i++) { // Assuming 3 images for each array
                $imageData[] = [
                    "id" => $i,
                    "original_image" => asset("demo_generated_images/" . $prefix . "original_image_" . ($i + 1) . ".png"),
                    "generated_image" => asset("demo_generated_images/" . $prefix . "generated_image_" . ($i + 1) . ".png"),
                    "style" => "Contemporary",
                    "mode" => "Creative Redesign",
                    "room_type" => "Living Room",
                    "is_public" => 0,
                    "is_favorite" => 0,
                    "hd_image" => 1,
                    "is_inpainting" => 0,
                    "design_type" => $type
                ];
            }
            return $imageData;
        } else {
            // Handle invalid $type here
            return [];
        }
    }

    public function getDataToSaveForFullHDImage($response, $payloadData)
    {
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
            "hd_image" => 1,
        ];

        return $storeData;
    }

    public function fillSpaces(){
        return view('web2.user.fill-spaces');
    }

    public function runpodFillSpace(Request $request){
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
                "design_style" => strtolower($payloadData['design_style']),
                "prompt" => !empty($payloadImage['prompt']) ? $payloadImage['prompt'] : "",
                "no_design" => intval($payloadData['no_of_Design']),
                "segment_type" => $segmentType,
                "unique_id" => $uniqueFileName,
            ]
        ];

        $url = \Config::get('app.GPU_SERVERLESS_FILL_SPACE');
        $response = $this->serverLessCurlRequests($url, $payload);
        if (isset($response['output']['errors'])) {
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        } else {
            $result = [
                'Sucess' => [
                    'original_image' => $response['output']['input_image'],
                    'generated_image' => $response['output']['output_images'],
                ],
            ];

            $storeData = $this->getDataToSaveForPrecision($response, $payloadData,$prompt);
            $dataSaved = $this->saveData($storeData);
            if($dataSaved){
                $result['storedIds'] = $dataSaved['storedIds'];
                return json_encode($result);
            }else{
                Log::error($dataSaved);
                return json_encode(['error' => "Something went wrong. Please try again in some time."]);
            }
        }
    }

    public function redesign()
    {
        return view('web2.user.redesign');
    }

    public function getDesigns(Request $request)
    {
        try {

            if ($request->type == 'private' && !auth()->check()) {
                return response()->json([
                    'success' => false
                ], 500);
            }

            // $designs_query = PublicGallery::select('id','original_image', 'generated_image', 'style', 'mode', 'room_type', 'is_public', 'is_favorite','hd_image','is_inpainting','design_type');

            $designs_query = PublicGallery::select('id','original_image', 'generated_image', 'style', 'mode', 'room_type', 'is_public', 'is_favorite','hd_image','is_inpainting','design_type')
            ->whereNotNull('generated_image')
            ->where('generated_image', '!=', '');
            if ($request->type == 'public') {
                $designs_query->public()->where('is_active', 1)->where('is_inpainting', 0);
            } else {
                $user = auth()->user();
                $designs_query->private()->where('user_uid', $user->id)->where('is_inpainting', 0);
            }
            if ($request->pageType == 'gallery') {
                $designs = $designs_query
                ->orderBy('id', 'desc')
                ->paginate(30);
                $data = ['designs' => $designs];
                $imageHtml = view('web.user.show-your-gallery-data', $data)->render();

                return response()->json([
                    'success' => true,
                    'data' => $imageHtml,
                    'pageType' => $request->pageType
                ]);
            }
            else if ($request->pageType == 'favorites') {
                $user = auth()->user();
                $designsQuery = PublicGallery::where('is_favorite', 1)
                    ->where('user_uid', $user->id)
                    ->select('id', 'original_image', 'generated_image', 'style', 'mode', 'room_type', 'is_public', 'is_favorite', 'is_inpainting', 'hd_image')
                    ->orderBy('id', 'desc');

                if ($request->designType == 0 || $request->designType == 99) {
                    if ($request->modeType == 'convenient_redesign') {
                        $designsQuery->where('is_inpainting', 0)
                            ->where('mode', 'Convenient Redesign');
                    } else {
                        $designsQuery->where('is_inpainting', $request->designType)
                            ->where('mode', '!=', 'Convenient Redesign');
                    }
                } else {
                    $designsQuery->where('is_inpainting', $request->designType);
                }

                $designs = $designsQuery->paginate(5);

                $data = ['designs' => $designs];
                $imageHtml = view('web2.user.show-favourite-data', $data)->render();

                return response()->json([
                    'success' => true,
                    'data' => $imageHtml,
                    'pageType' => $request->pageType
                ]);
            }
             else {
                if($request->modeType == 'convenient_redesign'){
                    $designs = $designs_query
                        ->where('design_type', $request->designType)
                        ->where('mode', 'Convenient Redesign')
                        ->orderBy('id', 'desc')
                        ->paginate(config('app.PUBLIC_DESIGNS_COUNT'));
                } else {
                    $designs = $designs_query
                        ->where('design_type', $request->designType)
                        ->where('mode', '!=', 'Convenient Redesign')
                        ->orderBy('id', 'desc')
                        ->paginate(config('app.PUBLIC_DESIGNS_COUNT'));
                }
                $data = ['designs' => $designs];
                $imageHtml = view('web2.user.show-redesign-data', $data)->render();

                return response()->json([
                    'success' => true,
                    'data' => $imageHtml,
                    'pageType' => $request->pageType
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function runpodBeautifulRedesign(Request $request){
        $payloadData = $request->all();
        $request->merge(['id' => Auth::id()]);

        $uniqueFileName = $this->generateUniqueFileName();
        if (strpos($payloadData['data'], 'http://') === 0 || strpos($payloadData['data'], 'https://') === 0) {
            $b64image = base64_encode(file_get_contents($payloadData['data']));
            $googleStorageFileUrl = $this->storeImageToGoogleBucket($b64image,$uniqueFileName);
        } else {
            $googleStorageFileUrl = $this->storeImageToGoogleBucket($payloadData['data'],$uniqueFileName);
        }

        if($googleStorageFileUrl === false){
            return response()->json(['error' => "Fail to upload File on Cloud Storage" ]);
        }

        $payload = [
            "input" => [
                "image" => $googleStorageFileUrl['url'],
                "design_type" => intval($payloadData['designtype']),
                "room_type" => $payloadData['roomtype'],
                "design_style" => strtolower($payloadData['prompt']),
                "prompt" => !empty($payloadData['custom_instruction']) ? $payloadData['custom_instruction'] : "",
                "negative_prompt" => !empty($payloadData['is_custom_negative_instruction']) ? $payloadData['is_custom_negative_instruction'] : "",
                "ai_intervention" => $payloadData['strengthType'],
                "no_design" => intval($payloadData['no_of_Design']),
                "unique_id" => $uniqueFileName,
            ]
        ];

        $url = \Config::get('app.GPU_SERVERLESS_BEAUTIFUL_REDESIGN');
        $response = $this->serverLessCurlRequests($url, $payload);
        if(isset($response['status']) && $response['status'] == 'FAILED'){
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        }
        else if (isset($response['output']['errors'])) {
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        } else {
            $result = [
                'Sucess' => [
                    'original_image' => $response['output']['input_image'],
                    'generated_image' => $response['output']['output_images'],
                ],
            ];

            $storeData = $this->getDataToSaveForRedesign($response, $payloadData);
            $dataSaved = $this->saveData($storeData);
            if($dataSaved){
                $result['storedIds'] = $dataSaved['storedIds'];
                return json_encode($result);
            }else{
                Log::error($dataSaved);
                return json_encode(['error' => "Something went wrong. Please try again in some time."]);
            }
        }
    }

    public function getDataToSaveForRedesign($response,$payloadData){
        $style = "";
        if(isset($payloadData['prompt'])){
            $style = $payloadData['prompt'];
        } else if(isset($payloadData['design_style'])){
            $style = $payloadData['design_style'];
        }
        $storeData = [
            "original_image" => $response['output']['input_image'],
            "generated_image" => $response['output']['output_images'],
            "style" => !empty($style) ? $style : "N/A",
            "room_type" => !empty($payloadData['roomtype']) ? $payloadData['roomtype'] : "N/A",
            "mode" => $payloadData['modeType'],
            "user_uid" => Auth::id(),
            "is_public" => $payloadData['public'],
            "designtype" => intval($payloadData['designtype']),
            "prompt" => !empty($payloadData['is_custom_instruction']) ? $payloadData['is_custom_instruction'] : "",
            "hd_image" => 0,
        ];

        return $storeData;
    }

    public function paintVisulizerIndex()
    {
        return view('web2.user.paint-visualizer');
    }

    public function runpodColorSwapTransfer(Request $request)
    {
        $payloadData = $request->all();
        $prompt = "";
        if ($request->session()->has('inputImageSession')) {
            $googleStorageFileImageUrl['url'] = $request->session()->get('inputImageSession');
            $uniqueFileName = str_replace(['https://storage.googleapis.com/generativeartbucket/UserGenerations/cristian/input-', '.png'],'',
                                $googleStorageFileImageUrl['url']
                            );
            $request->session()->forget('inputImageSession');
        } else {
            $uniqueFileName = $this->generateUniqueFileName();
            $googleStorageFileImageUrl = $this->storeImageToGoogleBucket($payloadData['init_images'],$uniqueFileName);
        }
        $googleStorageFileMaskUrl = $this->storeImageToGoogleBucket($payloadData['mask'],$uniqueFileName,$isMask = true);
        if(!empty($payloadData['texture_image']) && $payloadData['texture_image'] !== 'undefined'){
            $googleStorageFileTextureUrl = $this->storeImageToGoogleBucket($payloadData['texture_image'],$uniqueFileName,$isMask = false,$texture = false,$colorTexture = true);
        }else{
            $googleStorageFileTextureUrl['url'] = '';
        }
        $segmentType = filter_var($payloadData['segmentType'], FILTER_VALIDATE_BOOLEAN);

        if($googleStorageFileImageUrl === false || $googleStorageFileMaskUrl === false){
            return response()->json(['error' => "Fail to upload File on Cloud Storage" ]);
        }

        $segmentType = filter_var($payloadData['segmentType'], FILTER_VALIDATE_BOOLEAN);

        $no_of_design = intval($payloadData['no_of_Design']);

        $payloads = [
            "input" => [
                "image" => $googleStorageFileImageUrl['url'],
                "mask_image" => $googleStorageFileMaskUrl['url'],
                "color_image" => $googleStorageFileTextureUrl['url'],
                "segment_type" => $segmentType,
                "no_design" => $no_of_design,
                "object" => $payloadData['objects'],
                "rgb_color" => $payloadData['rgb_color'],
                "unique_id" => $uniqueFileName,
            ]
        ];
        $urls = \Config::get('app.GPU_SERVERLESS_COLOR_SWAP_2');

        $response = $this->serverLessCurlRequests($urls, $payloads);
        if (isset($response['output']['errors'])) {
            Log::error($response);
            return json_encode(['error' => "Something went wrong. Please try again in some time."]);
        } else {
            $result = [
                'Sucess' => [
                    'original_image' => $response['output']['input_image'],
                    'generated_image' => $response['output']['output_images'],
                ],
            ];

            $storeData = $this->getDataToSaveForPrecision($response, $payloadData,$prompt);
            $dataSaved = $this->saveData($storeData);
            if($dataSaved){
                $result['storedIds'] = $dataSaved['storedIds'];
                return json_encode($result);
            }else{
                Log::error($dataSaved);
                return json_encode(['error' => "Something went wrong. Please try again in some time."]);
            }
        }
    }
}
