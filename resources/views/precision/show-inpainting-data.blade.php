    @foreach ($designs as $key => $value)
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3 mb-3">
            <div class="in-painting-card">
                <img class="img" src="{{ $value->generated_image }}" data-item="image">
                <div class="card-options">
                    <div class="inpainting-btn">
                        <div class="sharetab sharetab-buttons share text-center ip_img_preview inpainting-preview"
                            data-img="{{ $value->generated_image }}" data-item="preview-btn" title="Open">
                            <img src="/web/images/magnifying1.svg">
                            <span>Show</span>
                        </div>
                        <a class="sharetab sharetab-buttons download" href="javascript:void(0)" data-download-url="{{ $value->generated_image }}" title="Download" download>
                            <img class="hover_img" src="/web/images/download1-hover.svg">
                            <span>Download</span>
                        </a>
                        
                        <div>
                            <a class="sharetab sharetab-buttons use-as-input-image"
                                data-img="{{ $value->generated_image }}" href="javascript:void(0)" title="Use as Input">
                                <img src="/web/images/input1.svg" alt="" loading="lazy">
                                <span>Input</span>
                            </a>
                        </div>
                        
                       
                    </div>
                </div>
                @if($value->is_inpainting == 1 || $value->is_inpainting == 2 || $value->is_inpainting == 3)
                    <div class="render-overlay-box">
                        @if ($value->style != null && $value->style != '')
                            <span class="render-overlay">Style: {{ $value->style }}</span>
                        @endif
                        @if ($value->room_type != null && $value->room_type != '')
                            <span class="render-overlay">Room Type: {{ $value->room_type }}</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    @if ($designs->hasPages())
        <tfoot class="table-border-bottom-0">
            <tr>
                <td colspan="3" class="ps-0">
                    {{ $designs->appends(request()->query())->links('web.vendor.pagination.sneat') }}
                </td>
            </tr>
        </tfoot>
    @endif
