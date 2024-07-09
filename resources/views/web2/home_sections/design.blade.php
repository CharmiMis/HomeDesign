<?php
$userActivePlan = '';
$crossShellPlan = [];
$default_gallery = 'public';
$precisionUser = false;
$premiumPlan = '';

if (auth()->check()) {
    $userActivePlan = auth()->user()->activePlan();
    $crossShellPlan = auth()->user()->crossShellPlan();
    $userFreeTrialPlan = auth()->user()->freeTrialPlan();
    $premiumPlan = auth()->user()->is_premium_plan;
    $api_user = auth()->user()->is_api_user;
    $default_gallery = auth()->user()->total_designs == 0 ? 'public' : 'private';
    $createdAtDate = new DateTime(auth()->user()->created_at);
    $comparisonDate = new DateTime('2023-08-05');
    if ($createdAtDate >= $comparisonDate) {
        if ($premiumPlan == 1 || $userActivePlan == 'premium-precision-upgrade-plus-ds' || ($userActivePlan == 'homedesignsai-pro-7-days-trial-yearly-new' && $userFreeTrialPlan == 1) || ($userActivePlan == 'homedesignsai-pro-7-days-trial' && $userFreeTrialPlan == 1) || ($userActivePlan == 'homedesignsai-pro-7-days-trial-yearly-facebook' && $userFreeTrialPlan == 1) || ($userActivePlan == 'homedesignsai-pro-7-days-trial-facebook' && $userFreeTrialPlan == 1)) {
            $precisionUser = false;
        } else {
            $precisionUser = true;
        }
    } else {
        $precisionUser = false;
    }
}
?>
<section id="generate" class="ips-dgsec">
    <div class="nw-formouter">
        <div class="nw-forminner">
            <div class="container">
                <div class="row">
                    <h2 class="cmn-title1"><strong> Select AI Interiors, AI Exteriors or AI Gardens below:</strong></h2>
                    <div class="nwfrm-tabs">
                        <ul class="nav nav-pills" id="ai-category-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nwai-tab active" id="pills-interior-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-interior" type="button" role="tab"
                                    aria-controls="pills-interior" aria-selected="true" onclick="loadRenders(0)">
                                    <img class="ai-icon" src="{{ asset('web/images') }}/interior-icon.svg"
                                        alt="" loading="lazy">
                                    <span class="nwtb-title">Interiors</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nwai-tab" id="pills-exterior-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-exterior" type="button" role="tab"
                                    aria-controls="pills-exterior" aria-selected="false" onclick="loadRenders(1)">
                                    <img class="ai-icon" src="{{ asset('web/images/') }}/exterior-icon.svg"
                                        alt="" loading="lazy">
                                    <span class="nwtb-title">Exteriors</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nwai-tab" id="pills-garden-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-garden" type="button" role="tab"
                                    aria-controls="pills-garden" aria-selected="false" onclick="loadRenders(2)">
                                    <img class="ai-icon" src="{{ asset('web/images/') }}/garden-icon.svg" alt=""
                                        loading="lazy">
                                    <span class="nwtb-title">Gardens</span>
                                </button>
                            </li>
                        </ul>
                        <!--   <div class="loader_div" id="loaddividmobile">
                            <img src="{{ asset('web/images/') }}/logoanm2.gif" class="loader-img">
                        </div> -->
                    </div>
                    <!-- Assuming $precisionUser is a boolean variable -->
                    <input type="hidden" id="precisionUser" value="{{ $precisionUser ? 'true' : 'false' }}">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-interior" role="tabpanel"
                            aria-labelledby="pills-interior-tab">
                            <div class="nwfrm-contentouter" id="forminterior0">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-6 col-md-6 order-mobile-top">
                                        <div class="nwfrm-comaparison">
                                            <h5 class="nwfrm-heading" id="jumphere0">Latest Designs</h5>
                                            <div class="dlt-btn-main">
                                                <button class="btn btn-success add_to_project_btn hidden">Add To
                                                    Project</button>
                                                <button class="btn btn-danger delete_button hidden"
                                                    onclick="deleteMultipleImages()">Delete</button>
                                            </div>
                                            <div class="cstmauto-scroll user_gallery_container" id="all_data0"
                                                data-sec-id="0">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 order-mobile-btm">
                                        <div class="nwfile-uploadside">
                                            <form>
                                                <input type="hidden" name="image_type">
                                                <input type="hidden" name="image">
                                                {{-- <div class="ribon-bx">
                                                    <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png"
                                                        alt="" loading="lazy">
                                                    <div class="ribon-overlay">
                                                        <img class="nwstepimg"
                                                            src="{{ asset('web/images/') }}/fillvector.svg"
                                                            alt="" loading="lazy">
                                                        <span class="ribon-text"><strong>Step 1:</strong>
                                                            Upload Image
                                                        </span>
                                                    </div>
                                                </div> --}}
                                                <div class="step_1_video">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png"
                                                            alt="" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/fillvector.svg"
                                                                loading="lazy">
                                                            <span class="ribon-text"><strong>Step 1:</strong>
                                                                Upload Image
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!--  <a class="redesign_video" onclick="loadVideoModal()">
                                                        <img src="{{ asset('web/images/play-button.png') }}"
                                                            width="20px" alt=""> Video
                                                        Tutorial</a> -->
                                                </div>

                                                <div class="nwupload-bx img-upload-outer" id="file-sectionbx0"
                                                    data-section="0">
                                                    <input class="select-file dimg-picker" type="file"
                                                        id="fileselect0" style="display:none;" data-section="0">
                                                    <div class="fileselect-area">
                                                        <img src="{{ asset('web/images/') }}/fileselect.svg"
                                                            id="uploadText0" alt="" loading="lazy">
                                                        <label for="fileselect" class="drop-cont0" id="uploadText0">
                                                            Drop an image, tap , take a photo, or CTRL + V
                                                        </label>
                                                        <div id="gallery0">
                                                            <img id="im">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="nwchoose-options">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/upload-vector.svg"
                                                                loading="lazy">
                                                            <span class="ribon-text"><strong>Step 2:</strong>
                                                                Customize
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Room Type<span
                                                                        class="tooltipnew"
                                                                        data-tooltip="Choose the type of room
                                                                                layout you uploaded. If you are uploading an image with a
                                                                                living room, choose living room. If you want to transform
                                                                                that living room to kitchen, choose kitchen.">?</span></label>
                                                                <select class="nwfiles-optns" id="roomType0">
                                                                    @include('web.designs_options.interior_room_type')
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- file selection row -->
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Mode <span
                                                                        class="tooltipnew"
                                                                        data-tooltip="As our AI models continue to improve, we’ve consolidated our full redesign mode into two major rendering modes: Beautiful Redesign and Creative Redesign.

																These modes lock and reimagine structural elements or allow the AI more creative freedom, respectively.">?</span></label>
                                                                <select class="nwfiles-optns" id="modeType0"
                                                                    onchange="changeMode(0)">
                                                                    @include('web.designs_options.interior_mode_type')
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Design Style</label>
                                                                <select class="nwfiles-optns" id="styleType0">
                                                                    @include('web.designs_options.interior_design_style')
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Number of designs</label>
                                                                <select class="nwfiles-optns" id="no_of_design0">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">AI Intervention
                                                                    <span class="tooltipnew"
                                                                        data-tooltip="Control the number of
                                                                                changes you want the AI to make to your upload. For the
                                                                                best results, leave this option to MEDIUM.

                                                                                You can try with LOW and EXTREME if you don't get good
                                                                                results with MEDIUM.">?</span></label>
                                                                {{-- <select class="nwfiles-optns" id="strength0">
                                                                    @include('web.designs_options.interior_ai')
                                                                </select> --}}
                                                                <br>
                                                                <div class="slider-container">
                                                                    <input type="range" min="25"
                                                                        max="100" step="25" value="75"
                                                                        class="form-range in-range slider strength"
                                                                        id="rangeInput0">
                                                                    <label class="slider-tag"><span>Very
                                                                            Low</span><span>Low</span><span>Medium</span><span>Extreme</span></label>
                                                                    <input type="hidden" value=""
                                                                        class="hidden-input" id="strength0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div>
                                                        @if ($userActivePlan == 'free')
                                                        <label class="nw-tgtype ips-bf-parent"> Full HD Quality?
                                                            <input type="checkbox" class="hfq-ck" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                        @else
                                                        <label class="nw-tgtype"> Full HD Quality?
                                                            <input type="checkbox" name="full_hd_0" class="hfq-ck" id="ck_full_hd_0" value="1">
                                                        </label>
                                                        @endif
                                                    </div> --}}
                                                    @if ($precisionUser == true && !$api_user)
                                                        <label class="nw-tgtype ips-bf-parent">
                                                            Custom AI Instructions
                                                            <span class="tooltipnew"
                                                                data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                            <input type="checkbox" id="nwcust0"
                                                                class="ms-1 ck_inst" onchange="customInstruction(0)"
                                                                disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    @else
                                                        {{-- @if (in_array($userActivePlan, ['free', 'individual', 'homedesignsai-individual', 'individual-lifetime', 'individual-yearly']))
                                                            <label class="nw-tgtype ips-bf-parent">
                                                                Custom AI Instructions
                                                                <span class="tooltipnew"
                                                                    data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                                <input type="checkbox" id="nwcust0"
                                                                    class="ms-1 ck_inst"
                                                                    onchange="customInstruction(0)" disabled>
                                                                <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                                <div class="ips-bf-child paid_feature_modal"></div>
                                                            </label>
                                                        @else --}}
                                                        <div class="mt-3">
                                                            <label class="nw-tgtype">
                                                                Custom AI Instructions
                                                                <span class="tooltipnew"
                                                                    data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                                <input type="checkbox" id="nwcust0"
                                                                    class="ms-1 ck_inst"
                                                                    onchange="customInstruction(0)">
                                                            </label>
                                                        </div>
                                                        {{-- @endif --}}
                                                    @endif
                                                    <div class="nwchoice-custom-instruction mt-2">
                                                        <textarea id="custom_instruction0" class="hidden_cust_field form-control" type="text"
                                                            placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood."
                                                            name="cust-inst0" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="nwupload-b0x">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png"
                                                            loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/generatevector.svg"
                                                                loading="lazy">
                                                            <span class="ribon-text"><strong>Step 3:</strong>
                                                                Generate</span>
                                                        </div>
                                                    </div>
                                                    <div class="nwchoice-toggle" style="margin-top: 15px !important">
                                                        <span class="nw-tgtype">Private Gallery </span>
                                                        <input type="checkbox" id="nwtoggle0"
                                                            onchange="loadRenders(0)" @checked($default_gallery == 'public')>
                                                        <label class="nwtoggle-label0" for="nwtoggle0">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- <button class="nwfrm-submit _btn_gndeisgn" onclick="_generateDesign(0,this)">Generate New
                                                Design</button> --}}
                                            @if (auth()->check())
                                                <button class="nwfrm-submit _btn_gndeisgn"
                                                    onclick="_generateDesign(0, this)">Generate New Design</button>
                                            @else
                                                {{-- <a href="#buy"><button
                                                            class="nwfrm-submit _btn_gndeisgn">Generate New
                                                            Design</button></a> --}}
                                                @if (strpos(request()->url(), 'founders-special') !== false || strpos(request()->url(), 'founders-offer') !== false)
                                                    <a href="#buy"><button
                                                            class="nwfrm-submit _btn_gndeisgn">Generate New
                                                            Design</button></a>
                                                @else
                                                    <button class="nwfrm-submit _btn_gndeisgn"
                                                        onclick="showLoginModal()">Generate New Design</button>
                                                @endif
                                            @endif
                                            <!-- <p
                                                style="font-size:12px;color:#fff;text-align:center;padding-top:15px;margin:auto;font-weight:500;">
                                                Free
                                                Plan Has 3 Free Generations / Every Day. <a href="#buy"
                                                    style="color:#51b7ff; font-style: italic; text-decoration:
                                                            underline;font-weight:500;">Need
                                                    more?</a></p> -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-exterior" role="tabpanel"
                            aria-labelledby="pills-exterior-tab">
                            <div class="nwfrm-contentouter" id="forminterior1">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-6 col-md-6 order-mobile-top">
                                        <div class="nwfrm-comaparison">
                                            <h5 class="nwfrm-heading" id="jumphere1">Latest Designs</h5>
                                            <div class="dlt-btn-main">
                                                <button class="btn btn-success add_to_project_btn hidden">Add To
                                                    Project</button>
                                                <button class="btn btn-danger delete_button hidden"
                                                    onclick="deleteMultipleImages()">Delete</button>
                                            </div>
                                            <div class="cstmauto-scroll user_gallery_container" id="all_data1"
                                                data-sec-id="1">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 order-mobile-btm">
                                        <div class="nwfile-uploadside">
                                            <form>
                                                <input type="hidden" name="image_type">
                                                <input type="hidden" name="image">
                                                <div class="step_1_video">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png" alt=""
                                                            loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/fillvector.svg"
                                                                loading="lazy">
                                                            <span class="ribon-text"><strong>Step 1:</strong>
                                                                Upload Image
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!--  <a class="redesign_video" onclick="loadVideoModal()"><img
                                                            src="{{ asset('web/images/play-button.png') }}"
                                                            width="20px" alt=""> Video
                                                        Tutorial</a> -->
                                                </div>

                                                <div class="nwupload-bx img-upload-outer" id="file-sectionbx1"
                                                    data-section="1">
                                                    <input class="select-file dimg-picker" type="file"
                                                        id="fileselect1" style="display:none;" data-section="1">
                                                    <div class="fileselect-area">
                                                        <img src="{{ asset('web/images/') }}/fileselect.svg"
                                                            id="uploadText1" alt="" loading="lazy">
                                                        <label for="fileselect" class="drop-cont1" id="uploadText1">
                                                            Drop an image, tap , take a photo, or CTRL + V
                                                        </label>
                                                        <div id="gallery1">
                                                            <img id="im">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="nwchoose-options">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png"
                                                            loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/upload-vector.svg"
                                                                loading="lazy">
                                                            <span class="ribon-text">
                                                                <strong>Step 2:</strong>
                                                                Customize
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">House Angle <span
                                                                        class="tooltipnew"
                                                                        data-tooltip="Choose the angle of the
                                                                                house that you want to redesign. If your image is from
                                                                                the front of the house, choose accordingly.

                                                                                If the results are not good enough you can switch between
                                                                                the 3 options: front, side, back of the house.">?</span></label>
                                                                <select class="nwfiles-optns" id="roomType1">
                                                                    @include('web.designs_options.exterior_house_angle')
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- file selection row -->
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Mode</label>
                                                                <select class="nwfiles-optns" id="modeType1"
                                                                    onchange="changeMode(1)">
                                                                    @include('web.designs_options.exterior_modes')
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Style</label>
                                                                <select class="nwfiles-optns" id="styleType1">
                                                                    @include('web.designs_options.exterior_style')
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Number of designs</label>
                                                                <select class="nwfiles-optns" id="no_of_design1">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">AI Intervention
                                                                    <span class="tooltipnew"
                                                                        data-tooltip="Control the number of
                                                                                changes you want the AI to make to your upload. For the
                                                                                best results, leave this option to MEDIUM.

                                                                                You can try with LOW and EXTREME if you don't get good
                                                                                results with MEDIUM.">?</span></label>
                                                                {{-- <select class="nwfiles-optns" id="strength1">
                                                                    @include('web.designs_options.exterior_ai')
                                                                </select> --}}
                                                                <br>
                                                                <div class="slider-container">
                                                                    <input type="range" min="25"
                                                                        max="100" step="25" value="75"
                                                                        class="form-range in-range slider strength"
                                                                        id="rangeInput1">
                                                                    <label class="slider-tag"><span>Very
                                                                            Low</span><span>Low</span><span>Medium</span><span>Extreme</span></label>
                                                                    <input type="hidden" value=""
                                                                        class="hidden-input" id="strength1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div>
                                                        @if ($userActivePlan == 'free')
                                                        <label class="nw-tgtype ips-bf-parent"> Full HD Quality?
                                                            <input type="checkbox" class="hfq-ck" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                        @else
                                                        <label class="nw-tgtype"> Full HD Quality?
                                                            <input type="checkbox" name="full_hd_1" class="hfq-ck" id="ck_full_hd_1" value="1">
                                                        </label>
                                                        @endif
                                                    </div> --}}
                                                    @if ($precisionUser == true && !$api_user)
                                                        <label class="nw-tgtype ips-bf-parent">
                                                            Custom AI Instructions
                                                            <span class="tooltipnew"
                                                                data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                            <input type="checkbox" id="nwcust1"
                                                                class="ms-1 ck_inst" onchange="customInstruction(1)"
                                                                disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    @else
                                                        {{-- @if (in_array($userActivePlan, ['free', 'individual', 'homedesignsai-individual', 'individual-lifetime', 'individual-yearly']))
                                                            <label class="nw-tgtype ips-bf-parent">
                                                                Custom AI Instructions
                                                                <span class="tooltipnew"
                                                                    data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                                <input type="checkbox" id="nwcust1"
                                                                    class="ms-1 ck_inst"
                                                                    onchange="customInstruction(1)" disabled>
                                                                <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                                <div class="ips-bf-child paid_feature_modal"></div>
                                                            </label>
                                                        @else --}}
                                                        <div class="mt-3">
                                                            <label class="nw-tgtype">
                                                                Custom AI Instructions
                                                                <span class="tooltipnew"
                                                                    data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                                <input type="checkbox" id="nwcust1"
                                                                    class="ms-1 ck_inst"
                                                                    onchange="customInstruction(1)">
                                                            </label>
                                                        </div>
                                                        {{-- @endif --}}
                                                    @endif
                                                    <div class="nwchoice-custom-instruction mt-2">
                                                        <textarea id="custom_instruction1" class="hidden_cust_field form-control" type="text"
                                                            placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood."
                                                            name="cust-inst1" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="nwupload-b0x">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png" alt=""
                                                            loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/generatevector.svg"
                                                                alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 3:</strong>
                                                                Generate</span>
                                                        </div>
                                                    </div>
                                                    <div class="nwchoice-toggle" style="margin-top: 15px !important">
                                                        <span class="nw-tgtype">Private Gallery</span>
                                                        <input type="checkbox" id="nwtoggle1"
                                                            onchange="loadRenders(1)" @checked($default_gallery == 'public')>
                                                        <label class="nwtoggle-label1" for="nwtoggle1">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- <button class="nwfrm-submit _btn_gndeisgn"
                                                onclick="_generateDesign(1,this)">Generate New
                                                Design</button> --}}
                                            @if (auth()->check())
                                                <button class="nwfrm-submit _btn_gndeisgn"
                                                    onclick="_generateDesign(1,this)">Generate New
                                                    Design</button>
                                            @else
                                                @if (strpos(request()->url(), 'founders-special') !== false || strpos(request()->url(), 'founders-offer') !== false)
                                                    <a href="#buy"><button
                                                            class="nwfrm-submit _btn_gndeisgn">Generate New
                                                            Design</button></a>
                                                @else
                                                    <button class="nwfrm-submit _btn_gndeisgn"
                                                        onclick="showLoginModal()">Generate New Design</button>
                                                @endif
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-garden" role="tabpanel"
                            aria-labelledby="pills-garden-tab">
                            <div class="nwfrm-contentouter" id="forminterior2">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-6 col-md-6 order-mobile-top">
                                        <div class="nwfrm-comaparison">
                                            <h5 class="nwfrm-heading" id="jumphere2">Latest Designs</h5>
                                            <div class="dlt-btn-main">
                                                <button class="btn btn-success add_to_project_btn hidden">Add To
                                                    Project</button>
                                                <button class="btn btn-danger delete_button hidden"
                                                    onclick="deleteMultipleImages()">Delete</button>
                                            </div>
                                            <div class="cstmauto-scroll user_gallery_container" id="all_data2"
                                                data-sec-id="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 order-mobile-btm">
                                        <div class="nwfile-uploadside">
                                            <form>
                                                <input type="hidden" name="image_type">
                                                <input type="hidden" name="image">
                                                {{-- <div class="ribon-bx">
                                                    <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png"
                                                        loading="lazy">
                                                    <div class="ribon-overlay">
                                                        <img class="nwstepimg"
                                                            src="{{ asset('web/images/') }}/fillvector.svg"
                                                            loading="lazy">
                                                        <span class="ribon-text"><strong>Step 1:</strong>
                                                            Upload Image
                                                        </span>
                                                    </div>
                                                </div> --}}
                                                <div class="step_1_video">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png" alt=""
                                                            loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/fillvector.svg"
                                                                loading="lazy">
                                                            <span class="ribon-text"><strong>Step 1:</strong>
                                                                Upload Image
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- <a class="redesign_video" onclick="loadVideoModal()"><img
                                                            src="{{ asset('web/images/play-button.png') }}"
                                                            width="20px" alt=""> Video
                                                        Tutorial</a> -->
                                                </div>

                                                <div class="nwupload-bx img-upload-outer" id="file-sectionbx2"
                                                    data-section="2">
                                                    <input class="select-file dimg-picker" type="file"
                                                        id="fileselect2" style="display:none;" data-section="2">
                                                    <div class="fileselect-area">
                                                        <img src="{{ asset('web/images/') }}/fileselect.svg"
                                                            id="uploadText2" loading="lazy">
                                                        <label for="fileselect" class="drop-cont2" id="uploadText2">
                                                            Drop an image, tap , take a photo, or CTRL + V
                                                        </label>
                                                        <div id="gallery2">
                                                            <img id="im">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="nwchoose-options">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png"
                                                            loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/upload-vector.svg"
                                                                loading="lazy">
                                                            <span class="ribon-text"><strong>Step 2:</strong>
                                                                Customize
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Garden Type <span
                                                                        class="tooltipnew"
                                                                        data-tooltip="Choose which type of
                                                                                outdoor you have uploaded. For best results switch
                                                                                between the options to get the best results.">?</span></label>
                                                                <select class="nwfiles-optns" id="roomType2">
                                                                    @include('web.designs_options.garden_types')
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- file selection row -->
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Mode</label>
                                                                <select class="nwfiles-optns" id="modeType2"
                                                                    onchange="changeMode(2)">
                                                                    @include('web.designs_options.garden_mode')
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Style</label>
                                                                <select class="nwfiles-optns" id="styleType2">
                                                                    @include('web.designs_options.garden_styles')
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Number of designs </label>
                                                                <select class="nwfiles-optns" id="no_of_design2">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">AI Intervention
                                                                    <span class="tooltipnew"
                                                                        data-tooltip="Control the number of
                                                                                changes you want the AI to make to your upload. For the
                                                                                best results, leave this option to MEDIUM.

                                                                                You can try with LOW and EXTREME if you don't get good
                                                                                results with MEDIUM.">?</span></label>
                                                                {{-- <select class="nwfiles-optns" id="strength2">
                                                                    @include('web.designs_options.garden_ai')
                                                                </select> --}}
                                                                <br>
                                                                <div class="slider-container">
                                                                    <input type="range" min="25"
                                                                        max="100" step="25" value="75"
                                                                        class="form-range in-range slider strength"
                                                                        id="rangeInput2">
                                                                    <label class="slider-tag"><span>Very
                                                                            Low</span><span>Low</span><span>Medium</span><span>Extreme</span></label>
                                                                    <input type="hidden" value=""
                                                                        class="hidden-input" id="strength2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div>
                                                        @if ($userActivePlan == 'free')
                                                        <label class="nw-tgtype ips-bf-parent"> Full HD Quality?
                                                            <input type="checkbox" class="hfq-ck" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                        @else
                                                        <label class="nw-tgtype"> Full HD Quality?
                                                            <input type="checkbox" name="full_hd_2" class="hfq-ck" id="ck_full_hd_2" value="1">
                                                        </label>
                                                        @endif
                                                    </div> --}}
                                                    @if ($precisionUser == true && !$api_user)
                                                        <label class="nw-tgtype ips-bf-parent">
                                                            Custom AI Instructions
                                                            <span class="tooltipnew"
                                                                data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                            <input type="checkbox" id="nwcust2"
                                                                class="ms-1 ck_inst" onchange="customInstruction(2)"
                                                                disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    @else
                                                        {{-- @if (in_array($userActivePlan, ['free', 'individual', 'homedesignsai-individual', 'individual-lifetime', 'individual-yearly']))
                                                            <label class="nw-tgtype ips-bf-parent">
                                                                Custom AI Instructions
                                                                <span class="tooltipnew"
                                                                    data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                                <input type="checkbox" id="nwcust2"
                                                                    class="ms-1 ck_inst"
                                                                    onchange="customInstruction(2)" disabled>
                                                                <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                                <div class="ips-bf-child paid_feature_modal"></div>
                                                            </label>
                                                        @else --}}
                                                        <div class="mt-3">
                                                            <label class="nw-tgtype">
                                                                Custom AI Instructions
                                                                <span class="tooltipnew"
                                                                    data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.
                                                            Note: This feature is still in BETA and results might be inconsistent.">?</span>
                                                                <input type="checkbox" id="nwcust2"
                                                                    class="ms-1 ck_inst"
                                                                    onchange="customInstruction(2)">
                                                            </label>
                                                        </div>
                                                        {{-- @endif --}}
                                                    @endif
                                                    <div class="nwchoice-custom-instruction mt-2">
                                                        <textarea id="custom_instruction2" class="hidden_cust_field form-control" type="text"
                                                            placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood."
                                                            name="cust-inst2" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="nwupload-b0x">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon"
                                                            src="{{ asset('web/images/') }}/ribon.png" alt=""
                                                            loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg"
                                                                src="{{ asset('web/images/') }}/generatevector.svg"
                                                                alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 3:</strong>
                                                                Generate</span>
                                                        </div>
                                                    </div>
                                                    <div class="nwchoice-toggle" style="margin-top: 15px !important">
                                                        <span class="nw-tgtype">Private Gallery</span>
                                                        <input type="checkbox" id="nwtoggle2"
                                                            onchange="loadRenders(2)" @checked($default_gallery == 'public')>
                                                        <label class="nwtoggle-label2" for="nwtoggle2">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- <button class="nwfrm-submit _btn_gndeisgn"
                                                onclick="_generateDesign(2,this)">Generate New
                                                Design</button> --}}
                                            @if (auth()->check())
                                                <button class="nwfrm-submit _btn_gndeisgn"
                                                    onclick="_generateDesign(2,this)">Generate New
                                                    Design</button>
                                            @else
                                                @if (strpos(request()->url(), 'founders-special') !== false || strpos(request()->url(), 'founders-offer') !== false)
                                                    <a href="#buy"><button
                                                            class="nwfrm-submit _btn_gndeisgn">Generate New
                                                            Design</button></a>
                                                @else
                                                    <button class="nwfrm-submit _btn_gndeisgn"
                                                        onclick="showLoginModal()">Generate New Design</button>
                                                @endif
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
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

    {{-- Image Feedback Modal --}}
    <div id="feedbackForm" class="modal feedback_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content hdc-modal">

                <div class="mdp-cl-btn mdl-close-btn">
                    <span class="precision_suggestion_closebt" data-bs-dismiss="modal">
                        <i class="fa fa-times fa-unset" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="head">
                    <h5 class="modal-title">Provide additional feedback</h5>
                </div>

                <div class="body">
                    <input type="hidden" name="sidebarmodule" value="" id="sidebarmodule" />
                    <input type="hidden" name="module_category" value="" id="module_category" />

                    <input type="hidden" id="feedback_image" name="feedback_image" value="" />
                    <input type="hidden" id="gallery_id" name="gallery_id" value="" />
                    <textarea id="feedback_description" name="feedback"
                        placeholder="The more details you give us, the better. Tell us what's wrong with this result.."></textarea>
                </div>

                <div id="full-stars-example-two" class="rating_star_main">
                    <span class="rating_title text-center">Rate this image from 0 to 5 stars</span>
                    <div class="rating-group">
                        <input disabled checked class="rating__input rating__input--none" name="rating3"
                            id="rating3-none" value="0" type="radio">
                        <label aria-label="1 star" class="rating__label" for="rating3-1"><i
                                class="rating__icon rating__icon--star fa fa-star"></i></label>
                        <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                        <label aria-label="2 stars" class="rating__label" for="rating3-2"><i
                                class="rating__icon rating__icon--star fa fa-star"></i></label>
                        <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                        <label aria-label="3 stars" class="rating__label" for="rating3-3"><i
                                class="rating__icon rating__icon--star fa fa-star"></i></label>
                        <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                        <label aria-label="4 stars" class="rating__label" for="rating3-4"><i
                                class="rating__icon rating__icon--star fa fa-star"></i></label>
                        <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                        <label aria-label="5 stars" class="rating__label" for="rating3-5"><i
                                class="rating__icon rating__icon--star fa fa-star"></i></label>
                        <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
                    </div>
                </div>
                <div class="modal_footer_content">
                    <button class="modal_footer_button" id="feedback_submit_button">Submit Feedback</button></a>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteRenderImages" class="hidden" data-route="{{ route('image.delete') }}"></div>
    <div id="routeToImageData" class="hidden" data-route="{{ route('getImage.data') }}">
        <div id="addImagesToProject" class="hidden" data-route="{{ route('user.add-images-to-project') }}"></div>
        <div id="routeToFullHdImageData" data-route="{{ route('getHdImages') }}"></div>
        <div id="editAsPrecision" data-route="{{ route('editAs.precision') }}"></div>
        @include('web.home_sections.modal_individual_limit')
