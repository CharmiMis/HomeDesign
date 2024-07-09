@extends('web2.layout.user-dash')

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tensorflow/4.15.0/tf.min.js"
        integrity="sha512-RMW1ZrsUb7zY5+dY2sH+dOD3aPXpgQgWysvpyj+UtMani44bvq6Nj4HQ0tB/gdbG0gJb1BhapgYvUPNve0A6kQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    <?php
    $userActivePlan = '';
    $crossShellPlan = [];
    $precisionUser = false;
    $default_gallery = 'private';
    ?>
    <input type="hidden" id="precisionUser" value="{{ $precisionUser ? 'true' : 'false' }}">
    <input type="hidden" class="data_page" data-page="redesign" />
    <input type="hidden" id="modeValueForPage" value="0" />
    <div class="ai-tool-wrapper">
        <div class="ai-tool-right">
            {{-- section first start --}}
            <div class="ai-tool-right-top top-menu-bar-first">
                <h3 class="font22">Redesign</h3>
                <ul>
                    <li class="active first_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Upload image</span>
                    </li>
                    <li class="second_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Select what to edit</span>
                    </li>
                    <li class="second_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Customise and Generate</span>
                    </li>
                </ul>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span>Log Out</span>
                    </a>
                </form>
            </div>
            <div class="gs-dashboard-notice upload-image-container">
                <div class="gs-dashboard-notice-info">
                    <img src="{{ asset('web2/images/info-icon.svg') }}">
                </div>
                <div class="gs-dashboard-notice-info-text">
                    <h2>Redesign Your Space Instantly!</h2>
                    <p>Ideal for quick makeovers, our Redesign Mode provides a streamlined, easy-to-use solution for achieving a fresh new look without the hassle. Choose from three dynamic sub-types—Creative Redesign, Beautiful Redesign, and Sketch-to-Render—to breathe new life into your house interiors, exteriors, gardens, or patios.</p>
                </div>
                <div class="gs-dashboard-cross">
                    <img src="{{ asset('web2/images/cross-icon.svg') }}">
                    <img class="light-mode" src="{{ asset('web2/images/light-mode/cross-icon.svg') }}">
                </div>
            </div>

            <div class="image-background-container upload-image-container">
                <div class="ai-upload-image">
                    <input type="file" class="ai-upload-input select-file dimg-picker" id="fileselect0" data-section="0">
                    <h3 class="font22">Upload your image </h3>
                    <img src="{{ asset('web2/images/gs-upload-img.png') }}">
                    <span>Drag and drop your image </span>
                    <a href="#">Or click here to upload</a>
                </div>
            </div>

            {{-- section first end --}}

            {{-- section second start --}}
            <div class="ai-tool-right-top top-menu-bar-second" id="viewImage" style="display: none">
                <div class="ai-tool-right-back-btn">
                    <a href="javascript:void(0)" class="gs-back-btn previous_page">
                        <img src="{{ asset('web2/images/back-btn-icon.svg') }}">
                        <img class="light-mode" src="{{ asset('web2/images/light-mode/back-btn-icon.svg') }}">
                    </a>
                    <h3 class="font22">Redesign</h3>
                </div>
                <ul>
                    <li class="active first_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Upload image</span>
                    </li>
                    <li class="active second_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Select what to edit</span>
                    </li>
                    <li class="active second_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Customise and Generate</span>
                    </li>
                </ul>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span>Log Out</span>
                    </a>
                </form>
            </div>

            <div class="image-show-container image-mask-container">
                <div class="gs-what-to-edit-wrapper">
                    <div class="gs-what-to-edit-left image-mask-container" style="display: none">
                        <input type="hidden" name="image_type" id="input_img_typ">
                        <input type="hidden" name="image" id="input_image">
                        <div class="gs-what-to-edit-leftimg" id="gallery0">
                            <img id="im">
                        </div>
                        <div class="gs-what-to-edit-tips">
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>Click on ‘Your Custom settings’ to give specific instructions to our AI.</p>
                                </div>
                            </div>
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>In Beautiful Redesign, our AI generates fast and beautiful results, but has less freedom to add or remove objects.</p>
                                </div>
                            </div>
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>Use Sketch-to-Render mode type to turn raw drawings into photorealistic renders.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gs-what-to-edit-right segment-masking-container" style="display: none">
                        <div class="gs-select-category">
                            <p class="font14">Select what you want to generate</p>
                            <div class="gs-select-category-list">
                                <ul class="gs-option-flex">
                                    <li class="active on-gen-disable">
                                        <a class="gs-select-category-list-inner" data-toggle="tab" href="#interior"
                                            onclick="loadRenders(0)">
                                            <img src="{{ asset('web2/images/gs-interior-icon.svg') }}">
                                            <span>Interior</span>
                                        </a>
                                    </li>
                                    <li class="on-gen-disable">
                                        <a class="gs-select-category-list-inner" data-toggle="tab" href="#exterior"
                                            onclick="loadRenders(1)">
                                            <img src="{{ asset('web2/images/gs-exterior-icon.svg') }}">
                                            <span>Exterior</span>
                                        </a>
                                    </li>
                                    <li class="on-gen-disable">
                                        <a class="gs-select-category-list-inner" data-toggle="tab" href="#garden"
                                            onclick="loadRenders(2)">
                                            <img src="{{ asset('web2/images/gs-garden-icon.svg') }}">
                                            <span>Garden</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div id="interior" class="tab-pane fade in active">
                                <div class="gs-what-to-edit-tabs">
                                    <div class="gs-what-to-edit-title">
                                        <ul>
                                            <li class="active"><a data-toggle="tab" href="#our-preset-settings-interior">Our
                                                    preset settings</a></li>
                                            <li><a data-toggle="tab" href="#your-customs-settings-interior">Your customs
                                                    settings </a></li>
                                        </ul>
                                    </div>
                                    <div class="gs-what-to-edit-content">
                                        <div class="tab-content">
                                            <div id="our-preset-settings-interior" class="tab-pane show fade in active">
                                                <div class="gs-select-automatically">
                                                    <div class="gs-our-preset-settings ">
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedRoomType0"
                                                                name="selectedRoomType0">
                                                            <p>1. Select Room Type <a href="javascript:void(0)"
                                                                    id="viewAllRoomTypes" data-toggle="modal"
                                                                    data-target="#view_all_interior_room_type">View All</a></p>
                                                            <div class="gs-select-room-style-row" id="roomTypeDisplay0">
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Living Room"
                                                                    onclick="selectRoomType('Living Room',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type1.png') }}">
                                                                    <span>Living Room</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Bedroom"
                                                                    onclick="selectRoomType('Bedroom',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type2.png') }}">
                                                                    <span>Bedroom</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Bathroom"
                                                                    onclick="selectRoomType('Bathroom',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type3.png') }}">
                                                                    <span>Bathroom</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Kitchen"
                                                                    onclick="selectRoomType('Kitchen',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type4.png') }}">
                                                                    <span>Kitchen</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedDesignStyle0"
                                                                name="selectedDesignStyle0">
                                                            <p>2. Select Design Style <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    data-target="#view_all_interior_choose_design">View All</a>
                                                            </p>
                                                            <div class="gs-select-room-style-row" id="designStyleDisplay0">
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Eclectic"
                                                                    onclick="selectDesignStyle('Eclectic',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type5.png') }}">
                                                                    <span>Eclectic</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Contemporary"
                                                                    onclick="selectDesignStyle('Contemporary',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type6.png') }}">
                                                                    <span>Contemporary</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Transitional"
                                                                    onclick="selectDesignStyle('Transitional',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type7.png') }}">
                                                                    <span>Transitional</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Scandinavian"
                                                                    onclick="selectDesignStyle('Scandinavian',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type8.png') }}">
                                                                    <span>Scandinavian</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedModeType0"
                                                                name="selectedModeType0">
                                                            <p>3. Select Mode Type</p>
                                                            <div class="gs-select-room-style-row" id="modeTypeDisplay0">
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Beautiful Redesign"
                                                                    onclick="selectModeType('Beautiful Redesign',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type10.png') }}">
                                                                    <span>Beautiful Redesign</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Creative Redesign"
                                                                    onclick="selectModeType('Creative Redesign',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type11.png') }}">
                                                                    <span>Creative Redesign</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Sketch to Render"
                                                                    onclick="selectModeType('Sketch to Render',0)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type11.png') }}">
                                                                    <span>Sketch to Render</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nwchoice-toggle" style="margin-top: 15px !important">
                                                        <span class="nw-tgtype">Private Gallery </span>
                                                        <input type="checkbox" id="nwtoggle0" onchange="loadRenders(0)"
                                                            @checked($default_gallery == 'public')>
                                                        <label class="nwtoggle-label0" for="nwtoggle0">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                    <div class="our-preset-settings-range-outer">
                                                        <input type="hidden" id="strength0" name="strength0"
                                                            value="mid" />
                                                        <div class="d-flex align-items-center">
                                                            <p class="font14">AI Intervention</p>
                                                            <div class="gs-tutorials-toolnip">
                                                                <img src="{{ asset('web2/images/tutorail-wraning.svg') }}" alt="">
                                                                <div class="ai-upload-option-tooltip">
                                                                    <span>Control the number of changes you want the AI to make to your upload. For the best results, leave this option to MEDIUM. You can try with LOW and EXTREME if you don't get good results with MEDIUM.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-design our-preset-range-design">
                                                            <div class="ai-intervention" data-sec="0">
                                                            </div>
                                                            <div class="our-preset-settings-range-list">
                                                                <ul>
                                                                    <li>Very Low</li>
                                                                    <li>Low</li>
                                                                    <li>Medium</li>
                                                                    <li>Extreme</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="our-preset-settings-range-outer">
                                                        <input type="hidden" id="no_of_des0" name="no_of_des0"
                                                            value="1" />
                                                        <p class="font14">Select the number of designs you want to generate at
                                                            once.</p>
                                                        <div class="gs-select-design our-preset-range-design">
                                                            <div class="our-preset-settings-range" data-sec="0">
                                                            </div>
                                                            <div class="our-preset-settings-range-list">
                                                                <ul>
                                                                    <li>1</li>
                                                                    <li>2</li>
                                                                    <li>3</li>
                                                                    <li>4</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gs-continue-btn-outer">
                                                        <a href="javascript:void(0)" onclick="_generateDesign(0, this)"
                                                            class="gs-continue-btn"><img
                                                                src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
                                                            Generate New Designs
                                                            <span id="submit" style="display:none">
                                                                <i class="fa fa-spinner fa-spin m-0" aria-hidden="true"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="your-customs-settings-interior" class="tab-pane show fade">
                                                <div class="our-preset-settings-box">
                                                    @if ($precisionUser == true)
                                                        <label class="our-preset-prompt-text ips-bf-parent">Type your custom instructions below and our AI will take them into account when generating your designs:
                                                            <input type="checkbox" id="nwcust0" class="ms-1 ck_inst" checked
                                                                onchange="customInstruction(0)" disabled>
                                                            &nbsp;&nbsp;&nbsp;<img
                                                                src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    @else
                                                        <label class="our-preset-prompt-text">Type your custom instructions below and our AI will take them into account when generating your designs:
                                                            <input type="checkbox" id="nwcust0" class="ms-1 ck_inst" checked
                                                                onchange="customInstruction(0)"></label>
                                                    @endif
                                                    <textarea
                                                        placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood."
                                                        name="cust-inst0" id="custom_instruction0" class="hidden"></textarea>
                                                </div>

                                                <div class="our-preset-settings-range-outer">
                                                    <div class="d-flex align-items-center">
                                                        <p class="font14">AI Intervention</p>
                                                        <div class="gs-tutorials-toolnip">
                                                            <img src="{{ asset('web2/images/tutorail-wraning.svg') }}" alt="">
                                                            <div class="ai-upload-option-tooltip">
                                                                <span>Control the number of changes you want the AI to make to your upload. For the best results, leave this option to MEDIUM. You can try with LOW and EXTREME if you don't get good results with MEDIUM.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gs-select-design our-preset-range-design">
                                                        <div class="ai-intervention" data-sec="0">
                                                        </div>
                                                        <div class="our-preset-settings-range-list">
                                                            <ul>
                                                                <li>Very Low</li>
                                                                <li>Low</li>
                                                                <li>Medium</li>
                                                                <li>Extreme</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="our-preset-settings-range-outer">
                                                    <p class="font14">Select the number of designs you want to generate at
                                                        once.</p>
                                                    <div class="gs-select-design our-preset-range-design">
                                                        <div class="our-preset-settings-range" data-sec="0">
                                                        </div>
                                                        <div class="our-preset-settings-range-list">
                                                            <ul>
                                                                <li>1</li>
                                                                <li>2</li>
                                                                <li>3</li>
                                                                <li>4</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gs-continue-btn-outer">
                                                    <a href="javascript:void(0)" onclick="_generateDesign(0, this)"
                                                        class="gs-continue-btn"><img
                                                            src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
                                                        Generate New Designs
                                                        <span id="submit" style="display:none">
                                                            <i class="fa fa-spinner fa-spin m-0" aria-hidden="true"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="exterior" class="tab-pane fade">
                                <div class="gs-what-to-edit-tabs">
                                    <div class="gs-what-to-edit-title">
                                        <ul>
                                            <li class="active"><a data-toggle="tab" href="#our-preset-settings-exterior">Our
                                                    preset settings</a></li>
                                            <li><a data-toggle="tab" href="#your-customs-settings-exterior">Your customs
                                                    settings </a></li>
                                        </ul>
                                    </div>
                                    <div class="gs-what-to-edit-content">
                                        <div class="tab-content">
                                            <div id="our-preset-settings-exterior" class="tab-pane show fade in active">
                                                <div class="gs-select-automatically">
                                                    <div class="gs-our-preset-settings ">
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedRoomType1"
                                                                name="selectedRoomType1">
                                                            <p>1. Select House Angle
                                                            </p>
                                                            <div class="gs-select-room-style-row" id="roomTypeDisplay1">
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Side of House"
                                                                    onclick="selectRoomType('Side of House',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/exterior-house-angle1.png') }}">
                                                                    <span>Side of House</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Front of House"
                                                                    onclick="selectRoomType('Front of House',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/exterior-house-angle2.png') }}">
                                                                    <span>Front of House</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Back of House"
                                                                    onclick="selectRoomType('Back of House',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/exterior-house-angle3.png') }}">
                                                                    <span>Back of House</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedDesignStyle1"
                                                                name="selectedDesignStyle1">
                                                            <p>2. Select Design Style <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    data-target="#view_all_exterior_choose_design">View All</a>
                                                            </p>
                                                            <div class="gs-select-room-style-row" id="designStyleDisplay1">
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Modern"
                                                                    onclick="selectDesignStyle('Modern',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type5.png') }}">
                                                                    <span>Modern</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Mediterranean"
                                                                    onclick="selectDesignStyle('Mediterranean',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type6.png') }}">
                                                                    <span>Mediterranean</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="International"
                                                                    onclick="selectDesignStyle('International',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type7.png') }}">
                                                                    <span>International</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Moody Colors"
                                                                    onclick="selectDesignStyle('Moody Colors',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type8.png') }}">
                                                                    <span>Moody Colors</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedModeType1"
                                                                name="selectedModeType1">
                                                            <p>3. Select Mode Type </p>
                                                            <div class="gs-select-room-style-row" id="modeTypeDisplay1">
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Beautiful Redesign"
                                                                    onclick="selectModeType('Beautiful Redesign',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type10.png') }}">
                                                                    <span>Beautiful Redesign</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Creative Redesign"
                                                                    onclick="selectModeType('Creative Redesign',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type11.png') }}">
                                                                    <span>Creative Redesign</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Sketch to Render"
                                                                    onclick="selectModeType('Sketch to Render',1)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type11.png') }}">
                                                                    <span>Sketch to Render</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nwchoice-toggle" style="margin-top: 15px !important">
                                                        <span class="nw-tgtype">Private Gallery </span>
                                                        <input type="checkbox" id="nwtoggle1" onchange="loadRenders(1)"
                                                            @checked($default_gallery == 'public')>
                                                        <label class="nwtoggle-label1" for="nwtoggle1">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                    <div class="our-preset-settings-range-outer">
                                                        <input type="hidden" id="strength1" name="strength1"
                                                            value="mid" />
                                                        <div class="d-flex align-items-center">
                                                            <p class="font14">AI Intervention</p>
                                                            <div class="gs-tutorials-toolnip">
                                                                <img src="{{ asset('web2/images/tutorail-wraning.svg') }}" alt="">
                                                                <div class="ai-upload-option-tooltip">
                                                                    <span>Control the number of changes you want the AI to make to your upload. For the best results, leave this option to MEDIUM. You can try with LOW and EXTREME if you don't get good results with MEDIUM.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-design our-preset-range-design">
                                                            <div class="ai-intervention" data-sec="1">
                                                            </div>
                                                            <div class="our-preset-settings-range-list">
                                                                <ul>
                                                                    <li>Very Low</li>
                                                                    <li>Low</li>
                                                                    <li>Medium</li>
                                                                    <li>Extreme</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="our-preset-settings-range-outer">
                                                        <input type="hidden" id="no_of_des1" name="no_of_des1"
                                                            value="1" />
                                                        <p class="font14">Select the number of designs you want to generate at
                                                            once.</p>
                                                        <div class="gs-select-design our-preset-range-design">
                                                            <div class="our-preset-settings-range" data-sec="1">
                                                            </div>
                                                            <div class="our-preset-settings-range-list">
                                                                <ul>
                                                                    <li>1</li>
                                                                    <li>2</li>
                                                                    <li>3</li>
                                                                    <li>4</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gs-continue-btn-outer">
                                                        <a href="javascript:void(0)" onclick="_generateDesign(1, this)"
                                                            class="gs-continue-btn"><img
                                                                src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
                                                            Generate New Designs
                                                            <span id="submit" style="display:none">
                                                                <i class="fa fa-spinner fa-spin m-0" aria-hidden="true"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="your-customs-settings-exterior" class="tab-pane show fade">
                                                <div class="our-preset-settings-box">
                                                    @if ($precisionUser == true)
                                                        <label class="our-preset-prompt-text ips-bf-parent">Type your custom instructions below and our AI will take them into account when generating your designs:
                                                            <input type="checkbox" id="nwcust1" class="ms-1 ck_inst" checked
                                                                onchange="customInstruction(1)" disabled>
                                                            &nbsp;&nbsp;&nbsp;<img
                                                                src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    @else
                                                        <label class="our-preset-prompt-text">Type your custom instructions below and our AI will take them into account when generating your designs:
                                                            <input type="checkbox" id="nwcust1" class="ms-1 ck_inst" checked
                                                                onchange="customInstruction(1)"></label>
                                                    @endif
                                                    <textarea
                                                        placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood."
                                                        name="cust-inst1" id="custom_instruction1" class="hidden"></textarea>
                                                </div>

                                                <div class="our-preset-settings-range-outer">
                                                    <div class="d-flex align-items-center">
                                                        <p class="font14">AI Intervention</p>
                                                        <div class="gs-tutorials-toolnip">
                                                            <img src="{{ asset('web2/images/tutorail-wraning.svg') }}" alt="">
                                                            <div class="ai-upload-option-tooltip">
                                                                <span>Control the number of changes you want the AI to make to your upload. For the best results, leave this option to MEDIUM. You can try with LOW and EXTREME if you don't get good results with MEDIUM.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gs-select-design our-preset-range-design">
                                                        <div class="ai-intervention" data-sec="1">
                                                        </div>
                                                        <div class="our-preset-settings-range-list">
                                                            <ul>
                                                                <li>Very Low</li>
                                                                <li>Low</li>
                                                                <li>Medium</li>
                                                                <li>Extreme</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="our-preset-settings-range-outer">
                                                    <p class="font14">Select the number of designs you want to generate at
                                                        once.</p>
                                                    <div class="gs-select-design our-preset-range-design">
                                                        <div class="our-preset-settings-range" data-sec="1">
                                                        </div>
                                                        <div class="our-preset-settings-range-list">
                                                            <ul>
                                                                <li>1</li>
                                                                <li>2</li>
                                                                <li>3</li>
                                                                <li>4</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gs-continue-btn-outer">
                                                    <a href="javascript:void(0)" onclick="_generateDesign(1, this)"
                                                        class="gs-continue-btn"><img
                                                            src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
                                                        Generate New Designs
                                                        <span id="submit" style="display:none">
                                                            <i class="fa fa-spinner fa-spin m-0" aria-hidden="true"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="garden" class="tab-pane fade">
                                <div class="gs-what-to-edit-tabs">
                                    <div class="gs-what-to-edit-title">
                                        <ul>
                                            <li class="active"><a data-toggle="tab" href="#our-preset-settings-garden">Our
                                                    preset settings</a></li>
                                            <li><a data-toggle="tab" href="#your-customs-settings-garden">Your customs
                                                    settings </a></li>
                                        </ul>
                                    </div>
                                    <div class="gs-what-to-edit-content">
                                        <div class="tab-content">
                                            <div id="our-preset-settings-garden" class="tab-pane show fade in active">
                                                <div class="gs-select-automatically">
                                                    <div class="gs-our-preset-settings ">
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedRoomType2"
                                                                name="selectedRoomType2">
                                                            <p>1. Select Garden Type
                                                                <a href="javascript:void(0)" data-toggle="modal"
                                                                    data-target="#view_all_garden_type">View All</a>
                                                            </p>
                                                            <div class="gs-select-room-style-row" id="roomTypeDisplay2">
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Backyard"
                                                                    onclick="selectRoomType('Backyard',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type1.png') }}">
                                                                    <span>Backyard</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Patio"
                                                                    onclick="selectRoomType('Patio',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type2.png') }}">
                                                                    <span>Patio</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Terrace"
                                                                    onclick="selectRoomType('Terrace',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type3.png') }}">
                                                                    <span>Terrace</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Front Yard"
                                                                    onclick="selectRoomType('Front Yard',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type2.png') }}">
                                                                    <span>Front Yard</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedDesignStyle2"
                                                                name="selectedDesignStyle2">
                                                            <p>2. Select Design Style <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    data-target="#view_all_garden_style">View All</a></p>
                                                            <div class="gs-select-room-style-row" id="designStyleDisplay2">
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Modern"
                                                                    onclick="selectDesignStyle('Modern',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type5.png') }}">
                                                                    <span>Modern</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="City"
                                                                    onclick="selectDesignStyle('City',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type6.png') }}">
                                                                    <span>City</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Contemporary"
                                                                    onclick="selectDesignStyle('Contemporary',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type7.png') }}">
                                                                    <span>Contemporary</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-design-style="Luxury"
                                                                    onclick="selectDesignStyle('Luxury',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type8.png') }}">
                                                                    <span>Luxury</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedModeType2"
                                                                name="selectedModeType2">
                                                            <p>3. Select Mode Type </p>
                                                            <div class="gs-select-room-style-row" id="modeTypeDisplay2">
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Beautiful Redesign"
                                                                    onclick="selectModeType('Beautiful Redesign',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type10.png') }}">
                                                                    <span>Beautiful Redesign</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Creative Redesign"
                                                                    onclick="selectModeType('Creative Redesign',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type11.png') }}">
                                                                    <span>Creative Redesign</span>
                                                                </div>
                                                                <div class="gs-select-room-style-single"
                                                                    data-room-type="Sketch to Render"
                                                                    onclick="selectModeType('Sketch to Render',2)">
                                                                    <img
                                                                        src="{{ asset('web2/images/select-room-type10.png') }}">
                                                                    <span>Sketch to Render</span>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nwchoice-toggle" style="margin-top: 15px !important">
                                                        <span class="nw-tgtype">Private Gallery </span>
                                                        <input type="checkbox" id="nwtoggle2" onchange="loadRenders(2)"
                                                            @checked($default_gallery == 'public')>
                                                        <label class="nwtoggle-label2" for="nwtoggle2">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                    <div class="our-preset-settings-range-outer">
                                                        <input type="hidden" id="strength2" name="strength2"
                                                            value="mid" />
                                                        <div class="d-flex align-items-center">
                                                            <p class="font14">AI Intervention</p>
                                                            <div class="gs-tutorials-toolnip">
                                                                <img src="{{ asset('web2/images/tutorail-wraning.svg') }}" alt="">
                                                                <div class="ai-upload-option-tooltip">
                                                                    <span>Control the number of changes you want the AI to make to your upload. For the best results, leave this option to MEDIUM. You can try with LOW and EXTREME if you don't get good results with MEDIUM.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gs-select-design our-preset-range-design">
                                                            <div class="ai-intervention" data-sec="2">
                                                            </div>
                                                            <div class="our-preset-settings-range-list">
                                                                <ul>
                                                                    <li>Very Low</li>
                                                                    <li>Low</li>
                                                                    <li>Medium</li>
                                                                    <li>Extreme</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="our-preset-settings-range-outer">
                                                        <input type="hidden" id="no_of_des2" name="no_of_des2"
                                                            value="1" />
                                                        <p class="font14">Select the number of designs you want to generate at
                                                            once.</p>
                                                        <div class="gs-select-design our-preset-range-design">
                                                            <div class="our-preset-settings-range" data-sec="2">
                                                            </div>
                                                            <div class="our-preset-settings-range-list">
                                                                <ul>
                                                                    <li>1</li>
                                                                    <li>2</li>
                                                                    <li>3</li>
                                                                    <li>4</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gs-continue-btn-outer">
                                                        <a href="javascript:void(0)" onclick="_generateDesign(2, this)"
                                                            class="gs-continue-btn"><img
                                                                src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
                                                            Generate New Designs
                                                            <span id="submit" style="display:none">
                                                                <i class="fa fa-spinner fa-spin m-0" aria-hidden="true"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="your-customs-settings-garden" class="tab-pane show fade">
                                                <div class="our-preset-settings-box">
                                                    @if ($precisionUser == true)
                                                        <label class="our-preset-prompt-text ips-bf-parent">Type your custom instructions below and our AI will take them into account when generating your designs:
                                                            <input type="checkbox" id="nwcust2" class="ms-1 ck_inst" checked
                                                                onchange="customInstruction(2)" disabled>
                                                            &nbsp;&nbsp;&nbsp;<img
                                                                src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    @else
                                                        <label class="our-preset-prompt-text">Type your custom instructions below and our AI will take them into account when generating your designs:
                                                            <input type="checkbox" id="nwcust2" class="ms-1 ck_inst" checked
                                                                onchange="customInstruction(2)"></label>
                                                    @endif
                                                    <textarea
                                                        placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood."
                                                        name="cust-inst2" id="custom_instruction2" class="hidden"></textarea>
                                                </div>

                                                <div class="our-preset-settings-range-outer">
                                                    <div class="d-flex align-items-center">
                                                        <p class="font14">AI Intervention</p>
                                                        <div class="gs-tutorials-toolnip">
                                                            <img src="{{ asset('web2/images/tutorail-wraning.svg') }}" alt="">
                                                            <div class="ai-upload-option-tooltip">
                                                                <span>Control the number of changes you want the AI to make to your upload. For the best results, leave this option to MEDIUM. You can try with LOW and EXTREME if you don't get good results with MEDIUM.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gs-select-design our-preset-range-design">
                                                        <div class="ai-intervention" data-sec="2">
                                                        </div>
                                                        <div class="our-preset-settings-range-list">
                                                            <ul>
                                                                <li>Very Low</li>
                                                                <li>Low</li>
                                                                <li>Medium</li>
                                                                <li>Extreme</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="our-preset-settings-range-outer">
                                                    <p class="font14">Select the number of designs you want to generate at
                                                        once.</p>
                                                    <div class="gs-select-design our-preset-range-design">
                                                        <div class="our-preset-settings-range" data-sec="2">
                                                        </div>
                                                        <div class="our-preset-settings-range-list">
                                                            <ul>
                                                                <li>1</li>
                                                                <li>2</li>
                                                                <li>3</li>
                                                                <li>4</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gs-continue-btn-outer">
                                                    <a href="javascript:void(0)" onclick="_generateDesign(2, this)"
                                                        class="gs-continue-btn"><img
                                                            src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
                                                        Generate New Designs
                                                        <span id="submit" style="display:none">
                                                            <i class="fa fa-spinner fa-spin m-0" aria-hidden="true"></i>
                                                        </span>
                                                    </a>
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
            {{-- section second end --}}

            <div class="ai-upload-latest-designs">
                <h3 class="font22">Latest Designs</h3>
                <div class="gs-select-category redesign-designs-tabs">
                    <div class="gs-select-category-list">
                        <ul class="gs-option-flex">
                            <li class="active on-gen-disable">
                                <a class="gs-select-category-list-inner category-tabs" data-toggle="tab" href="#interior"
                                    onclick="loadRenders(0)" data-sec="0">
                                    <img src="{{ asset('web2/images/gs-interior-icon.svg') }}">
                                    <span>Interior</span>
                                </a>
                            </li>
                            <li class="on-gen-disable">
                                <a class="gs-select-category-list-inner category-tabs" data-toggle="tab" href="#exterior"
                                    onclick="loadRenders(1)" data-sec="1">
                                    <img src="{{ asset('web2/images/gs-exterior-icon.svg') }}">
                                    <span>Exterior</span>
                                </a>
                            </li>
                            <li class="on-gen-disable">
                                <a class="gs-select-category-list-inner category-tabs" data-toggle="tab" href="#garden"
                                    onclick="loadRenders(2)" data-sec="2">
                                    <img src="{{ asset('web2/images/gs-garden-icon.svg') }}">
                                    <span>Garden</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="interior" class="tab-pane fade in active">
                        <div class="ai-upload-latest-top" id="jumphere0" style="display: none">
                            <h3 class="font22"></h3>
                            <div class="ai-upload-add-project delete_favourite_buttons hidden">
                                <ul>
                                    <li class="ai-upload-add-project-list">
                                        <span class="ai-upload-option-tooltip">Delete</span>
                                        <a href="javascript:void(0)" onclick="deleteMultipleImages()">
                                            <img src="{{ asset('web2/images/ai-upload-list-icon1.svg') }}">
                                        </a>
                                    </li>
                                    <li class="ai-upload-add-project-list">
                                        <span class="ai-upload-option-tooltip">Add to Favourite</span>
                                        <a href="javascript:void(0)" class="add_all_images_as_favourite">
                                            <img src="{{ asset('web2/images/ai-upload-list-icon2.svg') }}">
                                        </a>
                                    </li>
                                    <li class="ai-upload-add-project-list">
                                        <span class="ai-upload-option-tooltip">Add to Project</span>
                                        <a href="javascript:void(0)" class="add_to_project_btn">
                                            <img src="{{ asset('web2/images/ai-upload-list-icon3.svg') }}">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="ai-upload-latest-wrapper row" id="all_data0">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <template id="redesignCard">
        <div class="col-md-6 col-lg-4 col-12">
            <div class="ai-upload-latest-single">
                <div class="ai-upload-latest-after">
                    <div class="ai-upload-latest-inset">
                        <div class="ai-upload-selection">
                            <div class="ai-upload-favourite hd_image_div">
                                <img class="hd_image" src="{{ asset('web/images/hd_icon.png') }}" alt="">
                            </div>
                        </div>
                        {{-- <span class="ai-upload-title">After</span> --}}
                        <img class="complte-img img" src="" data-item="output-image">
                        <div class="ai-upload-effects">
                            <ul class="render-overlay-data-box">
                                <li class="render-overlay-data"></li>
                                <li class="render-overlay-data"></li>
                                <li class="render-overlay-data"></li>
                            </ul>
                        </div>
                        <div class="ai-upload-optons">
                            <ul>
                                <li class="ai-upload-add-project-list">
                                    <span class="ai-upload-option-tooltip"> Download </span>
                                    <a class="download" href="javascript:void(0)" data-download-url="" title="Download"
                                        download data-item="download-output-btn">
                                        <img src="{{ asset('web2/images/ai-upload-optons-icon1.svg') }}">
                                    </a>
                                </li>
                                <li class="ai-upload-add-project-list">
                                    <span class="ai-upload-option-tooltip"> Show </span>
                                    <a class="ip_img_preview inpainting-preview" href="javascript:void(0)" data-img=""
                                        data-item="preview-btn-output" title="Open" onclick="previewImage()">
                                        <img src="{{ asset('web2/images/ai-upload-optons-icon2.svg') }}">
                                    </a>
                                </li>
                                <li class="ai-upload-add-project-list on-gen-disable">
                                    <span class="ai-upload-option-tooltip"> HD </span>
                                    <a class="generate_hd_img" href="javascript:void(0)" data-img="" data-sec=""
                                        data-item="hd_quality" title="Full HD Quality">
                                        <img src="{{ asset('web2/images/gs-image-editing-slide-icon8.svg') }}">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <div id="routeToFullHdImageData" data-route="{{ route('getHdImages') }}"></div>
    {{-- @include('web.home_sections.servey_modal') --}}
    {{-- <div class="aifrm-outer page-user-dash">
        <div class="aifrm-sidespace">
            @include('web.home_sections.design')
        </div>
    </div> --}}
    {{-- @include('web.common.color_picker') --}}
@endsection

@section('scripts')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G0JYLHV57P"></script>
    <script>
        $(document).ready(function() {
            loadRenders(0);
            $('#custom_instruction0').show();
        });

        async function loadRenders(sec) {
            var modevalue = $('#modeValueForPage').val(); // Get the initial mode value
            this.multipleDownloadImg = [];
            $(`.delete_favourite_buttons`).addClass('hidden');
            $(`.ai-upload-latest-top`).css('display', 'none');
            get_designs.design_type = sec;
            var isPrivate = document.getElementById(`nwtoggle${sec}`).checked;

            if (user && isPrivate === false) {
                get_designs.type = 'private';
            } else {
                get_designs.type = 'public';
            }

            var response = await getRedesignGeneratedDesigns();

        }
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-G0JYLHV57P');
    </script>
    <script>
        $(document).ready(function() {
            var dropdownValue = localStorage.getItem('dropdownValue');
            if (dropdownValue) {
                console.log('dropdownValue',dropdownValue);
                selectModeType(dropdownValue, 0);
                localStorage.removeItem('dropdownValue');
            }
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
