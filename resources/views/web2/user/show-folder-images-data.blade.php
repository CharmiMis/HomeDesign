@php
    $startIndex = ($designs->currentPage() - 1) * $designs->perPage();
@endphp
@forelse ($designs as $key => $value)
    <div class="ai-upload-latest-single" data-image-id="{{ $value->id }}">
        <div class="ai-upload-latest-before">
            <div class="ai-upload-latest-inset">
                <span class="ai-upload-title">Before</span>
                <img class="img" src="{{ $value->publicGallery->original_image }}" data-item="input-image">
                <div class="ai-upload-optons">
                    <ul>
                        <li class="ai-upload-add-project-list">
                            <span class="ai-upload-option-tooltip"> Download </span>
                            <a class="download" href="javascript:void(0)" data-download-url="{{ $value->publicGallery->original_image }}" title="Download" download
                                data-item="download-btn"><img
                                    src="{{ asset('web2/images/ai-upload-optons-icon1.svg') }}"></a>
                        </li>
                        <li class="ai-upload-add-project-list">
                            <span class="ai-upload-option-tooltip"> Show </span>
                            <a class="ip_img_preview inpainting-preview" href="javascript:void(0)" data-img="{{ $value->publicGallery->original_image }}"
                                data-item="preview-btn" title="Open" onclick="previewImage('{{ $value->publicGallery->original_image }}')">
                                <img src="{{ asset('web2/images/ai-upload-optons-icon2.svg') }}">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="ai-upload-latest-after">
            <div class="ai-upload-latest-inset">
                <div class="ai-upload-selection">
                    @if($value->publicGallery->hd_image == 1)
                        <div class="ai-upload-favourite">
                            <img class="hd_image" src="/web/images/hd_icon.png" alt="">
                        </div>
                    @endif
                </div>
                <span class="ai-upload-title">After</span>
                <img class="complte-img img" src="{{ $value->publicGallery->generated_image }}" data-item="output-image">
                @if($value->publicGallery->is_inpainting == 0 || $value->publicGallery->is_inpainting == 1 || $value->publicGallery->is_inpainting == 2 || $value->publicGallery->is_inpainting == 3)
                    <div class="ai-upload-effects">
                        <ul class="render-overlay-data-box">
                            @if ($value->publicGallery->style != null && $value->publicGallery->style != '' && $value->publicGallery->style != 'N/A')
                                <li class="render-overlay-data">Design Style: {{ $value->publicGallery->style }}</li>
                            @endif
                            @if ($value->publicGallery->room_type != null && $value->publicGallery->room_type != '' && $value->publicGallery->room_type != 'N/A')
                                @if($value->publicGallery->design_type == 1)
                                    <li class="render-overlay-data">House Angle: {{ $value->publicGallery->room_type }}</li>
                                @elseif($value->publicGallery->design_type == 2)
                                    <li class="render-overlay-data">Garden Type: {{ $value->publicGallery->room_type }}</li>
                                @else
                                    <li class="render-overlay-data">Room Type: {{ $value->publicGallery->room_type }}</li>
                                @endif
                            @endif
                            @if ($value->publicGallery->mode != null && $value->publicGallery->mode != '' && $value->publicGallery->is_inpainting == 0)
                                <li class="render-overlay-data">Mode Type: {{ $value->publicGallery->mode }}</li>
                            @endif
                        </ul>
                    </div>
                @endif
                <div class="ai-upload-optons">
                    <ul>
                        <li class="ai-upload-add-project-list">
                            <span class="ai-upload-option-tooltip"> Download </span>
                            <a class="download" href="javascript:void(0)" data-download-url="{{ $value->publicGallery->generated_image }}" title="Download" download
                                data-item="download-btn"><img
                                    src="{{ asset('web2/images/ai-upload-optons-icon1.svg') }}"></a>
                        </li>
                        <li class="ai-upload-add-project-list">
                            <span class="ai-upload-option-tooltip"> Show </span>
                            <a class="ip_img_preview inpainting-preview" href="javascript:void(0)" data-img="{{ $value->publicGallery->generated_image }}"
                                data-item="preview-btn" title="Open" onclick="previewImage('{{ $value->publicGallery->generated_image }}')">
                                <img src="{{ asset('web2/images/ai-upload-optons-icon2.svg') }}">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@empty
<h5 style="text-align:center">There is no Image in this project!</h5>
@endforelse
@if ($designs->hasPages())
    <tfoot class="table-border-bottom-0">
        <tr>
            <td colspan="3" class="ps-0">
                {{ $designs->appends(request()->query())->links('web2.vendor.pagination.sneat') }}
            </td>
        </tr>
    </tfoot>
@endif
