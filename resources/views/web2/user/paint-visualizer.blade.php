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
    <input type="hidden" id="modeValueForPage" value="8" />
    <input type="hidden" class="data_page" data-page="color_swap" />
    {{-- <input type="hidden" id="precisionUser" value="{{ $precisionUser ? 'true' : 'false' }}"> --}}
    <div class="ai-tool-wrapper">
        <div class="ai-tool-right">
            {{-- section first start --}}
            <div class="ai-tool-right-top top-menu-bar-first">
                <h3 class="font22">Paint Visualizer</h3>
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
                        <h2>Change Wall Colors Instantly!</h2>
                        <p>Transform the look and feel of your interiors and exteriors with our Paint Visualizer tool. This feature allows you to effortlessly change the paint color of any wall (interior or exterior), using either our preset options or colors uploaded by you.</p>
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
                    <h3 class="font22">Paint Visualizer</h3>
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
                    <h3 class="font22">Paint Visualizer</h3>
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
                                    <p>Use Automated Selection or Manual Selection to select the areas that you want to paint over.</p>
                                </div>
                            </div>
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>Pick the color from our Presets, use the color picker or upload an image with your sample color.</p>
                                </div>
                            </div>
                            <div class="gs-what-to-edit-tip-box">
                                <div class="gs-what-to-edit-tip-right">
                                    <p>Make sure the selection is as accurate as possible for the best results</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gs-what-to-edit-right segment-masking-container" style="display: none">
                        <div class="gs-what-to-edit-tabs">
                            <div class="gs-what-to-edit-title">
                                <ul>
                                    <li class="active"><a data-toggle="tab" href="#select-automatically">Automatic Selection</a></li>
                                    <li><a data-toggle="tab" href="#refine-manually">Manual Selection </a></li>
                                </ul>
                            </div>
                            <div class="gs-what-to-edit-content">
                                <div class="tab-content">
                                    <div id="select-automatically" class="tab-pane show fade in active">
                                        <div class="gs-select-automatically">
                                            <p>Automatically or manually select objects, with the ability to combine both
                                                methods.</p>
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
                                                    <a href="javascript:void(0)" id="removeMasking"
                                                        onclick="toggleMasking(false)">Remove Masking</a>
                                                    <a href="javascript:void(0)" id="addMasking"
                                                        onclick="toggleMasking(true)" class="active">Add
                                                        Masking</a>
                                                </div>
                                                <div class="gs-refine-manually-single">
                                                    <input type="hidden" id="cursorCheckbox" value="false" />
                                                    <a href="javascript:void(0)" onclick="toggleBrushingCursor(false)"
                                                        class="active"><img src="{{ asset('web2/images/circle-brush.svg') }}">
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
                        <div class="gs-what-to-edit-tabs">
                            <div class="gs-what-to-edit-title">
                                <ul>
                                    <li class="active"><a data-toggle="tab" href="#our-preset-settings-interior" class="presetLink">Standard Paints</a></li>
                                    <li><a data-toggle="tab" href="#your-customs-settings-interior" class="customLink">Custom Paints</a></li>
                                </ul>
                            </div>
                            <div class="gs-what-to-edit-content">
                                <div class="tab-content">
                                    <div id="our-preset-settings-interior" class="tab-pane show fade in active">
                                        <div class="gs-select-automatically">
                                            <div class="gs-our-preset-settings">
                                                <div class="gs-our-preset-color" data-sec="0">
                                                    <input type="hidden" id="color_texture0" name="color_texture0">
                                                    <p>Select a paint color from the list:</p>
                                                    @include('web2.designs_options.paint-visualizer')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="your-customs-settings-interior" class="tab-pane show fade">
                                        <div class="color-picker-sectopn">
                                            <p>Use color picker :</p>
                                            <div class="custom-color-picker">
                                                <img src="{{ asset('web2/images/color-wheel.png') }}" alt="">
                                                <input type="color" id="colorPicker">
                                                <input type="hidden" id="colorPickerValue" value="">
                                            </div>
                                            <input type="text" id="colorName" placeholder="Selected color name" readonly>
                                            <p class="custom-line"><span>OR</span></p>
                                        </div>
                                        <div class="ai-upload-image upload-texture-image-container">
                                            <input type="file" class="ai-upload-input" id="ipFilePicker2">
                                            <h3 class="font22 upload-content">Upload your image </h3>
                                            <img class="upload-content" src="{{ asset('web2/images/gs-upload-img.png') }}">
                                            <span class="upload-content">Drag and drop your image </span>
                                            <a href="#" class="upload-content">Or click here to upload</a>
                                            <div id="painting-stag-sec" class="image-gallery">
                                                <img src="" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="gs-select-automatically">
                            <div class="our-preset-settings-range-outer">
                                <input type="hidden" id="no_of_des0" name="no_of_des0" value="1" />
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
                                <a href="javascript:void(0)" onclick="_generateStyleTransferDesign(0, this)"
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

            <div class="ai-upload-latest-designs">
                <h3 class="font22">Latest Designs</h3>
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
    <script type="text/javascript" src="https://chir.ag/projects/ntc/ntc.js"></script>
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
    <script>
        $('#colorPicker').on('input', function() {
            var hex = $(this).val();
            var rgb = hexToRgb(hex);
            $('#colorPickerValue').val(rgb);

            var n_match = ntc.name(hex);
            var colorName = n_match[1]; // Color name
            $('#colorName').val(colorName);
        });

        function hexToRgb(hex) {
            // Remove the leading #
            hex = hex.replace('#', '');

            // Parse the hex values
            var bigint = parseInt(hex, 16);
            var r = (bigint >> 16) & 255;
            var g = (bigint >> 8) & 255;
            var b = bigint & 255;

            return r + "," + g + "," + b;
        }

        function selectColor(event, colorName) {
            // Define a mapping of color names to RGB values
            const colorMap = {
                'Alabaster White': '240, 237, 230',
                'Chantilly Lace': '251, 251, 245',
                'Simply White': '234, 230, 222',
                'Swiss Coffee': '232, 227, 219',
                'Cotton Balls': '251, 248, 241',
                'Cloud White': '235, 230, 217',
                'Revere Pewter': '209, 207, 199',
                'Edgecomb Gray': '211, 208, 199',
                'Classic Gray': '217, 214, 204',
                'Agreeable Gray': '209, 204, 198',
                'Accessible Beige': '215, 208, 198',
                'Pale Oak': '229, 224, 211',
                'Balboa Mist': '223, 218, 211',
                'Gray Owl': '211, 215, 218',
                'Coventry Gray': '157, 163, 169',
                'Dovetail': '157, 143, 135',
                'Urbane Bronze': '99, 93, 83',
                'Iron Ore': '67, 66, 66',
                'Tricorn Black': '28, 27, 26',
                'Black Magic': '28, 27, 26',
                'Hale Navy': '77, 83, 86',
                'Naval': '54, 72, 89',
                'Blue Note': '34, 54, 69',
                'Stonington Gray': '186, 195, 200',
                'Chelsea Gray': '166, 161, 155',
                'Kendall Charcoal': '110, 113, 112',
                'Wrought Iron': '55, 61, 63',
                'White Dove': '241, 241, 236',
                'Decorator\'s White': '232, 233, 232',
                'Sea Salt': '216, 225, 225',
                'Rainwashed': '215, 225, 225',
                'Silver Strand': '194, 201, 201',
                'Pewter Green': '132, 140, 130',
                'Hunter Green': '78, 91, 90',
                'Forest Green': '51, 77, 50',
                'Soft Fern': '221, 231, 225',
                'Kittery Point Green': '167, 177, 164',
                'Wythe Blue': '184, 206, 208',
                'Beach Glass': '191, 206, 208',
                'Palladian Blue': '195, 206, 208',
                'Hawthorne Yellow': '243, 221, 130',
                'Buttercream': '245, 230, 180',
                'Lemonade': '255, 250, 205',
                'Sunflower': '255, 216, 0',
                'Oxford Gold': '197, 179, 88',
                'Caliente': '199, 62, 58',
                'Heritage Red': '140, 55, 53',
                'Poppy': '227, 66, 52',
                'Coral Reef': '243, 94, 81',
                'Spanish Red': '179, 27, 27'
            };

            // Get the hidden input element
            var hiddenInput = document.getElementById('colorPickerValue');

            // Get the clicked <li> element
            var clickedLi = event.target.closest('li');

            // Check if the <li> is active
            var isActive = clickedLi.classList.contains('active');

            // Remove active class from all list items
            var allLis = clickedLi.parentElement.querySelectorAll('li');
            allLis.forEach(li => li.classList.remove('active'));

            // Toggle active class and set hidden input value
            if (isActive) {
                clickedLi.classList.remove('active');
                hiddenInput.value = '';
            } else {
                clickedLi.classList.add('active');
                hiddenInput.value = colorMap[colorName]; // Set RGB value from the map
            }
        }

        $('.gs-what-to-edit-title ul li a').on('click', function () {
            document.getElementById('colorPickerValue').value = '';
            var allLis = document.querySelectorAll('#colorList li');
            allLis.forEach(li => li.classList.remove('active'));
        });
    </script>
@endsection
