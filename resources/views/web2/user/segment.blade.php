@extends('web.layout.user-dash')
@section('styles')
    <style>
        .konvajs-content {
            margin: 0 auto;
        }
        .uploadInPaintingImage {
            max-width: 100%;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/cropper.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tensorflow/4.15.0/tf.min.js" integrity="sha512-RMW1ZrsUb7zY5+dY2sH+dOD3aPXpgQgWysvpyj+UtMani44bvq6Nj4HQ0tB/gdbG0gJb1BhapgYvUPNve0A6kQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endsection
@section('content')
    <?php
    $userActivePlan = '';
    $crossShellPlan = [];
    $precisionUser = false;
    if (auth()->check()) {
        $userActivePlan = auth()
            ->user()
            ->activePlan();
        $crossShellPlan = auth()->user()->crossShellPlan();
    }
    ?>
    <div class="nw-formouter" style="padding:0px;">
        <input type="hidden" id="modeValueForPage" value="4" />
        <div class="nw-forminner" style="border-radius: 0px;">
            <div class="container-fluid">
                <div class="page-inpainting">
                    <div class="inpainting-outer bg-dark-3">
                        <div>
                            <h5 class="text-center fw-bold" for="">Declutter Your Space Instantly With AI Furniture Removal</h5>
                            <div class="row">
                                <div class="col-sm-12 mt-3" style="font-size:15px;font-weight:400">
                                    <p>Our AI Furniture Removal feature is designed to help you declutter and empty rooms of furniture and other decorative elements, offering a fresh canvas to explore your interior design ideas. Is your room filled with furniture and decorations that no longer suit your style or the season? Are you planning to redecorate but struggling to visualize the possibilities through the clutter? HomeDesignsAI introduces an innovative solution to empty any room of furniture effortlessly. You can even remove objects from outside the house or even a tree from your garden.<strong>Whether it's outdated furniture, wall art, or even that misplaced vase, our AI effortlessly clears your space, giving you a blank slate to experiment with new layouts and designs.</strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 d-flex inpaint-stag-container decor_container" id="inpaint-stag">
                            <div class="col-sm-12 col-md-6">
                                {{-- <div class="help_modal"><a href="javascript:void(0)" onclick="showDecorHelpModal()">Help?</a></div> --}}
                                <div class="ico-head bg-dark-2">
                                    <div class="ribon-bx">
                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" loading="lazy">
                                        <div class="ribon-overlay">
                                            <img class="nwstepimg" src="{{ asset('web/images/') }}/fillvector.svg"
                                                loading="lazy">
                                            <span class="ribon-text"><strong>Step 1:</strong>
                                                Upload Image
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="inpainting-controls-outer bg-dark-2">
                                    <input type="hidden" class="data_page" data-page="segmentPage" />
                                    <div class="mb-3">
                                        <button type="button" class="ci-btn" id="inUploadBtn">Upload
                                            Image</button>
                                        <input id="ipFilePicker" type="file" class="d-none" id="inFilePicker" />
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-white">Brush Thickness: </span>
                                        <span class="text-white float-end" id="ip-brush-thickness-text">70</span>
                                        <div class="mt-2">
                                            <input class="form-range in-range" type="range" value="70" min="1"
                                                max="70" id="ip-brush-thickness">
                                        </div>
                                    </div>

									<div class="mt-3">
                                        <p style="font-size:15px;font-weight:400">
                                            <strong>HOW IT WORKS: </strong>Just upload your image and select all the objects that you want to erase from the image. It works for interiors, exteriors and gardens.
                                        </p>
                                    </div>
                                    <div class="mt-3 chkbox-segment">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div id="inpainting-stag-outer"
                                    class="inpainting-stag-outer d-flex align-items-center justify-content-center">
                                        {{-- load gif --}}
                                        {{-- <div class="decor_placehold decor_show_placehold">
                                            <img src="{{ asset('web/gif/decor_staging_gif.gif') }}" alt="Your GIF" width="100%">
                                        </div> --}}
                                    <div id="painting-stag" class="decor_img decor_hide_placehold">
                                    </div>
                                </div>
                                <div class="brushing-btns">
                                    <button class="ci-btn ci-btn-danger" id="ip-clearImage">
                                        <img src="{{asset('web/images/deleteIcon.png')}}" width="25px"> Clear all
                                    </button>
                                    {{-- <button class="ci-btn ci-btn-danger" id="ip-undoImage"><img src="{{asset('web/images/undo.png')}}" width="25px"></button>
                                    <button class="ci-btn ci-btn-danger" id="ip-redoImage"><img src="{{asset('web/images/redo.png')}}" width="25px"></button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent"
                        style="background-image: linear-gradient( 180deg, hsl(254deg 52% 10%) 0%, hsl(256deg 56% 9%) 31%, hsl(258deg 61% 8%) 53%, hsl(258deg 68% 7%) 70%, hsl(257deg 78% 6%) 83%, hsl(254deg 91% 5%) 91%, hsl(254deg 91% 5%) 97%, hsl(254deg 91% 5%) 100%, hsl(254deg 91% 5%) 102%, hsl(254deg 91% 5%) 101%, hsl(254deg 91% 5%) 100% );padding: 10px;">
                        <div class="tab-pane fade show active" id="pills-interior" role="tabpanel"
                            aria-labelledby="pills-interior-tab">
                            <div class="nwfrm-contentouter" id="forminterior0">
                                <div class="mt-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex flex-column ip-options-container inpaintContainer">
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Number of designs </label>
                                                <select class="nwfiles-optns" id="no_of_design0">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <button type="button"
                                                    class="ci-btn ci-btn-primary painting_generating_bt"
                                                    id="generateDesignBtn0" onclick="_generateInPaintingDesign(0,this)">
                                                    Generate New Design <span id="submit" style="display:none"><i
                                                            class="fa fa-spinner fa-spin m-0"
                                                            aria-hidden="true"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="checkboxContainer">

                    <div class="row">
                     <div class="col-md-4 col-sm-4">
                            <p class="inpaint_message"
                                style="padding: 30px; color: #dfdfdf; font-weight: 500; border-radius: 10px; margin: 20px 0px 20px 0px; background: rgb(0,0,0); background: linear-gradient(66deg, rgb(21 13 46) 21%, rgba(18,12,38,1) 61%); border-top: 4px solid #7558ea; min-height: 220px;">
                                <strong>Simply upload any interior or exterior image</strong>, use the brush tool to select the objects that you want to remove and hit generate. You can select a number of up to 4 outputs to be generated at once.
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <p class="inpaint_message"
                                style="padding: 30px; color: #dfdfdf; font-weight: 500; border-radius: 10px; margin: 20px 0px 20px 0px; background: rgb(0,0,0); background: linear-gradient(66deg, rgb(21 13 46) 21%, rgba(18,12,38,1) 61%); border-top: 4px solid #7558ea; min-height: 220px;">
                                <strong>The source images you use have a huge impact on the quality of the outputs.</strong>
                                The selection of the image (with the brush tool) is also very important for good results.
                                Use the prompt box below to communicate the changes you want our AI to make in the selected
                                area.
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <p class="inpaint_message"
                                style="padding: 30px; color: #dfdfdf; font-weight: 500; border-radius: 10px; margin: 20px 0px 20px 0px; background: rgb(0,0,0); background: linear-gradient(66deg, rgb(21 13 46) 21%, rgba(18,12,38,1) 61%); border-top: 4px solid #7558ea; min-height: 220px;">
                                To generate good results consistently, avoid the following image types: low quality, low
                                resolution, pixelated images, blurry images, small images, screenshots, huge resolution
                                (e.g. 10.000px x 10.000px), big size (8 MB+), ultra wide angled images.
                                <br>
                            </p>
                        </div>
                    </div>
                    <div class="dlt-btn-main mt-3">
                        <button class="btn btn-danger delete_button hidden"
                            onclick="deleteMultipleImages()">Delete</button>
                    </div>
                    <div class="mt-3 mb-3">
                        <div class="row" id="virtualStagDesignContainer">
                        </div>
                    </div>
                </div>
                <!-- Modal to crop image -->
                <div class="modal" tabindex="-1" role="dialog" id="cropImageModal" data-bs-backdrop="static"
                    data-bs-keyboard="false">
                    <div class="modal-dialog decor-staging" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-3">
                                <div>
                                    <img class="uploadInPaintingImage" src="" id="imgCropPreview">
                                </div>
                            </div>
                            <div class="upload_btns_part">
                                <p style="margin:0;padding-right:5px;">Zoom in/out:</p>
								<button type="button" class="plush_btn" id="zoomInButton"
                                    style="display: none">+</button>
                                <button type="button" class="minus_btn" id="zoomOutButton"
                                    style="display: none">-</button>
                            </div>
                            <div class="modal-footer pt-0 border-0 modal_footer_part">
                                <label>
                                    <div class="main">
                                        <input type="checkbox" value="" id="myDecorCheckbox"
                                            class="check_for_crop">
                                        <span class="geekmark"></span>
                                    </div>
                                    <span class="span_strong">Preserve Aspect Ratio</span>
                                    <span><b>For optimal results, we recommend using square images.</b> However, if you prefer to maintain the original aspect ratio of your image, simply check the box on the left. Please note that while this option preserves the original image shape, the results may not be as refined as with square images. <br>
                                        {{-- <strong>Note: </strong> We recommend using an image with a transparent background.
                                        If upload a normal image,
                                        make sure you use the brush tool to mask everything but keep the object you want to
                                        use for staging. --}}
                                    </span>
                                </label>
                                <div class="crop_modal_btn">
                                    <button type="button" onclick="cropImageButton()" class="btn btn-primary-c"
                                        style="font-size:16px;">Crop
                                        Image</button>
                                    <button type="button" class="btn btn-secondary close-decor-stag" data-bs-dismiss="modal"
                                        style="font-size:16px;">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal to crop image -->
                <template id="inPaintingCard">
                    <div class="col-sm-12 col-md-3">
                        <div class="in-painting-card mb-3">
                            <img class="img" data-item="image">
                            <div class="card-options">
                                <div class="inpainting-btn">
                                    <a class="sharetab download" href="javascript:void(0)" target="_blank"
                                        data-item="download-btn" title="Download">
                                        <img class="hover_img" src="/web/images/download1-hover.svg">
                                        <span>Download</span>
                                    </a>
                                    <div class="sharetab share text-center ip_img_preview inpainting-preview"
                                        data-img="" data-item="preview-btn" title="Open">
                                        <img src="/web/images/magnifying1.svg">
                                        <span>Show</span>
                                    </div>
                                    <div class="sharetab full_hd_quality share text-center" data-img=""
                                        data-item="hd_quality" title="Full Hd Quality">
                                        <img src="/web/images/hd1.svg">
                                        <span>HD</span>
                                    </div>
                                    <a class="sharetab sharetab-buttons use-as-input-image" data-img=""
                                        data-item="user_as_input" title="Use as Input">
                                        <img src="/web/images/input1.svg" alt="" loading="lazy">
                                        <span>Input</span>
                                    </a>
                                </div>
                            </div>
                            {{-- <div class="chkimg imgcheckfordelete">
                                <input type="checkbox" class="ml_dw_img" onclick="getMultipleImages()"/>
                            </div> --}}
                            <div class="checkbox-animate">
                                <label>
                                    <input type="checkbox" name="check" class="ml_dw_img" onclick="getMultipleImages()">
                                    <span class="input-check"></span>
                                </label>
                            </div>
                            <div class="favcheck">
                                <img width="23" height="23" class="favcheckimg" src="{{ asset('web/images/white_heart.png') }}" onclick="addRemovefavorite())">
                            </div>
                            <div class="hd_image_div">
                                <img width="40" height="35" class="hd_image" src="/web/images/hd_icon.png">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <div class="inpainting-stag-loader"></div>
    <div class="modal" tabindex="-1" role="dialog" id="loadToStagLoader" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog decor-staging" role="document">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <h2>Uploading Image, please wait...</h2>
                    <div class="loader_image">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="routeToFullHdImageData" data-route="{{ route('getHdImages') }}"></div>
    <div id="routeToGetBase64Image" data-route="{{ route('getBase64Image.Url') }}"></div>
    <div id="deleteRenderImages" class="hidden" data-route="{{ route('image.delete') }}"></div>
@endsection
@section('scripts')
    <script src="{{ asset('web/js/konva.min.js') }}"></script>
    <script src="{{ asset('web/js/cropper.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery-cropper.js') }}"></script>
    <script src="{{ asset('web/js/in-painting-v2.js') }}?v={{ config('app.in_paint_v2_version') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js"></script>
    <script>
        async function loadRenders() {
            //var element = document.getElementById('virtualStagDesignContainer').innerHTML = ''; //not working
            var response = await getInPaintingGeneratedDesigns();
            //if (!response) {
            //    return;
            //}
            //consoel.log("rrrr11",response);
            //if (response != null && response.data.designs.length) {
            //    $('element').html(response.data);
            //}
            //if (response != null && response.data.designs.length) {
            //    $.each(response.data.designs, function(index, value) {
            //        var image = {
            //            image: value.generated_image
            //        }
            //        var itemHtml = generatedImageItem(image);
            //        $('#virtualStagDesignContainer').append(itemHtml);
            //    });
            //}
        }
        $(document).ready(function() {
            loadRenders();
        })
        function showDecorHelpModal(){
            $("#multipleDecorClick").modal('show');
        }
    </script>
@endsection