</section>

@push('script-stack')
    <script src="{{ asset('web/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        let CurrentSection = 0;
        $('.user_gallery_container').scroll(function() {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 200) {
                var sec = $(this).data('sec-id');
                loadDesignsV2(sec);
            }
        });
    </script>
    <script>
        $(".hidden_cust_field").hide();
        const convertBase642 = (file) => {
            return new Promise((resolve, reject) => {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = () => {
                    resolve(fileReader.result);
                };
                fileReader.onerror = (error) => {
                    reject(error);
                };
            });
        };

        async function loadDesignsV2(sec, params) {

            var response = await getGeneratedDesigns('redesign');
            if (!response) {
                return;
            }
            var precisionUserValue = document.getElementById('precisionUser').value;
            if (response != null && response.data.designs.length) {
                $.each(response.data.designs, function(index, value) {
                    var design = {
                        original_url: value.original_image,
                        generated_url: value.generated_image,
                        style: value.style,
                        room_type: value.room_type,
                        mode: value.mode,
                        show_data: true,
                        section: sec,
                        precisionUserValue: precisionUserValue,
                        private: value.private,
                        favorite: value.favorite,
                        hd_image: value.hd_image
                    }
                    var code = createDesignItem(design);
                    const fragment = document.createElement('div');
                    fragment.innerHTML = code;
                    document.getElementById(`all_data${sec}`).appendChild(fragment);
                })
            }
        }

        function loadRenders(sec) {
            CurrentSection = sec;
            changeonfileinput();
            getFileCache(sec);
            const buttons = document.querySelectorAll('.nav-link.nwai-tab');
            buttons.forEach((button, index) => {
                button.disabled = true; // Disable all buttons
            });

            setTimeout(() => {
                buttons.forEach((button, index) => {
                    button.disabled = false; // Enable all buttons after a short delay
                });
            }, 500);
            document.getElementById(`all_data${sec}`).innerHTML = '';
            var isPrivate = document.getElementById(`nwtoggle${sec}`).checked;
            if (sec >= 0) {
                this.multipleDownloadImg = [];
                $(`.delete_button`).addClass('hidden');
                $(`.add_to_project_btn`).addClass('hidden');
            }
            if (user && isPrivate === false) {
                get_designs_config.page = 1;
                get_designs_config.type = 'private';
                get_designs_config.design_type = sec;
            } else {
                get_designs_config.page = 1;
                get_designs_config.type = 'public';
                get_designs_config.design_type = sec;
            }

            loadDesignsV2(sec);
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

            var dropdownValue = localStorage.getItem('dropdownValue');

            if (dropdownValue) {
                var dropdown = document.getElementById('modeType0');
                for (var i = 0; i < dropdown.options.length; i++) {
                    if (dropdown.options[i].value === dropdownValue) {
                        dropdown.options[i].selected = true;
                        localStorage.removeItem('dropdownValue'); // Remove the cached value
                        break;
                    }
                }
            }
        });

        function loadVideoModal() {
            if (window.innerWidth < 768) {
                // Set a different width for mobile view
                $('.pdf-container').html(
                    '<iframe width="auto" height="180" src="https://www.youtube.com/embed/I5PmQt6AQB0?si=9cT6ZzyWZ2_IiQ7I" frameborder="0" allowfullscreen></iframe>'
                );
            } else {
                // Use the default width for other screen sizes
                $('.pdf-container').html(
                    '<iframe width="560" height="315" src="https://www.youtube.com/embed/I5PmQt6AQB0?si=9cT6ZzyWZ2_IiQ7I" frameborder="0" allowfullscreen></iframe>'
                );
            }
            $("#pdfModal").modal("show");
        }
        function initializeSlider(container) {
            var rangeInput = container.querySelector('.slider');
            var hiddenInput = container.querySelector('.hidden-input');

            function updateAIInterventionInput() {
                var value = parseInt(rangeInput.value);

                if (value === 25) {
                    hiddenInput.value = 'very_low';
                } else if (value === 50) {
                    hiddenInput.value = 'low';
                } else if (value === 75) {
                    hiddenInput.value = 'mid';
                } else {
                    hiddenInput.value = 'extreme';
                }
            }

            updateAIInterventionInput();

            container.addEventListener('input', function(event) {
                if (event.target === rangeInput) {
                    updateAIInterventionInput();
                }
            });
        }

        // Update subproject dropdown options
        function updateSubprojectDropdown(subprojects) {
            var selectSubProject = $('#selectSubProject');
            selectSubProject.empty();

            if (subprojects.length > 0) {
                $('#subprojectGroup').show();
                selectSubProject.append($('<option>', {
                    value: '',
                    text: '-- Select Sub Project --',
                    disabled: true,
                    selected: true
                }));
                $.each(subprojects, function(index, subproject) {
                    selectSubProject.append($('<option>', {
                        value: subproject.id,
                        text: subproject.sub_project_name
                    }));
                });
            } else {
                $('#subprojectGroup').hide();
            }
        }

        // Fetch projects on page load
        $(document).ready(function() {
            // getFileCache(0);
            fetchProjects();

            // Event listener for project selection
            $('#selectProject').change(function() {
                var selectedProject = $(this).val();
                fetchSubprojects(selectedProject);
            });

            $("#addProjectForm").validate({
                rules: {
                    selectedProject: {
                        required: true
                    }
                },
                messages: {
                    selectedProject: {
                        required: "Please select a project."
                    },
                },
                errorElement: 'div',
                errorClass: 'text-danger',
            });
        });

        var sliderContainers = document.querySelectorAll('.slider-container');
        sliderContainers.forEach(function(container) {
            initializeSlider(container);
        });

        function generateRandomString(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        // Open or create an IndexedDB database
        var request = window.indexedDB.open('fileDatabase', 1);
        var db;
        var filekey;
        request.onupgradeneeded = function(event) {
            db = event.target.result;
            const objectStore = db.createObjectStore('files', { autoIncrement:false });
        };
        request.onerror = function(event) {
        console.error("Database error: " + event.target.errorCode);
        };

        request.onsuccess = function(event) {
            db = event.target.result;
            getFileCache(CurrentSection);
        };

        function getFileCache(loadRender = null){
            if(CurrentSection != null){
                if(db == undefined){
                    return false;
                }
                const transaction = db.transaction(['files'], 'readonly');
                const objectStore = transaction.objectStore('files');
                const request = objectStore.get('filekey'+loadRender);
                request.onsuccess = function(event) {
                    let files = event.target.result;
                    console.log(files);
                    if((files == undefined) || (files == null)){
                        return false;
                    }
                    let formData = new FormData();
                    formData.append('X-CSRF-TOKEN',"{{csrf_token()}}");
                    formData.append('file',files.id);
                    $.ajax({
                        url: "{{ route('home.storefileincache') }}",
                        method: 'POST',
                        headers: {
                            accept: 'application/json',
                            "X-CSRF-TOKEN": "{{csrf_token()}}"
                        },
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if(response.success){
                                $("input[name='image']").val("data:"+response.data.cachedstoredimageType+";base64,"+response.data.cachedstoredimage);
                                $("input[name='image_type']").val("blob");
                                $("#gallery"+CurrentSection).find('img').attr('src', "data:"+response.data.cachedstoredimageType+";base64,"+response.data.cachedstoredimage);
                                $(".drop-cont"+CurrentSection).css("visibility","hidden");
                                $("#uploadText"+CurrentSection).css('display',"none");
                                $("#gallery"+CurrentSection).css('display',"block");
                                // assume that user is refreshing the page within a five minutes and the storage will be remove after 5 minutes
                                setTimeout(() => { 
                                    const transaction = db.transaction(['files'], 'readwrite');
                                    const objectStore = transaction.objectStore('files');
                                    const request = objectStore.delete('filekey'+loadRender); 
                                }, 300000);
                            }
                        },
                        error: function(error) {
                            console.log(error)
                            console.error('Failed to fetch subprojects');
                        }
                    });
                };
            }
        }
        
        function changeonfileinput(){
            document.getElementById('fileselect'+CurrentSection).addEventListener('change', function(event){
                filekey = generateRandomString(30)+CurrentSection;
                localStorage.setItem('filekey'+CurrentSection, filekey);
                const selectedFile = event.target.files[0];

                ipsValidateImage(selectedFile, () => {
                    request = window.indexedDB.open('fileDatabase', 1);
                    
                    const transaction = db.transaction(['files'], 'readwrite');
                    const objectStore = transaction.objectStore('files');
                    const accessrequest = objectStore.put({id: selectedFile}, 'filekey'+CurrentSection);
                    
                    accessrequest.onsuccess = function(event) {
                        console.log('File stored in IndexedDB');
                        getFileCache(CurrentSection);
                    };
                }, (error) => {
                    
                });
            });
        }
    </script>
@endpush
