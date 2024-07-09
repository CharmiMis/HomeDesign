<template id="inPaintingCard">
<div class="col-md-6 col-lg-4 col-12">
    <div class="ai-upload-latest-single">
        <div class="ai-upload-latest-after">
            <div class="ai-upload-latest-inset">
                <div class="ai-upload-selection">
                    <div class="ai-upload-favourite hd_image_div">
                        <img class="hd_image" src="{{ asset('web/images/hd_icon.png') }}" alt="">
                    </div>
                </div>
                <img class="complte-img img" src="" data-item="output-image">
                <div class="ai-upload-effects">
                    <ul class="render-overlay-data-box">
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
                            <a class="full_hd_quality" href="javascript:void(0)" data-img="" data-sec=""
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
