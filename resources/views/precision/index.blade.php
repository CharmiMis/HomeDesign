<!DOCTYPE html>
<html lang="en">

<head>
    <!-- JavaScript Imports -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tensorflow/4.15.0/tf.min.js"
        integrity="sha512-RMW1ZrsUb7zY5+dY2sH+dOD3aPXpgQgWysvpyj+UtMani44bvq6Nj4HQ0tB/gdbG0gJb1BhapgYvUPNve0A6kQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- CSS Imports -->
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/cropper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/bootstrap.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('web/css/user-dash.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Your custom CSS -->
    <style>
        .konvajs-content {
            margin: 0 auto;
        }

        .uploadInPaintingImage {
            max-width: 100%;
        }
        #clearall{
            display: inline !important;
        }
        #promptInput0, #promptInput1, #promptInput2
        {
            background: #41326a;
            border: 1px solid #352c52;
            color: #fff;
        }

        /* Add your other custom styles here */
    </style>
</head>

<body>
    <x-app-layout>
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
                            <a class="mt-3" style="color: white;cursor: pointer;padding-right:10px;font-size:16px;"
                                onclick="loadVideoModal()"><img src="{{ asset('web/images/play-button.png') }}"
                                    width="30px" alt="" style="padding-right: 10px;"> Video
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
                                    <input type="hidden" class="data_page" data-page="inPaint" />
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
                                    <div class="mt-3 chkbox-segment"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="inpainting-stag-outer"
                                    class="inpainting-stag-outer d-flex align-items-center justify-content-center">
                                    <div id="painting-stag"></div>
                                </div>
                                <div class="masking_label mt-3">
                                    <p>You can select the elements automatically by choosing what you want to select, but you can also optimize it with the manual brush directly on the image</p>
                                </div>
                                <div class="brushing-btns">
                                    <div class="toggle_fun mt-3">
                                        <div class="nwchoice-toggle">
                                            <span class="masking-label">Remove Brush </span>
                                            <input type="checkbox" id="maskingCheckbox" class="toggleCheckbox" checked disabled>
                                            <label class="maskingCheckbox-label" for="maskingCheckbox">Toggle</label>
                                            <span class="masking-label">Add Brush</span>
                                        </div>
                                        <div class="nwchoice-toggle">
                                            <span class="masking-label">Circle Brush</span>
                                            <input type="checkbox" id="cursorCheckbox" class="toggleCheckbox" onchange="changeCursor()" >
                                            <label class="maskingCheckbox-label" for="cursorCheckbox">Toggle</label>
                                            <span class="masking-label">Square Brush</span>
                                        </div>
                                    </div>
                                    <div class="undo-redo-btn">
                                        <button class="ci-btn ci-btn-danger" id="ip-clearImage" title="Clear All">
                                            <img src="{{asset('web/images/deleteIcon.png')}}" width="25px" id="clearall"> Clear all
                                        </button>
                                        <button class="ci-btn ci-btn-danger" id="ip-undoImage" title="Undo"><img src="{{asset('web/images/undo.png')}}" width="25px"></button>
                                        <button class="ci-btn ci-btn-danger" id="ip-redoImage" title="Redo"><img src="{{asset('web/images/redo.png')}}" width="25px"></button>
                                    </div>
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
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nwai-tab active" id="pills-interior-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-interior" type="button"
                                                role="tab" aria-controls="pills-interior" aria-selected="true"
                                                onclick="loadRenders(0)">
                                                <img class="ai-icon" src="{{ asset('web/images') }}/interior-icon.svg"
                                                    alt="" loading="lazy">
                                                <span class="nwtb-title">Interiors</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nwai-tab" id="pills-exterior-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-exterior" type="button"
                                                role="tab" aria-controls="pills-exterior" aria-selected="false"
                                                onclick="loadRenders(1)">
                                                <img class="ai-icon" src="{{ asset('web/images/') }}/exterior-icon.svg"
                                                    alt="" loading="lazy">
                                                <span class="nwtb-title">Exteriors</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
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
                                                    <option id="NoStyleInterior" value="No Style">No Style - Image Improvement Only</option>
                                                    <option id="EclecticInterior" selected="" value="Eclectic">Eclectic </option>
                                                    <option id="ModernInterior" value="Modern">Modern</option>
                                                    <option id="ContemporaryInterior"value="Contemporary">Contemporary </option>
                                                    <option id="TransitionalInterior"value="Transitional">Transitional </option>
                                                    <option id="ScandinavianInterior"value="Scandanavian">Scandinavian </option>
                                                    <option id="MediterraneanInterior"value="Mediterranean">Mediterranean </option>
                                                    <option id="IkeaInterior" value="Ikea">Ikea</option>
                                                    <option id="IndustrialInterior"value="Industrial">Industrial </option>
                                                    <option id="QuietLuxuryInterior"value="Quiet Luxury">Quiet Luxury </option>
                                                    <option id="KidsInterior"value="Kids">Kids Room</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Select Room Type</label>
                                                <select class="nwfiles-optns" id="promptInputRoomType0">
                                                    <option selected="" value="living room">Living room </option>
                                                        <option value="bedroom">Bedroom </option>
                                                        <option value="Bathroom">Bathroom </option>
                                                        <option value="kitchen">Kitchen </option>
                                                        <option value="dining room">Dining room </option>
                                                        <option value="attic">Attic </option>
                                                        <option value="study room">Study room </option>
                                                        <option value="home office">Home office </option>
                                                        <option value="Family Room">Family Room</option>
                                                        <option value="Formal Dining Room">Formal Dining Room</option>
                                                        <option value="Kids Room">Kids Room</option>
                                                        <option value="Balcony">Balcony</option>
                                                        <option value="gaming room">Gaming room </option>
                                                        <option value="meeting room">Meeting room</option>
                                                        <option value="workshop">Workshop </option>
                                                        <option value="fitness gym">Fitness gym</option>
                                                        <option value="coffee shop">Coffee shop</option>
                                                        <option value="clothing store">Clothing store</option>
                                                        <option value="restaurant">Restaurant </option>
                                                        <option value="office">Office </option>
                                                        <option value="coworking space">Coworking space</option>
                                                        <option value="hotel lobbstabiy">Hotel lobby</option>
                                                        <option value="hotel room">Hotel room </option>
                                                        <option value="hotel bathroom">Hotel bathroom</option>
                                                        <option value="exhibition space">Exhibition space </option>
                                                        <option value="onsen">Onsen</option>
                                                        <option value="Working Space">Working Space</option>
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
                                                    <option id="NoStyle" value="No Style">No Style - Image Improvment Only</option>
                                                    <option id="ModernExterior" selected="" value="Modern">Modern</option>
                                                    <option id="MediterraneanExterior" value="Mediterranean">Mediterranean</option>
                                                    <option id="InternationalExterior" value="International">International </option>
                                                    <option id="MoodyColorsExterior" value="Moody Colors">Moody Colors </option>
                                                    <option id="WoodAccentsExterior" value="Wood Accents">Wood Accents </option>
                                                    <option id="BohemianExterior" value="Bohemian">Bohemian </option>
                                                    <option id="IndustrialExterior" value="Industrial">Industrial </option>
                                                    <option id="RetreatExterior" value="Retreat">Retreat </option>
                                                    <option id="ElegantExterior" value="Elegant">Elegant </option>
                                                    <option id="PaintedBrickExterior" value="Painted Brick">Painted Brick </option>
                                                    <option id="RedExterior" value="Red Brick">Red Brick </option>
                                                    <option id="ModernBlendExterior" value="Modern Blend">Modern Blend </option>
                                                    <option id="StoneCladExterior" value="Stone Clad">Stone Clad </option>
                                                    <option id="GlassHouseExterior" value="Glass House">Glass House </option>
                                                    <option id="RanchExterior" value="Ranch">Ranch </option>
                                                    <option id="ModernFarmHouseExterior" value="Modern Farm House">Modern Farm House </option>
                                                    <option id="PortugueseExterior" value="Portuguese">Portuguese </option>
                                                    <option id="TraditionalExterior" value="Traditional">Traditional </option>
                                                    <option id="CraftsmanExterior" value="Craftsman">Craftsman </option>
                                                    <option id="TudorExterior" value="Tudor">Tudor </option>
                                                    <option id="PrairieExterior" value="Prairie">Prairie </option>
                                                    <option id="ChaletExterior" value="Chalet">Chalet </option>
                                                    <option id="ColonialExterior" value="Colonial">Colonial </option>
                                                    <option id="DutchColonialExterior" value="Dutch Colonial">Dutch Colonial Revival </option>
                                                    <option id="GeorgianExterior" value="Georgian">Georgian </option>
                                                    <option id="GreenExterior" value="Green">Green </option>
                                                    <option id="ContemporaryExterior" value="Contemporary">Contemporary </option>
                                                    <option id="ChristmasExterior" value="Christmas">Christmas</option>
                                                    <option id="CottageExterior" value="Cottage">Cottage </option>
                                                    <option id="FarmhouseExterior" value="Farmhouse">Farmhouse </option>
                                                    <option id="FrenchCountryExterior" value="French Country">French Country </option>
                                                    <option id="FuturisticExterior" value="Futuristic">Futuristic </option>
                                                    <option id="GothicExterior" value="Gothic">Gothic </option>
                                                    <option id="GreekRevivalExterior" value="Greek Revival">Greek Revival </option>
                                                    <option id="MansionExterior" value="Mansion">Mansion </option>
                                                    <option id="TownhouseExterior" value="Townhouse">Townhouse </option>
                                                    <option id="VictorianExterior" value="Victorian">Victorian </option>
                                                    <option id="CorporateBuildingExterior" value="Corporate Building">Corporate building </option>
                                                    
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
                                                    <option selected="" value="side">Side of house </option>
                                                    <option value="front">Front of house </option>
                                                    <option value="back">Back of house </option>
                                                    
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
                                                    <option id="No_Style" value="No Style">No Style - Image Improvment Only</option>
                                                    <option id="Modern_Garden" selected="" value="Modern Garden">Modern</option>
                                                    <option id="City_Garden" value="City Garden">City</option>
                                                    <option id="Contemporary_Garden" value="Contemporary Garden">Contemporary</option>
                                                    <option id="Luxury_Garden" value="Luxury Garden">Luxury</option>
                                                    <option id="Apartment_Garden" value="Apartment Garden">Apartment</option>
                                                    <option id="Small_Garden" value="Small Garden">Small</option>
                                                    <option id="Vegetable_Garden" value="Vegetable Garden">Vegetable</option>
                                                    <option id="Low__Budget_Garden" value="Low Budget Garden">Low Budget</option>
                                                    <option id="Beach_Garden" value="Beach Garden">Beach</option>
                                                    <option id="Wedding_Garden" value="Wedding Garden">Wedding</option>
                                                    <option id="Rural_Garden" value="Rural Garden">Rural Garden</option>
                                                    <option id="Mediterranean_Garden" value="Mediterranean Garden">Mediterranean</option>
                                                    <option id="Restaurant_Garden" value="Restaurant Garden">Restaurant Garden</option>
                                                    <option id="Formal_Garden" value="Formal Garden">Formal</option>
                                                    <option id="American_Garden" value="American Garden">American</option>
                                                    <option id="English_Garden" value="English Garden">English</option>
                                                    <option id="Traditional_Green" value="Traditional Garden">Traditional</option>
                                                    <option id="Christmas_Garden" value="Christmas Garden">Christmas</option>
                                                    <option id="Meditation_Garden" value="Meditation Garden">Meditation</option>
                                                    <option id="Coastal_Garden" value="Coastal Garden">Coastal</option>
                                                    <option id="Tropical_Garden" value="Tropical Garden">Tropical</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="nwfile-tiTle">Garden Type <span class="tooltipnew"
                                                        data-tooltip="Choose which type of
                                                                                outdoor you have uploaded. For best results switch
                                                                                between the options to get the best results.">?</span></label>
                                                <select class="nwfiles-optns" id="promptInputRoomType2">
                                                    <option selected="" value="Backyard">Backyard</option>
                                                    <option value="patio">Patio</option>
                                                    <option value="Terrace">Terrace</option>
                                                    <option value="Front Yard">Front Yard</option>
                                                    <option value="garden">Garden</option>
                                                    <option value="Courtyard">Courtyard</option>
                                                    <option value="Pool Area">Pool Area</option>                                                    
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
                    <div class="dlt-btn-main checkbox_buttons sticky_top_btn">
                        <button class="btn btn-success add_to_project_btn hidden">Add To Project</button>
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
                                    <span><b>For optimal results, we recommend using square images.</b> However, if you
                                        prefer to maintain the original aspect ratio of your image, simply check the box on
                                        the left. Please note that while this option preserves the original image shape, the
                                        results may not be as refined as with square images. <br>
                                    </span>
                                </label>
                                <div class="crop_modal_btn">
                                    <button type="button" onclick="cropImageButton()" class="btn btn-primary-c"
                                        style="font-size:16px;">Crop
                                        Image</button>
                                    <button type="button" class="btn btn-secondary close-decor-stag"
                                        data-bs-dismiss="modal" style="font-size:16px;">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal to crop image -->

                <template id="inPaintingCard">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3 mb-3">
                        <div class="in-painting-card">
                            <img class="img" data-item="image">
                            <div class="card-options">
                                <div class="inpainting-btn">
                                    <div class="sharetab sharetab-buttons share text-center ip_img_preview inpainting-preview"
                                        data-img="" data-item="preview-btn" title="Open">
                                        <img src="/web/images/magnifying1.svg">
                                        <span>Show</span>
                                    </div>
                                    <a class="sharetab sharetab-buttons download" href="javascript:void(0)" data-download-url="" title="Download" download
                                        data-item="download-btn">
                                        <img class="hover_img" src="/web/images/download1-hover.svg">
                                        <span>Download</span>
                                    </a>
                                    <a class="sharetab sharetab-buttons use-as-input-image" data-img=""
                                        data-item="user_as_input" title="Use as Input">
                                        <img src="/web/images/input1.svg" alt="" loading="lazy">
                                        <span>Input</span>
                                    </a>
                                </div>
                            </div>
                            <div class="render-overlay-box">
                                <span class="render-overlay"></span>
                                <span class="render-overlay"></span>
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
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade modal-design-preview" id="modalImagePreview" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="mdp-container">
                    <div class="mdp-img">
                        <img class="" id="mip">
                    </div>
                    <div class="mdp-cl-btn">
                        <span  data-bs-dismiss="modal">
                        <i class="fa fa-times fa-unset" aria-hidden="true"></i>
                        </span>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="routeToGetFailedResp" data-route="{{ route('failed_response.data') }}"></div>
    <div id="routeToGetBase64Image" data-route="{{ route('getBase64Image.Url') }}"></div>
</x-app-layout>
</body>
        <script>
            const SITE_BASE_URL = "{{ config('app.url') }}";
        </script>
    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/wow.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('web/js/script.js') }}"></script>
    <script src="{{ asset('web/js/custom-script.js') }}"></script>


    
    <script src="{{ asset('web/js/konva.min.js') }}"></script>
    <script src="{{ asset('web/js/cropper.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery-cropper.js') }}"></script>
    <script src="{{ asset('web/js/in-painting-v2.js') }}"></script>
    <script>
        async function loadRenders(sec) {
            this.multipleDownloadImg = [];
            $(`.delete_button`).addClass('hidden');
            $(`.add_to_project_btn`).addClass('hidden');

            get_designs.design_type = sec;

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

        // Fetch projects on page loa
    </script>
</html>