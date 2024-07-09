<?php
$userActivePlan = '';
$precisionUser = false;
$default_gallery = 'public';
if (auth()->check()) {
    $userActivePlan = auth()
        ->user()
        ->activePlan();
    $default_gallery = (auth()->user()->total_designs == 0) ? 'public' : 'private';
}

?>
<section id="generate">
    <div class="nw-formouter">
        <div class="nw-forminner">
            <div class="container">
                <div class="row">
                    <h2 class="cmn-title1">START BY<strong> SELECTING YOUR CATEGORY BELOW:</strong></h2>

                    <div id="myModal2" class="modal" style="position: fixed; top: 0; left: 0; z-index: 1040; width: 100vw; height: 100vh; background-color: rgb(0 0 0 / 72%); backdrop-filter: blur(10px);">

                        <div class="modal-content">
                            <div class="modallog2">
                                <div style="text-align: center;">
                                    <span class="close pad" onclick="closeModal2()" style="color:#1E1634;">&times;</span>
                                </div>
                                <img id="previewImageSelected">
                            </div>
                        </div>
                    </div>


                    <div class="nwfrm-tabs">
                        <ul class="nav nav-pills" id="ai-category-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nwai-tab active" id="pills-interior-tab" data-bs-toggle="pill" data-bs-target="#pills-interior" type="button" role="tab" aria-controls="pills-interior" aria-selected="true" onclick="loadRenders(0)">
                                    <img class="ai-icon" src="{{ asset('web/images') }}/interior-icon.svg" alt="" loading="lazy">
                                    <span class="nwtb-title">Interiors</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nwai-tab" id="pills-exterior-tab" data-bs-toggle="pill" data-bs-target="#pills-exterior" type="button" role="tab" aria-controls="pills-exterior" aria-selected="false" onclick="loadRenders(1)">
                                    <img class="ai-icon" src="{{ asset('web/images/') }}/exterior-icon.svg" alt="" loading="lazy">
                                    <span class="nwtb-title">Exteriors</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nwai-tab" id="pills-garden-tab" data-bs-toggle="pill" data-bs-target="#pills-garden" type="button" role="tab" aria-controls="pills-garden" aria-selected="false" onclick="loadRenders(2)">
                                    <img class="ai-icon" src="{{ asset('web/images/') }}/garden-icon.svg" alt="" loading="lazy">
                                    <span class="nwtb-title">Gardens</span>
                                </button>
                            </li>
                        </ul>
                        <div class="loader_div" id="loaddividmobile">

                            <img src="{{ asset('web/images/') }}/logoanm2.gif" style="height: 109px; margin-top:
                                        64px;">
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-interior" role="tabpanel" aria-labelledby="pills-interior-tab">
                            <div class="nwfrm-contentouter" id="forminterior0">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-6 col-md-6 order-mobile-top">
                                        <div class="nwfrm-comaparison">
                                            <h5 class="nwfrm-heading" id="jumphere0">Latest Designs</h5>
                                            <div class="cstmauto-scroll user_gallery_container" id="all_data0" data-sec-id="0">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 order-mobile-btm">
                                        <div class="nwfile-uploadside">
                                            <form>
                                                <input type="hidden" name="image_type">
                                                <input type="hidden" name="image">
                                                <div class="ribon-bx">
                                                    <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                    <div class="ribon-overlay">
                                                        <img class="nwstepimg" src="{{ asset('web/images/') }}/fillvector.svg" alt="" loading="lazy">
                                                        <span class="ribon-text"><strong>Step 1:</strong>
                                                            Upload Image
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="nwupload-bx @if (auth()->check()) img-upload-outer @endif" id="file-sectionbx0" data-section="0" onclick="@if (!auth()->check()) showLoginModal() @endif">
                                                    <input class="select-file @if (auth()->check()) dimg-picker @endif" type="file" id="fileselect0" style="display:none;" data-section="0">
                                                    <div class="fileselect-area">
                                                        <img src="{{ asset('web/images/') }}/fileselect.svg" id="uploadText0" alt="" loading="lazy">
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
                                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg" src="{{ asset('web/images/') }}/upload-vector.svg" alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 2:</strong>
                                                                Customize</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Room Type<span class="tooltipnew" data-tooltip="Choose the type of room
                                                                                layout you uploaded. If you are uploading an image with a
                                                                                living room, choose living room. If you want to transform
                                                                                that living room to kitchen, choose kitchen.">?</span></label>
                                                                <select class="nwfiles-optns" id="roomType0">
                                                                    <option selected="" value="living room">Living
                                                                        room </option>
                                                                    <option value="bedroom">Bedroom </option>
                                                                    <option value="gaming room">Gaming room </option>
                                                                    <option value="Bathroom">Bathroom </option>
                                                                    <option value="attic">Attic </option>
                                                                    <option value="kitchen">Kitchen </option>
                                                                    <option value="dining room">Dining room </option>
                                                                    <option value="study room">Study room </option>
                                                                    <option value="home office">Home office </option>
                                                                    @if ($userActivePlan == 'free')
                                                                    <option class="paid_feature_modal">Meeting room
                                                                        &nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">
                                                                        Workshop&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Fitness
                                                                        gym&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Coffee
                                                                        shop&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Clothing
                                                                        store&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">
                                                                        Restaurant&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">
                                                                        Office&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Coworking
                                                                        space&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Hotel
                                                                        &nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Hotel
                                                                        room&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Hotel
                                                                        bathroom&nbsp;&#xf023;
                                                                    </option>
                                                                    <option class="paid_feature_modal">Exhibition
                                                                        space&nbsp;&#xf023; </option>
                                                                    <option class="paid_feature_modal">
                                                                        Onsen&nbsp;&#xf023;
                                                                    </option>
                                                                    @else
                                                                    <option value="meeting room">Meeting room
                                                                    </option>
                                                                    <option value="workshop">Workshop </option>
                                                                    <option value="fitness gym">Fitness gym
                                                                    </option>
                                                                    <option value="coffee shop">Coffee shop
                                                                    </option>
                                                                    <option value="clothing store">Clothing store
                                                                    </option>
                                                                    <option value="restaurant">Restaurant </option>
                                                                    <option value="office">Office </option>
                                                                    <option value="coworking space">Coworking space
                                                                    </option>
                                                                    <option value="hotel lobbstabiy">Hotel lobby
                                                                    </option>
                                                                    <option value="hotel room">Hotel room </option>
                                                                    <option value="hotel bathroom">Hotel bathroom
                                                                    </option>
                                                                    <option value="exhibition space">Exhibition
                                                                        space </option>
                                                                    <option value="onsen">Onsen </option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- file selection row -->
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Mode <span class="tooltipnew" data-tooltip="Choose the mode you want. You can redesign
                                                                                a room, fill it with furniture in the case of an empty
                                                                                room and so on.

                                                                                Redesign: This mode will redesign the room using the
                                                                                style selected below. Fill the room: Use this mode to
                                                                                furnish an empty room using the selected style below.
                                                                                Empty the room (SOON): Use this mode to remove any
                                                                                furniture from a room and generate a clean render.

                                                                                Change colors: Use this mode to change the color scheme
                                                                                and keep the same furniture style and placement.

                                                                                Room Mix: Move the furniture around and visualize how the
                                                                                room will look like from a different perspective. (BETA
                                                                                FEATURE, results may vary)

                                                                                Fill the Room: Use this mode to add furniture to an empty
                                                                                room using the selected style below.">?</span></label>
                                                                <select class="nwfiles-optns" id="modeType0">
                                                                    <option>Redesign</option>
                                                                    <option>Fill The Room</option>
                                                                    <option>Change Colors</option>
                                                                    @if ($userActivePlan == 'free')
                                                                    <option class="paid_feature_modal">Room
                                                                        Mix&nbsp;&#xf023;</option>
                                                                    @else
                                                                    <option>Room Mix</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Design
                                                                    Style</label>
                                                                <select class="nwfiles-optns" id="styleType0">

                                                                    <option id="EclecticInterior" value="Eclectic" selected>Eclectic </option>
                                                                    <option id="ModernInterior" value="Modern">Modern
                                                                    </option>
                                                                    <option id="ContemporaryInterior" value="Contemporary">
                                                                        Contemporary </option>
                                                                    <option id="TransitionalInterior" value="Transitional">
                                                                        Transitional </option>
                                                                    <option id="ScandinavianInterior" value="Scandanavian">
                                                                        Scandinavian </option>
                                                                    <option id="MediterraneanInterior" value="Mediterranean">
                                                                        Mediterranean </option>
                                                                    <option id="IkeaInterior" value="Ikea">Ikea
                                                                    </option>
                                                                    <option id="IndustrialInterior" value="Industrial">
                                                                        Industrial </option>
                                                                    <option id="QuietLuxuryInterior" value="Quiet Luxury">
                                                                    Quiet Luxury </option>
                                                                    @if ($userActivePlan == 'free')
                                                                    <option id="ShabbyChicInterior" class="paid_feature_modal">Shabby
                                                                        Chic&nbsp;&#xf023;</option>
                                                                    <option id="CoastalInterior" class="paid_feature_modal">
                                                                        Coastal&nbsp;&#xf023;</option>
                                                                    <option id="BauhausInterior" class="paid_feature_modal">
                                                                        Bauhaus&nbsp;&#xf023;</option>
                                                                    <option id="BohoInterior" class="paid_feature_modal">
                                                                        Bohemia&nbsp;&#xf023;</option>
                                                                    <option id="TraditionalInterior" class="paid_feature_modal">
                                                                        Traditional&nbsp;&#xf023;</option>
                                                                    <option id="RusticInterior" class="paid_feature_modal">
                                                                        Rustic&nbsp;&#xf023;</option>
                                                                    <option id="MinimalismInterior" class="paid_feature_modal">
                                                                        Minimalism&nbsp;&#xf023;</option>
                                                                    <option id="JapandiInterior" class="paid_feature_modal">
                                                                        Japandi&nbsp;&#xf023;</option>
                                                                    <option id="JapaneseInterior" class="paid_feature_modal">Japanese
                                                                        design&nbsp;&#xf023;</option>
                                                                    <option id="BaliInterior" class="paid_feature_modal">
                                                                        Bal&nbsp;&#xf023;</option>
                                                                    <option id="TropicalInterior" class="paid_feature_modal">
                                                                        Tropical&nbsp;&#xf023;</option>
                                                                    <option id="AsianDecorInterior" class="paid_feature_modal">Asian
                                                                        Decor&nbsp;&#xf023;</option>
                                                                    <option id="ZenInterior" class="paid_feature_modal">Ze&nbsp;&#xf023;
                                                                    </option>
                                                                    <option id="HollywoodRegencyInterior" class="paid_feature_modal">Hollywood
                                                                        Regenc&nbsp;&#xf023;</option>
                                                                    <option id="HollywoodGlamInterior" class="paid_feature_modal">Hollywood
                                                                        Glam&nbsp;&#xf023;</option>
                                                                    <option id="MinimalistInterior" class="paid_feature_modal">
                                                                        Minimalist&nbsp;&#xf023;</option>
                                                                    <option id="ChristmasInterior" class="paid_feature_modal">
                                                                        Christmas&nbsp;&#xf023;</option>
                                                                    <option id="FuturisticInterior" class="paid_feature_modal">
                                                                        Futuristic&nbsp;&#xf023;</option>
                                                                    <option id="LuxuriousInterior" class="paid_feature_modal">
                                                                        Luxurious&nbsp;&#xf023;</option>
                                                                    <option id="MidCenturyInterior" class="paid_feature_modal">
                                                                        Midcentury modern&nbsp;&#xf023;</option>
                                                                    <option id="BiophilicInterior" class="paid_feature_modal">
                                                                        Biophilic&nbsp;&#xf023;</option>
                                                                    <option id="CottageCoreInterior" class="paid_feature_modal">
                                                                        Cottagecore&nbsp;&#xf023;</option>
                                                                    <option id="FrenchCountryInterior" class="paid_feature_modal">French
                                                                        Country&nbsp;&#xf023;</option>
                                                                    <option id="ArtDecoInterior" class="paid_feature_modal">
                                                                        Artdeco&nbsp;&#xf023;</option>
                                                                    <option id="ArtNouveauInterior" class="paid_feature_modal">Art
                                                                        nouveau&nbsp;&#xf023;</option>
                                                                    @else
                                                                    <option id="ShabbyChicInterior" value="ShabbyChic">
                                                                        Shabby Chic </option>
                                                                    <option id="CoastalInterior" value="Coastal">
                                                                        Coastal </option>
                                                                    <option id="BauhausInterior" value="Bauhaus">
                                                                        Bauhaus </option>
                                                                    <option id="BohoInterior" value="Boho">
                                                                        Bohemian</option>
                                                                    <option id="TraditionalInterior" value="Traditional">
                                                                        Traditional </option>
                                                                    <option id="RusticInterior" value="Rustic">
                                                                        Rustic</option>
                                                                    <option id="MinimalismInterior" value="Minimalism">
                                                                        Minimalism </option>
                                                                    <option id="JapandiInterior" value="Japandi">
                                                                        Japandi </option>
                                                                    <option id="JapaneseInterior" value="Japanese">Japanese design </option>
                                                                    <option id="BaliInterior" value="Bali">Bali
                                                                    </option>
                                                                    <option id="TropicalInterior" value="Tropical">Tropical </option>
                                                                    <option id="AsianDecorInterior" value="AsianDecor">
                                                                        Asian Decor </option>
                                                                    <option id="ZenInterior" value="Zen">Zen
                                                                    </option>
                                                                    <option id="HollywoodRegencyInterior" value="HollywoodRegency">
                                                                        Hollywood Regency</option>
                                                                    <option id="HollywoodGlamInterior" value="HollywoodGlam">
                                                                        Hollywood Glam </option>
                                                                    <option id="MinimalistInterior" value="Minimalist">
                                                                        Minimalist </option>
                                                                    <option id="ChristmasInterior" value="Christmas">Christmas </option>
                                                                    <option id="FuturisticInterior" value="Futuristic">
                                                                        Futuristic </option>
                                                                    <option id="LuxuriousInterior" value="Luxurious">Luxurious </option>
                                                                    <option id="MidCenturyInterior" value="MidCentury">
                                                                        Midcentury modern </option>
                                                                    <option id="BiophilicInterior" value="Biophilic">Biophilic </option>
                                                                    <option id="CottageCoreInterior" value="Cottage">Cottagecore </option>
                                                                    <option id="FrenchCountryInterior" value="FrenchCountry">
                                                                        French Country </option>
                                                                    <option id="ArtDecoInterior" value="Art Deco">
                                                                        Artdeco </option>
                                                                    <option id="ArtNouveauInterior" value="Art Nouveau">
                                                                        Art nouveau </option>
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">No Of Design</label>
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
                                                                {{-- <select class="nwfiles-optns" id="strength2">
                                                                    @include('web.designs_options.garden_ai')
                                                                </select> --}}
                                                                <br>
                                                                <div class="slider-container">
                                                                    <input type="range" min="25" max="100" step="25" value="75" class="form-range in-range slider strength"  id="rangeInput2">
                                                                    <label class="slider-tag"><span>Very Low</span><span>Low</span><span>Medium</span><span>Extreme</span></label>
                                                                    <input type="hidden" value="" class="hidden-input" id="strength3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        @if ($userActivePlan == 'free')
                                                        <label class="nw-tgtype" style="position:relative;">
                                                            Full HD Quality? <input type="checkbox" style="margin-left:5px;" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div style="position:absolute; left:0; right:0; top:0; bottom:0;" class="paid_feature_modal"></div>
                                                        </label>
                                                        @else
                                                        <label class="nw-tgtype">
                                                            Full HD Quality? <input type="checkbox" name="full_hd_0" style="margin-left:5px;" id="ck_full_hd_0" value="1">
                                                        </label>
                                                        @endif
                                                    </div>
                                                    <div class="nwchoice-toggle">
                                                        <span class="nw-tgtype">Private Gallery </span>
                                                        <input type="checkbox" id="nwtoggle0" onchange="loadRenders(0)" @checked($default_gallery=='public' )>
                                                        <label class="nwtoggle-label0" for="nwtoggle0">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                    @if(in_array($userActivePlan,['free','individual','homedesignsai-individual','homedesignsai-individual-2','individual-lifetime','individual-yearly']))
                                                    <div class="mt-3">
                                                        <label class="nw-tgtype ips-bf-parent">
                                                            Custom AI Instructions

                                                            <span class="tooltipnew" data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.
                                                            ">?</span>
                                                            <input type="checkbox" id="nwcust0" class="ms-1 ck_inst" onchange="customInstruction(0)" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    </div>
                                                    @else
                                                    <div class="mt-3">
                                                        <label class="nw-tgtype">
                                                            Custom AI Instructions

                                                            <span class="tooltipnew" data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.
                                                            ">?</span>
                                                            <input type="checkbox" id="nwcust0" class="ms-1 ck_inst" onchange="customInstruction(0)">
                                                        </label>
                                                    </div>
                                                    @endif
                                                    <div class="nwchoice-custom-instruction mt-2">
                                                        <textarea id="custom_instruction0" class="hidden_cust_field form-control" placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood." type="text" name="cust-inst0" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="nwupload-b0x">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg" src="{{ asset('web/images/') }}/generatevector.svg" alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 3:</strong>
                                                                Generate</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                            {{-- @if (auth()->check())
                                                <button class="nwfrm-submit _btn_gndeisgn" onclick="_generateDesign(0,this)">
                                                    Generate New Design
                                                </button>
                                            @else --}}
                                                <button class="nwfrm-submit" onclick="goTo('#buy')">
                                                    Generate New Design
                                                </button>
                                            {{-- @endif --}}
                                            <!--     <p
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
                        <div class="tab-pane fade" id="pills-exterior" role="tabpanel" aria-labelledby="pills-exterior-tab">
                            <div class="nwfrm-contentouter" id="forminterior1">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-6 col-md-6 order-mobile-top">
                                        <div class="nwfrm-comaparison">
                                            <h5 class="nwfrm-heading" id="jumphere1">Latest Designs</h5>
                                            <div class="cstmauto-scroll user_gallery_container" id="all_data1" data-sec-id="1">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 order-mobile-btm">
                                        <div class="nwfile-uploadside">
                                            <form>
                                                <div class="ribon-bx">
                                                    <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                    <div class="ribon-overlay">
                                                        <img class="nwstepimg" src="{{ asset('web/images/') }}/fillvector.svg" alt="" loading="lazy">
                                                        <span class="ribon-text"><strong>Step 1:</strong>
                                                            Upload
                                                            Image</span>
                                                    </div>
                                                </div>

                                                <div class="nwupload-bx @if (auth()->check()) img-upload-outer @endif" id="file-sectionbx1" data-section="1" onclick="@if (!auth()->check()) showLoginModal() @endif">
                                                    <input class="select-file @if (auth()->check()) dimg-picker @endif" type="file" id="fileselect1" style="display:none;" data-section="1">
                                                    <div class="fileselect-area">
                                                        <img src="{{ asset('web/images/') }}/fileselect.svg" id="uploadText1" alt="" loading="lazy">
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
                                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg" src="{{ asset('web/images/') }}/upload-vector.svg" alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 2:</strong>
                                                                Customize</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">House Angle <span class="tooltipnew" data-tooltip="Choose the angle of the
                                                                                house that you want to redesign. If your image is from
                                                                                the front of the house, choose accordingly.

                                                                                If the results are not good enough you can switch between
                                                                                the 3 options: front, side, back of the house.">?</span></label>
                                                                <select class="nwfiles-optns" id="roomType1">
                                                                    <option selected="" value="side">
                                                                        Side of house </option>
                                                                    <option value="front">
                                                                        Front of house </option>
                                                                    <option value="back">
                                                                        Back of house </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- file selection row -->
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Mode</label>
                                                                <select class="nwfiles-optns" id="modeType1">
                                                                    <option>Redesign</option>
                                                                    <option>Home Redesign</option>
                                                                    <option>Change Colors</option>
                                                                    <option>House Redesign</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Style</label>
                                                                <select class="nwfiles-optns" id="styleType1">
                                                                    <option id="ModernExterior" value="Modern">
                                                                        Modern
                                                                    </option>
                                                                    <option id="MediterraneanExterior" value="Mediterranean">
                                                                        Mediterranean
                                                                    </option>
                                                                    <option id="InternationalExterior" value="International">
                                                                        International </option>
                                                                    <option id="MoodyColorsExterior" value="Moody Colors">
                                                                        Moody Colors </option>
                                                                    <option id="WoodAccentsExterior" value="Wood Accents">
                                                                        Wood Accents </option>
                                                                    <option id="BohemianExterior" value="Bohemian">
                                                                        Bohemian </option>
                                                                    <option id="IndustrialExterior" value="Industrial">
                                                                        Industrial </option>
                                                                    <option id="RetreatExterior" value="Retreat">
                                                                        Retreat </option>
                                                                    <option id="ElegantExterior" value="Elegant">
                                                                        Elegant </option>
                                                                    <option id="PaintedBrickExterior" value="Painted Brick">
                                                                        Painted Brick </option>
                                                                    <option id="RedExterior" value="Red Brick">
                                                                        Red Brick </option>
                                                                    <option id="ModernBlendExterior" value="Modern Blend">
                                                                        Modern Blend </option>
                                                                    <option id="StoneCladExterior" value="Stone Clad">
                                                                        Stone Clad </option>
                                                                    <option id="GlassHouseExterior" value="Glass House">
                                                                        Glass House </option>
                                                                    <option id="RanchExterior" value="Ranch">
                                                                        Ranch </option>
                                                                    <option id="PortugueseExterior" value="Portuguese">
                                                                        Portuguese </option>
                                                                    <option id="TraditionalExterior" value="Traditional">
                                                                        Traditional </option>
                                                                    <option id="CraftsmanExterior" value="Craftsman">
                                                                        Craftsman </option>
                                                                    <option id="TudorExterior" value="Tudor">
                                                                        Tudor </option>
                                                                    <option id="PrairieExterior" value="Prairie">
                                                                        Prairie </option>
                                                                    <option id="ChaletExterior" value="Chalet">
                                                                        Chalet </option>
                                                                    <option id="ColonialExterior" value="Colonial">
                                                                        Colonial </option>
                                                                    <option id="DutchColonialExterior" value="Dutch Colonial">
                                                                        Dutch Colonial Revival </option>
                                                                    <option id="GeorgianExterior" value="Georgian">
                                                                        Georgian </option>
                                                                    <option id="GreenExterior" value="Green">
                                                                        Green </option>
                                                                    <option id="ContemporaryExterior" value="Contemporary">
                                                                        Contemporary </option>
                                                                    <option id="CottageExterior" value="Cottage">
                                                                        Cottage </option>
                                                                    <option id="FarmhouseExterior" value="Farmhouse">
                                                                        Farmhouse </option>
                                                                    <option id="FrenchCountryExterior" value="French Country">
                                                                        French Country </option>
                                                                    <option id="FuturisticExterior" value="Futuristic">
                                                                        Futuristic </option>
                                                                    <option id="GothicExterior" value="Gothic">
                                                                        Gothic </option>
                                                                    <option id="GreekRevivalExterior" value="Greek Revival">
                                                                        Greek Revival </option>
                                                                    <option id="MansionExterior" value="Mansion">
                                                                        Mansion </option>
                                                                    <option id="TownhouseExterior" value="Townhouse">
                                                                        Townhouse </option>
                                                                    <option id="VictorianExterior" value="Victorian">
                                                                        Victorian </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">No Of Design</label>
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
                                                                {{-- <select class="nwfiles-optns" id="strength2">
                                                                    @include('web.designs_options.garden_ai')
                                                                </select> --}}
                                                                <br>
                                                                <div class="slider-container">
                                                                    <input type="range" min="25" max="100" step="25" value="75" class="form-range in-range slider strength"  id="rangeInput2">
                                                                    <label class="slider-tag"><span>Very Low</span><span>Low</span><span>Medium</span><span>Extreme</span></label>
                                                                    <input type="hidden" value="" class="hidden-input" id="strength3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        @if ($userActivePlan == 'free')
                                                        <label class="nw-tgtype" style="position:relative;">
                                                            Full HD Quality? <input type="checkbox" style="margin-left:5px;" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div style="position:absolute; left:0; right:0; top:0; bottom:0;" class="paid_feature_modal"></div>
                                                        </label>
                                                        @else
                                                        <label class="nw-tgtype">
                                                            Full HD Quality? <input type="checkbox" name="full_hd_1" style="margin-left:5px;" id="ck_full_hd_1" value="1">
                                                        </label>
                                                        @endif
                                                    </div>
                                                    <div class="nwchoice-toggle">
                                                        <span class="nw-tgtype">Private Gallery</span>
                                                        <input type="checkbox" id="nwtoggle1" onchange="loadRenders(1)" @checked($default_gallery=='public' )>
                                                        <label class="nwtoggle-label1" for="nwtoggle1">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                    @if(in_array($userActivePlan,['free','individual','homedesignsai-individual','homedesignsai-individual-2','individual-lifetime','individual-yearly']))
                                                    <div class="mt-3">
                                                        <label class="nw-tgtype ips-bf-parent">
                                                            Custom AI Instructions
                                                            <span class="tooltipnew" data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.
                                                            ">?</span>
                                                            <input type="checkbox" id="nwcust1" class="ms-1 ck_inst" onchange="customInstruction(1)" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    </div>
                                                    @else
                                                    <div class="mt-3">
                                                        <label class="nw-tgtype">
                                                            Custom AI Instructions
                                                            <span class="tooltipnew" data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.
                                                            ">?</span>
                                                            <input type="checkbox" id="nwcust1" class="ms-1 ck_inst" onchange="customInstruction(1)">
                                                        </label>
                                                    </div>
                                                    @endif
                                                    <div class="nwchoice-custom-instruction mt-2">
                                                        <textarea id="custom_instruction1" class="hidden_cust_field form-control" placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood." type="text" name="cust-inst1" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="nwupload-b0x">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg" src="{{ asset('web/images/') }}/generatevector.svg" alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 3:</strong>
                                                                Generate</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                            {{-- @if (auth()->check())
                                            <button class="nwfrm-submit _btn_gndeisgn" onclick="_generateDesign(1,this)">
                                                Generate New Design
                                            </button>
                                            @else --}}
                                            <button class="nwfrm-submit" onclick="goTo('#buy')">
                                                Generate New Design
                                            </button>
                                            {{-- @endif --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-garden" role="tabpanel" aria-labelledby="pills-garden-tab">
                            <div class="nwfrm-contentouter" id="forminterior2">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-6 col-md-6 order-mobile-top">
                                        <div class="nwfrm-comaparison">
                                            <h5 class="nwfrm-heading" id="jumphere2">Latest Designs</h5>
                                            <div class="cstmauto-scroll user_gallery_container" id="all_data2" data-sec-id="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 order-mobile-btm">
                                        <div class="nwfile-uploadside">
                                            <form>
                                                <div class="ribon-bx">
                                                    <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                    <div class="ribon-overlay">
                                                        <img class="nwstepimg" src="{{ asset('web/images/') }}/fillvector.svg" alt="" loading="lazy">
                                                        <span class="ribon-text"><strong>Step 1:</strong>
                                                            Upload Image
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="nwupload-bx @if (auth()->check()) img-upload-outer @endif" id="file-sectionbx2" data-section="2" onclick="@if (!auth()->check()) showLoginModal() @endif">
                                                    <input class="select-file @if (auth()->check()) dimg-picker @endif" type="file" id="fileselect2" style="display:none;" data-section="2">
                                                    <div class="fileselect-area">
                                                        <img src="{{ asset('web/images/') }}/fileselect.svg" id="uploadText2" alt="" loading="lazy">
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
                                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg" src="{{ asset('web/images/') }}/upload-vector.svg" alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 2:</strong>
                                                                Customize</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Garden Type <span class="tooltipnew" data-tooltip="Choose which type of
                                                                                outdoor you have uploaded. For best results switch
                                                                                between the options to get the best results.">?</span></label>
                                                                <select class="nwfiles-optns" id="roomType2">
                                                                    <option selected="" value="Backyard">
                                                                        Backyard </option>
                                                                    <option value="patio">
                                                                        Patio </option>
                                                                    <option value="Terrace">
                                                                        Terrace </option>
                                                                    <option value="Front Yard">
                                                                        Front Yard </option>
                                                                    <option value="garden">
                                                                        Garden </option>
                                                                    <option value="Courtyard">
                                                                        Courtyard </option>
                                                                    <option value="Pool Area">
                                                                        Pool Area </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- file selection row -->
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Mode</label>
                                                                <select class="nwfiles-optns" id="modeType2">
                                                                    <option>Redesign</option>
                                                                    <option>Fill The Garden</option>
                                                                    <!-- <option>Empty The Room</option> -->
                                                                    <option>Change Colors</option>
                                                                    <option>Garden Mix</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-md-12 p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">Style</label>
                                                                <select class="nwfiles-optns" id="styleType2">
                                                                    <option id="Modern_Garden" value="Modern Garden">
                                                                        Modern </option>
                                                                    <option id="City_Garden" value="City Garden">
                                                                        City </option>
                                                                    <option id="Contemporary_Garden" value="Contemporary
                                                                        Garden">
                                                                        Contemporary </option>
                                                                    <option id="Luxury_Garden" value="Luxury Garden">
                                                                        Luxury </option>
                                                                    <option id="Apartment_Garden" value="Apartment Garden">
                                                                        Apartment </option>
                                                                    <option id="Small_Garden" value="Small Garden">
                                                                        Small </option>
                                                                    <option id="Vegetable_Garden" value="Vegetable Garden">
                                                                        Vegetable </option>
                                                                    <option id="Low__Budget_Garden" value="Low Budget Garden">
                                                                        Low Budget </option>
                                                                    <option id="Beach_Garden" value="Beach Garden">
                                                                        Beach </option>
                                                                    <option id="Wedding_Garden" value="Wedding Garden">
                                                                        Wedding </option>
                                                                    <option id="Rural_Garden" value="Rural Garden">
                                                                        Rural Garden </option>
                                                                    <option id="Restaurant_Garden" value="Restaurant Garden">
                                                                        Restaurant Garden </option>
                                                                    <option id="Mediterranean_Garden" value="Mediterranean
                                                                        Garden">
                                                                        Mediterranean </option>
                                                                    <option id="Formal_Garden" value="Formal Garden">
                                                                        Formal </option>
                                                                    <option id="American_Garden" value="American Garden">
                                                                        American </option>
                                                                    <option id="English_Garden" value="English Garden">
                                                                        English </option>
                                                                    <option id="Traditional_Green" value="Traditional Garden">
                                                                        Traditional </option>
                                                                    <option id="Cottage_Garden" value="Cottage Garden">
                                                                        Cottage </option>
                                                                    <option id="Meditation_Garden" value="Meditation Garden">
                                                                        Meditation </option>
                                                                    <option id="Coastal_Garden" value="Coastal Garden">
                                                                        Coastal </option>
                                                                    <option id="Tropical_Garden" value="Tropical Garden">
                                                                        Tropical </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col p-0">
                                                            <div class="nwchoosebx">
                                                                <label class="nwfile-tiTle">No Of Design</label>
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
                                                                    <input type="range" min="25" max="100" step="25" value="75" class="form-range in-range slider strength"  id="rangeInput2">
                                                                    <label class="slider-tag"><span>Very Low</span><span>Low</span><span>Medium</span><span>Extreme</span></label>
                                                                    <input type="hidden" value="" class="hidden-input" id="strength3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        @if ($userActivePlan == 'free')
                                                        <label class="nw-tgtype" style="position:relative;">
                                                            Full HD Quality? <input type="checkbox" style="margin-left:5px;" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div style="position:absolute; left:0; right:0; top:0; bottom:0;" class="paid_feature_modal"></div>
                                                        </label>
                                                        @else
                                                        <label class="nw-tgtype">
                                                            Full HD Quality? <input type="checkbox" name="full_hd_2" style="margin-left:5px;" id="ck_full_hd_2" value="1">
                                                        </label>
                                                        @endif
                                                    </div>
                                                    <div class="nwchoice-toggle">
                                                        <span class="nw-tgtype">Private Gallery</span>
                                                        <input type="checkbox" id="nwtoggle2" onchange="loadRenders(2)" @checked($default_gallery=='public' )>
                                                        <label class="nwtoggle-label2" for="nwtoggle2">Toggle</label>
                                                        <span class="nw-tgtype">Public Gallery</span>
                                                    </div>
                                                    @if(in_array($userActivePlan,['free','individual','homedesignsai-individual','homedesignsai-individual-2','individual-lifetime','individual-yearly']))
                                                    <div class="mt-3">
                                                        <label class="nw-tgtype ips-bf-parent">
                                                            Custom AI Instructions
                                                            <span class="tooltipnew" data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.
                                                            ">?</span>
                                                            <input type="checkbox" id="nwcust2" class="ms-1 ck_inst" onchange="customInstruction(2)" disabled>
                                                            <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                            <div class="ips-bf-child paid_feature_modal"></div>
                                                        </label>
                                                    </div>
                                                    @else
                                                    <div class="mt-3">
                                                        <label class="nw-tgtype">
                                                            Custom AI Instructions
                                                            <span class="tooltipnew" data-tooltip="Add personalized instructions for the AI to follow, such as preferred colors, textures, or furniture types. Use this feature to provide specific details about your desired design outcome.

                                                            Note: This feature is still in BETA and results might be inconsistent.
                                                            ">?</span>
                                                            <input type="checkbox" id="nwcust2" class="ms-1 ck_inst" onchange="customInstruction(2)">
                                                        </label>
                                                    </div>
                                                    @endif
                                                    <div class="nwchoice-custom-instruction mt-2">
                                                        <textarea id="custom_instruction2" class="hidden_cust_field form-control" placeholder="e.g. A clean-looking living room with black and yellow textures and a coffee table made from hardwood." type="text" name="cust-inst2" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="nwupload-b0x">
                                                    <div class="ribon-bx">
                                                        <img class="nwribon" src="{{ asset('web/images/') }}/ribon.png" alt="" loading="lazy">
                                                        <div class="ribon-overlay">
                                                            <img class="nwstepimg" src="{{ asset('web/images/') }}/generatevector.svg" alt="" loading="lazy">
                                                            <span class="ribon-text"><strong>Step 3:</strong>
                                                                Generate</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                            {{-- @if (auth()->check())
                                            <button class="nwfrm-submit _btn_gndeisgn" onclick="_generateDesign(2,this)">
                                                Generate New Design
                                            </button>
                                            @else --}}
                                            <button class="nwfrm-submit" onclick="goTo('#buy')">
                                                Generate New Design
                                            </button>
                                            {{-- @endif --}}
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
</section>

@include('web.common.design-preview')
