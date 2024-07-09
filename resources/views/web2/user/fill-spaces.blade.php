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
    ?>
    <input type="hidden" id="modeValueForPage" value="2" />
    <input type="hidden" class="data_page" data-page="fillSpace" />
    <input type="hidden" id="precisionUser" value="{{ $precisionUser ? 'true' : 'false' }}">
    <div class="ai-tool-wrapper">
        <div class="ai-tool-right">
            {{-- section first start --}}
            <div class="ai-tool-right-top top-menu-bar-first">
                <h3 class="font22">Fill Spaces</h3>
                <ul>
                    <li class="active first_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Upload image</span>
                    </li>
                    <li class="second_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Select what to edit</span>
                    </li>
                    <li class="third_tab_active">
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
                        <h2>Fill Empty Spaces with Furniture and Decor!</h2>
                        <p>Furnish and decorate your empty rooms with our Fill Spaces mode. Using state-of-the-art AI, this tool helps you transform vacant areas into beautifully styled spaces tailored to your preferences. Whether you’re designing an empty living room, bedroom, or patio, Fill Spaces adds the perfect furniture and decor in seconds.</p>
                    </div>
                    <div class="gs-dashboard-cross">
                        <img src="{{ asset('web2/images/cross-icon.svg') }}">
                        <img class="light-mode" src="{{ asset('web2/images/light-mode/cross-icon.svg') }}">
                    </div>
                </div>
            <div class="image-background-container upload-image-container">
                <div class="ai-upload-image">
                    <input type="file" class="ai-upload-input" id="ipFilePicker">
                    <h3 class="font22">Upload your image </h3>
                    <img src="{{ asset('web2/images/gs-upload-img.png') }}">
                    <span>Drag and drop your image </span>
                    <a href="#">Or click here to upload</a>
                </div>
            </div>
            {{-- section first end --}}

            {{-- section second start --}}
            <div class="ai-tool-right-top top-menu-bar-second" style="display: none">
                <div class="ai-tool-right-back-btn">
                    <a href="javascript:void(0)" class="gs-back-btn previous_page">
                        <img src="{{ asset('web2/images/back-btn-icon.svg') }}">
                        <img class="light-mode" src="{{ asset('web2/images/light-mode/back-btn-icon.svg') }}">
                    </a>
                    <h3 class="font22">Precision +</h3>
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
                    <li class="third_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Customise and Generate</span>
                    </li>
                </ul>
                {{-- <div class="color_mode">
                    <input type="checkbox" id="toggle-btn-2" class="toggle-btn" {{ auth()->user()->light_mode == 0 ? 'checked' : '' }}>
                    <label for="toggle-btn-2"></label>
                </div> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span>Log Out</span>
                    </a>
                </form>
            </div>

            <div class="ai-tool-right-top top-menu-bar-third" style="display: none">
                <div class="ai-tool-right-back-btn">
                    <a href="javascript:void(0)" class="gs-back-btn previous_page">
                        <img src="{{ asset('web2/images/back-btn-icon.svg') }}">
                        <img class="light-mode" src="{{ asset('web2/images/light-mode/back-btn-icon.svg') }}">
                    </a>
                    <h3 class="font22">Precision +</h3>
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
                    <li class="active third_tab_active">
                        <div class="ai-tool-right-steps"></div>
                        <span>Customise and Generate</span>
                    </li>
                </ul>
                {{-- <div class="color_mode">
                    <input type="checkbox" id="toggle-btn-3" class="toggle-btn" {{ auth()->user()->light_mode == 0 ? 'checked' : '' }}>
                    <label for="toggle-btn-3"></label>
                </div> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span>Log Out</span>
                    </a>
                </form>
            </div>

            <div class="image-show-container image-mask-container">
                <div class="gs-what-to-edit-wrapper">
                    <div class="gs-what-to-edit-left image-mask-container">
                        <div id="inpainting-stag-outer"
                            class="inpainting-stag-outer d-flex align-items-center justify-content-center">
                            <div id="painting-stag"></div>
                        </div>
                        <div class="gs-what-to-edit-tips">
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>Use the automated selection, then fine-tune your selection with the manual brush.</p>
                                </div>
                            </div>
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>Click ‘Refine Manually’ to adjust the brush size, shape, and behavior.</p>
                                </div>
                            </div>
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>Only select the area that you want to change. Our AI will disregard non-selected areas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gs-what-to-edit-right segment-masking-container" style="display: none">
                        <div class="gs-what-to-edit-tabs">
                            <div class="gs-what-to-edit-title">
                                <ul>
                                    <li class="active"><a data-toggle="tab" href="#select-automatically">Select
                                            Automatically</a></li>
                                    <li><a data-toggle="tab" href="#refine-manually">Refine Manually </a></li>
                                </ul>
                            </div>
                            <div class="gs-what-to-edit-content">
                                <div class="tab-content">
                                    <div id="select-automatically" class="tab-pane show fade in active">
                                        <div class="gs-select-automatically">
                                            <p>Automatically or manually select objects, with the ability to combine both methods.</p>
                                            <div class="gs-select-automatically-inner">
                                                <p>Select objects automatically</p>
                                                <div class="chkbox-segment"></div>
                                            </div>
                                            <div class="gs-continue-btn-outer">
                                                <a href="javascript:void(0)"
                                                    class="gs-continue-btn continue-parameter">Continue</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="refine-manually" class="tab-pane show fade">
                                        <div class="gs-select-manually-inner">
                                            <div class="gs-select-manually-top">
                                                <p>Edit manually using the brush</p>
                                                <input type="hidden" value="70" id="ip-brush-thickness" />
                                                <input class="gs-select-manually-value" type="text" id="amount"
                                                    readonly="">
                                            </div>
                                            <div class="gs-select-design">
                                                <div class="gs-select-range"></div>
                                            </div>
                                            <div class="gs-refine-manually-links">
                                                <div class="gs-refine-manually-single">
                                                    <input type="hidden" id="maskingCheckbox" value="true" />
                                                    <a href="javascript:void(0)" id="removeMasking" onclick="toggleMasking(false)">Remove Masking</a>
                                                    <a href="javascript:void(0)" id="addMasking" onclick="toggleMasking(true)" class="active">Add
                                                        Masking</a>
                                                </div>
                                                <div class="gs-refine-manually-single">
                                                    <input type="hidden" id="cursorCheckbox" value="false" />
                                                    <a href="javascript:void(0)" onclick="toggleBrushingCursor(false)"
                                                        class="active"><img
                                                            src="{{ asset('web2/images/circle-brush.svg') }}">
                                                        Circle Brush</a>
                                                    <a href="javascript:void(0)" onclick="toggleBrushingCursor(true)"><img
                                                            src="{{ asset('web2/images/square-brush.svg') }}">Square Brush</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="undo-redo-btn">
                                            <button class="ci-btn ci-btn-danger" id="ip-clearImage" title="Clear All">
                                                <img src="{{ asset('web/images/deleteIcon.png') }}" width="25px"> Clear all
                                            </button>
                                            <button class="ci-btn ci-btn-danger" id="ip-undoImage" title="Undo"><img
                                                    src="{{ asset('web/images/undo.png') }}" width="25px"></button>
                                            <button class="ci-btn ci-btn-danger" id="ip-redoImage" title="Redo"><img
                                                    src="{{ asset('web/images/redo.png') }}" width="25px"></button>
                                        </div>
                                        <div class="gs-continue-btn-outer">
                                            <a href="javascript:void(0)"
                                                class="gs-continue-btn continue-parameter">Continue</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gs-what-to-edit-right category-container" style="display: none">
                        <div class="gs-select-category">
                            <p class="font14">Select what you want to generate</p>
                            <div class="gs-select-category-list">
                                <ul class="gs-option-flex designs_tabs">
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
                                                    {{-- <p>You can change the colors only, or also change textures, materials.</p> --}}
                                                    <div class="gs-our-preset-settings ">
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedRoomType0"
                                                                name="selectedRoomType0">
                                                            <p>1. Select Room Type <a href="javascript:void(0)" data-toggle="modal"
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
                                                    <div class="gs-continue-btn-outer painting_generating_bt">
                                                        <a href="javascript:void(0)" onclick="_generateInPaintingDesign(0, this)"
                                                            id="generateDesignBtn0"
                                                            class="gs-continue-btn generateDesignBtn0">
                                                            <img src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
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
                                                    <p class="our-preset-prompt-text">You can use a custom prompt below</p>
                                                    <textarea placeholder="e.g. Scandinavian dining room design, beautiful, white colors" name="cust-inst0"
                                                        id="custom_instruction0"></textarea>
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
                                                <div class="gs-continue-btn-outer painting_generating_bt">
                                                    <a href="javascript:void(0)" onclick="_generateInPaintingDesign(0, this)"
                                                        id="generateDesignBtn0" class="gs-continue-btn generateDesignBtn0">
                                                        <img src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
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
                                                    {{-- <p>You can change the colors only, or also change textures, materials.</p> --}}
                                                    <div class="gs-our-preset-settings ">
                                                        <div class="gs-select-room-style">
                                                            <input type="hidden" id="selectedRoomType1"
                                                                name="selectedRoomType1">
                                                            <p>1. Select House Angle
                                                                <!-- <a href="javascript:void(0)"  data-toggle="modal" data-target="#view_all_exterior_room_type">View All</a> -->
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
                                                            <p>2. Select Design Style <a href="javascript:void(0)" data-toggle="modal"
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
                                                    <div class="gs-continue-btn-outer painting_generating_bt">
                                                        <a href="javascript:void(0)" onclick="_generateInPaintingDesign(1, this)"
                                                            id="generateDesignBtn1"
                                                            class="gs-continue-btn generateDesignBtn1">
                                                            <img src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
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
                                                    <p class="our-preset-prompt-text">You can use a custom prompt below</p>
                                                    <textarea placeholder="e.g. Scandinavian dining room design, beautiful, white colors" name="cust-inst1"
                                                        id="custom_instruction1"></textarea>
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
                                                <div class="gs-continue-btn-outer painting_generating_bt">
                                                    <a href="javascript:void(0)" onclick="_generateInPaintingDesign(1, this)"
                                                        id="generateDesignBtn1" class="gs-continue-btn generateDesignBtn1">
                                                        <img src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
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
                                                    {{-- <p>You can change the colors only, or also change textures, materials.</p> --}}
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
                                                            <p>2. Select Design Style <a href="javascript:void(0)" data-toggle="modal"
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
                                                    <div class="gs-continue-btn-outer painting_generating_bt">
                                                        <a href="javascript:void(0)" onclick="_generateInPaintingDesign(2, this)"
                                                            id="generateDesignBtn2"
                                                            class="gs-continue-btn generateDesignBtn2">
                                                            <img src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
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
                                                    <p class="our-preset-prompt-text">You can use a custom prompt below</p>
                                                    <textarea placeholder="e.g. Scandinavian dining room design, beautiful, white colors" name="cust-inst2"
                                                        id="custom_instruction2"></textarea>
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
                                                <div class="gs-continue-btn-outer painting_generating_bt">
                                                    <a href="javascript:void(0)" onclick="_generateInPaintingDesign(2, this)"
                                                        id="generateDesignBtn2" class="gs-continue-btn generateDesignBtn2">
                                                        <img src="{{ asset('web2/images/gs-generate-new-design.svg') }}">
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

            <div class="ai-upload-latest-designs">
                <h3 class="font22">Latest Designs</h3>
                <div class="gs-select-category redesign-designs-tabs">
                    <div class="gs-select-category-list">
                        <ul class="gs-option-flex designs_tabs">
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
    @include('web2.user.in-painting-dynamic-template')
    <div id="routeToFullHdImageData" data-route="{{ route('getHdImages') }}"></div>
    <div id="routeToGetBase64Image" data-route="{{ route('getBase64Image.Url') }}"></div>
    <div id="deleteRenderImages" class="hidden" data-route="{{ route('image.delete') }}"></div>
    {{-- <div id="addImagesToProject" class="hidden" data-route="{{ route('user.add-images-to-project') }}"></div> --}}
@endsection

@section('scripts')
    <script src="{{ asset('web/js/konva.min.js') }}"></script>
    <script src="{{ asset('web/js/cropper.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery-cropper.js') }}"></script>
    <script src="{{ asset('web2/js/in-painting-v2.js') }}?v={{ config('app.in_paint_v2_version') }}"></script>
    <script>
        async function loadRenders(sec) {
            var modevalue = $('#modeValueForPage').val(); // Get the initial mode value
            this.multipleDownloadImg = [];
            $(`.delete_favourite_buttons`).addClass('hidden');
            $(`.ai-upload-latest-top`).css('display', 'none');
            get_inpainting_designs.design_type = sec;

            var response = await getInPaintingGeneratedDesigns();
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

    <script>
        function toggleMasking(value) {
            const maskingCheckbox = document.getElementById('maskingCheckbox');
            if (value) {
                maskingCheckbox.value = "true";
            } else {
                maskingCheckbox.value = "false";
            }
        }

        function toggleBrushingCursor(value) {
            const cursorCheckbox = document.getElementById('cursorCheckbox');
            if (value) {
                cursorCheckbox.value = "true";
            } else {
                cursorCheckbox.value = "false";
            }
            changeCursor();
        }
    </script>
@endsection
