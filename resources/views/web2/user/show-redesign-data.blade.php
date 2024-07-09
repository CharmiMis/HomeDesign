@php
    $startIndex = ($designs->currentPage() - 1) * $designs->perPage();
@endphp
@forelse ($designs as $key => $value)
<div class="col-md-6 col-lg-4 col-12">
    <div class="ai-upload-latest-single" data-image-id="{{ $value->id }}">
        <div class="ai-upload-latest-after">
            <div class="ai-upload-latest-inset">
                <div class="ai-upload-selection">
                    @if($value->hd_image == 1)
                        <div class="ai-upload-favourite">
                            <img class="hd_image" src="/web/images/hd_icon.png" alt="">
                        </div>
                    @endif
                </div>
                {{-- <span class="ai-upload-title">After</span> --}}
                <img class="complte-img img" src="{{ $value->generated_image }}" data-item="output-image">
                @if($value->is_inpainting == 0 || $value->is_inpainting == 1 || $value->is_inpainting == 2 || $value->is_inpainting == 3)
                    <div class="ai-upload-effects">
                        <ul class="render-overlay-data-box">
                            @if ($value->style != null && $value->style != '' && $value->style != 'N/A')
                                <li class="render-overlay-data">Design Style: {{ $value->style }}</li>
                            @endif
                            @if ($value->room_type != null && $value->room_type != '' && $value->room_type != 'N/A')
                                @if($value->design_type == 1)
                                    <li class="render-overlay-data">House Angle: {{ $value->room_type }}</li>
                                @elseif($value->design_type == 2)
                                    <li class="render-overlay-data">Garden Type: {{ $value->room_type }}</li>
                                @else
                                    <li class="render-overlay-data">Room Type: {{ $value->room_type }}</li>
                                @endif
                            @endif
                            @if ($value->mode != null && $value->mode != '' && $value->mode != 'N/A')
                                <li class="render-overlay-data">Mode Type: {{ $value->mode }}</li>
                            @endif
                        </ul>
                    </div>
                @endif
                <div class="ai-upload-optons">
                    <ul>
                        <li class="ai-upload-add-project-list">
                            <span class="ai-upload-option-tooltip"> Download </span>
                            <a class="download" href="javascript:void(0)" data-download-url="{{ $value->generated_image }}" title="Download" download
                                data-item="download-btn"><img
                                    src="{{ asset('web2/images/ai-upload-optons-icon1.svg') }}"></a>
                        </li>
                        <li class="ai-upload-add-project-list">
                            <span class="ai-upload-option-tooltip"> Show </span>
                            <a class="ip_img_preview inpainting-preview" href="javascript:void(0)" data-img="{{ $value->generated_image }}"
                                data-item="preview-btn" title="Open" onclick="previewImage('{{ $value->original_image }}','{{ $value->generated_image }}')">
                                <img src="{{ asset('web2/images/ai-upload-optons-icon2.svg') }}">
                            </a>
                        </li>
                        @if($value->hd_image == 0)
                            <li class="ai-upload-add-project-list on-gen-disable">
                                <span class="ai-upload-option-tooltip"> HD </span>
                                <a class="generate_hd_img" href="javascript:void(0)" data-input-img="{{ $value->original_image }}" data-img="{{ $value->generated_image }}"
                                        title="Full Hd Quality" data-sec="{{ $value->design_type }}">
                                    <img src="{{ asset('web2/images/gs-image-editing-slide-icon8.svg') }}">
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<h5 style="text-align:center">No images generated yet. Generate now to see your gallery.</h5>
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
