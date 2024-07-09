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
        <input type="hidden" id="modeValueForPage" value="1" />
        <div class="nw-forminner" style="border-radius: 0px;">
            <div class="container-fluid">
                <div class="page-inpainting">
                    <div class="inpainting-outer bg-dark-3">
                        <div class="text-center fw-bold">
                            <label for="">Upload your image and use the brush tool to redesign what you
                                select.</label>
                        </div>
                        <div style="display: flex;justify-content: center;align-items: center;gap: 8px;">
                            <a class="mt-3" style="color: white;cursor: pointer;padding-right:10px;font-size:16px;" onclick="loadVideoModal()"><img
                                    src="{{ asset('web/images/play-button.png') }}" width="30px" alt="" style="padding-right: 10px;"> Video
                                Tutorial</a>
                        </div>
                        <div class="row mt-4 d-flex inpaint-stag-container" id="inpaint-stag">
                            <div class="col-sm-12 col-md-6">
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
                                <input type="hidden" class="data_page" data-page="precision-segment" />
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
                                    <div class="mt-3 chkbox-segment">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="inpainting-stag-outer"
                                    class="inpainting-stag-outer d-flex align-items-center justify-content-center">
                                    <div id="painting-stag"></div>
                                </div>
                                <div class="brushing-btns">
                                    <button class="ci-btn ci-btn-danger" id="ip-clearImage" title="Clear All">
                                        <img src="{{asset('web/images/deleteIcon.png')}}" width="25px"> Clear all
                                    </button>
                                    <button class="ci-btn ci-btn-danger" id="ip-undoImage" title="Undo"><img src="{{asset('web/images/undo.png')}}" width="25px"></button>
                                    <button class="ci-btn ci-btn-danger" id="ip-redoImage" title="Redo"><img src="{{asset('web/images/redo.png')}}" width="25px"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent"
                        style="background-image: linear-gradient( 180deg, hsl(254deg 52% 10%) 0%, hsl(256deg 56% 9%) 31%, hsl(258deg 61% 8%) 53%, hsl(258deg 68% 7%) 70%, hsl(257deg 78% 6%) 83%, hsl(254deg 91% 5%) 91%, hsl(254deg 91% 5%) 97%, hsl(254deg 91% 5%) 100%, hsl(254deg 91% 5%) 102%, hsl(254deg 91% 5%) 101%, hsl(254deg 91% 5%) 100% );padding: 10px;">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex flex-column ip-options-container inpaintContainer">
                                <h2 class="cmn-title1"><strong> Select what you want to redesign:</strong></h2>
                                <div class="nwfrm-tabs inpaiting-tabs">
                                    <ul class="nav nav-pills" id="ai-category-pills" role="tablist">
                                        <li class="nav-item on-gen-disable" role="presentation">
                                            <button class="nav-link nwai-tab active" id="pills-interior-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-interior" type="button"
                                                role="tab" aria-controls="pills-interior" aria-selected="true"
                                                onclick="loadRenders(0)">
                                                <img class="ai-icon" src="{{ asset('web/images') }}/interior-icon.svg"
                                                    alt="" loading="lazy">
                                                <span class="nwtb-title">Interiors</span>
                                            </button>
                                        </li>
                                        <li class="nav-item on-gen-disable" role="presentation">
                                            <button class="nav-link nwai-tab" id="pills-exterior-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-exterior" type="button" role="tab"
                                                aria-controls="pills-exterior" aria-selected="false"
                                                onclick="loadRenders(1)">
                                                <img class="ai-icon" src="{{ asset('web/images/') }}/exterior-icon.svg"
                                                    alt="" loading="lazy">
                                                <span class="nwtb-title">Exteriors</span>
                                            </button>
                                        </li>
                                        <li class="nav-item on-gen-disable" role="presentation">
                                            <button class="nav-link nwai-tab" id="pills-garden-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-garden" type="button" role="tab"
                                                aria-controls="pills-garden" aria-selected="false"
                                                onclick="loadRenders(2)">
                                                <img class="ai-icon" src="{{ asset('web/images/') }}/garden-icon.svg"
                                                    alt="" loading="lazy">
                                                <span class="nwtb-title">Gardens</span>
                                            </button>
                                        </li>
                                    </ul>
                                    <br>
                                    <div class="loader_div" id="loaddividmobile">
                                        <img src="{{ asset('web/images/') }}/logoanm2.gif" class="loader-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="pills-interior" role="tabpanel"
                            aria-labelledby="pills-interior-tab">
                            <div class="nwfrm-contentouter" id="forminterior0">
                                <div class="mt-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex flex-column ip-options-container inpaintContainer">
                                            <div class="form-group">
                                                <label class="nwfile-tiTle">Add your AI prompt below. Use this box to
                                                    communicate with our AI and list the changes that you want it to make in
                                                    the selected area. Different prompting structures will yield different
                                                    results. Feel free to experiment!



                                                </label>
                                                <textarea name="prompt" id="promptInput0" rows="5" class="form-control cfi"
                                                    placeholder="e.g. Scandinavian dining room design, beautiful, white colors"></textarea>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Select Design Style</label>
                                                <select class="nwfiles-optns" id="promptInputDesign0">
                                                    @include('web.designs_options.interior_design_style')
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Select Room Type</label>
                                                <select class="nwfiles-optns" id="promptInputRoomType0">
                                                    @include('web.designs_options.interior_room_type')
                                                </select>
                                            </div>
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
                        <div class="tab-pane fade" id="pills-exterior" role="tabpanel"
                            aria-labelledby="pills-exterior-tab">
                            <div class="nwfrm-contentouter" id="forminterior1">
                                <div class="mt-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex flex-column ip-options-container inpaintContainer">
                                            <div class="form-group">
                                                <label class="nwfile-tiTle">Add your prompt below. Any form of text or
                                                    information that communicates to AI what results you're looking for.
                                                    Adjusting how you phrase your prompt, AI could provide varying
                                                    responses.</label>
                                                <textarea name="prompt" id="promptInput1" rows="5" class="form-control cfi"
                                                    placeholder="e.g. beautiful house design and materials"></textarea>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Select Style</label>
                                                <select class="nwfiles-optns" id="promptInputDesign1">
                                                    @include('web.designs_options.exterior_style')
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">House Angle <span class="tooltipnew"
                                                        data-tooltip="Choose the angle of the
                                                                                house that you want to redesign. If your image is from
                                                                                the front of the house, choose accordingly.

                                                                                If the results are not good enough you can switch between
                                                                                the 3 options: front, side, back of the house.">?</span></label>
                                                <select class="nwfiles-optns" id="promptInputRoomType1">
                                                    @include('web.designs_options.exterior_house_angle')
                                                </select>

                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Number of designs </label>
                                                <select class="nwfiles-optns" id="no_of_design1">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <button type="button"
                                                    class="ci-btn ci-btn-primary painting_generating_bt"
                                                    id="generateDesignBtn1" onclick="_generateInPaintingDesign(1,this)">
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
                        <div class="tab-pane fade" id="pills-garden" role="tabpanel" aria-labelledby="pills-garden-tab">
                            <div class="nwfrm-contentouter" id="forminterior2">
                                <div class="mt-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex flex-column ip-options-container inpaintContainer">
                                            <div class="form-group">
                                                <label class="nwfile-tiTle">Add your prompt below. Any form of text or
                                                    information that communicates to AI what results you're looking for.
                                                    Adjusting how you phrase your prompt, AI could provide varying
                                                    responses.</label>
                                                <textarea name="prompt" id="promptInput2" rows="5" class="form-control cfi"
                                                    placeholder="e.g. Grey outdoor furniture, garden furniture,  beautiful, high quality, photographyhite colors"></textarea>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Select Style</label>
                                                <select class="nwfiles-optns" id="promptInputDesign2">
                                                    @include('web.designs_options.garden_styles')
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Garden Type <span class="tooltipnew"
                                                        data-tooltip="Choose which type of
                                                                                outdoor you have uploaded. For best results switch
                                                                                between the options to get the best results.">?</span></label>
                                                <select class="nwfiles-optns" id="promptInputRoomType2">
                                                    @include('web.designs_options.garden_types')
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Number of designs </label>
                                                <select class="nwfiles-optns" id="no_of_design2">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <button type="button"
                                                    class="ci-btn ci-btn-primary painting_generating_bt"
                                                    id="generateDesignBtn2" onclick="_generateInPaintingDesign(2,this)">
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
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <p class="inpaint_message"
                                style="padding: 30px; color: #dfdfdf; font-weight: 500; border-radius: 10px; margin: 20px 0px 20px 0px; background: rgb(0,0,0); background: linear-gradient(66deg, rgb(21 13 46) 21%, rgba(18,12,38,1) 61%); border-top: 4px solid #7558ea; min-height: 220px;">
                                With Precision+ you can now select only the area that you want to change. Want to
                                redesign a couch or add wall paintings? With Precision+, it's a breeze. </p>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <p class="inpaint_message"
                                style="padding: 30px; color: #dfdfdf; font-weight: 500; border-radius: 10px; margin: 20px 0px 20px 0px; background: rgb(0,0,0); background: linear-gradient(66deg, rgb(21 13 46) 21%, rgba(18,12,38,1) 61%); border-top: 4px solid #7558ea; min-height: 220px;">
                                <strong>Simply use the brush tool to highlight the area you want to change</strong>,
                                provide instructions to the AI, and select your preferred style. Precision+ gives you
                                the freedom to modify any element within your image. See the magic happen!
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <p class="inpaint_message"
                                style="padding: 30px; color: #dfdfdf; font-weight: 500; border-radius: 10px; margin: 20px 0px 20px 0px; background: rgb(0,0,0); background: linear-gradient(66deg, rgb(21 13 46) 21%, rgba(18,12,38,1) 61%); border-top: 4px solid #7558ea; min-height: 220px;">
                                <strong>The source images you use have a huge impact on the quality of the outputs.</strong>
                                The selection of the image (with the brush tool) is also very important for good results.
                                Use the prompt box below to communicate the changes you want our AI to make in the selected
                                area.


                            </p>
                        </div>
                        <div class="col-md-3 col-sm-3">
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
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-3">
                                <div>
                                    <img class="uploadInPaintingImage" src="" id="imgCropPreview">
                                </div>
                            </div>
                            <div class="modal-footer pt-0 border-0 modal_footer_part">
                                <label>
                                    <div class="main">
                                        <input type="checkbox" value="" id="myDecorCheckbox"
                                            class="check_for_crop">
                                        <span class="geekmark"></span>
                                        <span class="span_strong">Preserve Aspect Ratio</span>
                                    </div>
                                    <span><b>For optimal results, we recommend using square images.</b> However, if you prefer to maintain the original aspect ratio of your image, simply check the box on the left. Please note that while this option preserves the original image shape, the results may not be as refined as with square images. <br>
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
                                    <a class="sharetab sharetab-buttons download" href="javascript:void(0)" target="_blank"
                                        data-item="download-btn" title="Download">
                                        <img class="hover_img" src="/web/images/download1-hover.svg">
                                        <span>Download</span>

                                    </a>
                                    <div class="sharetab sharetab-buttons share text-center ip_img_preview inpainting-preview"
                                        data-img="" data-item="preview-btn" title="Open">
                                        <img src="/web/images/magnifying1.svg">
                                        <span>Show</span>

                                    </div>
                                    <div class="sharetab sharetab-buttons full_hd_quality share text-center" data-img=""
                                        data-item="hd_quality" title="Full Hd Quality">
                                        <img src="/web/images/hd1.svg">
                                        <span>HD</span>
                                    </div>
                                    <a class="sharetab sharetab-buttons use-as-input-image" data-img=""
                                        data-item="user_as_input" title="Use as Input">
                                        <img src="/web/images/input1.svg" alt="" loading="lazy">
                                        <span>Input</span>
                                    </a>
                                    {{-- <div class="chkimg imgcheck">
                                        <input type="checkbox" class="ml_dw_img" onclick="getMultipleImages('{{ $value->generated_image }}')"/>
                                    </div> --}}
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
                {{-- video pop up model --}}
                <div class="modal fade pdfmodel-popup" id="pdfModal" tabindex="-1" role="dialog"
                    aria-labelledby="pdfModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="pdf-icon fullscreen-icon" id="toggleFullscreen">Toggle Fullscreen</button>
                                <button type="button" class="pdf-icon btn" id="customCloseButton">Close</button>
                            </div>
                            <div class="pdf_body">
                                <div id="pdfContainer" class="pdf-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            <script>
                async function loadRenders(sec) {

                    this.multipleDownloadImg = [];
                    $(`.delete_button`).addClass('hidden');

                    get_designs.design_type = sec;

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
                    loadRenders(0);

                    $("#pdfModal").modal("hide");

                    $('#toggleFullscreen').on('click', function() {
                        const pdfModal = $('#pdfModal')[0];
                        if (!document.fullscreenElement) {
                            pdfModal.requestFullscreen();
                        } else {
                            if (document.exitFullscreen) {
                                document.exitFullscreen();
                            }
                        }
                    });

                    $('#customCloseButton').click(function() {
                        if (document.fullscreenElement) {
                            document.exitFullscreen();
                        }
                        $('#pdfModal').modal('hide');
                        $('.pdf-container').empty();
                        $('.pdf-container').removeClass('pdfVideoModal');
                        $('.modal-header').show();
                    });
                });

                function loadVideoModal() {
                    if (window.innerWidth < 768) {
                        // Set a different width for mobile view
                        $('.pdf-container').html(
                            '<iframe width="auto" height="180" src="https://www.youtube.com/embed/IMCUjuW_Rhk?si=q_Y3tzzQ1-11ZZAZ" frameborder="0" allowfullscreen></iframe>'
                        );
                    } else {
                        // Use the default width for other screen sizes
                        $('.pdf-container').html(
                            '<iframe width="560" height="315" src="https://www.youtube.com/embed/IMCUjuW_Rhk?si=q_Y3tzzQ1-11ZZAZ" frameborder="0" allowfullscreen></iframe>'
                        );
                    }
                    $("#pdfModal").modal("show");
                }
            </script>
        @endsection
