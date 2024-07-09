@foreach ($designs as $design)
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="render-img-bx fadeIn">
                <img class="rendered-img" src="{{ $design->original_image }}" alt="" loading="lazy">
                <div class="downld-bx">
                    <div class="sharetab sharetab-buttons share text-center"
                        onclick="previewImage('{{ $design->original_image }}')" title="Open">
                        <img src="/web/images/magnifying1.svg" alt="" loading="lazy">
                        <span>Show</span>
                    </div>
                    <a class="sharetab sharetab-buttons download" href="javascript:void(0)"
                        data-download-url="{{ $design->original_image }}" title="Download" download>
                        <img src="/web/images/download1-hover.svg" alt="" loading="lazy">
                        <span>Download</span>
                    </a>
                    @if ($design->show_data)
                        @if ($design->showHdButton)
                            @if ($design->precisionUpUser == 'true')
                                <div class="sharetab sharetab-buttons full_hd_quality share text-center"
                                    onclick="showUpdateModal()" data-img="{{ $design->original_image }}"
                                    data-sec="{{ $design->section }}" title="Full Hd Quality">
                                    <img src="/web/images/hd1.svg">
                                    <span>HD</span>
                                </div>
                            @else
                                <div class="sharetab sharetab-buttons full_hd_quality generate_hd_img share text-center"
                                    data-img="{{ $design->original_image }}" data-sec="{{ $design->section }}"
                                    title="Full Hd Quality">
                                    <img src="/web/images/hd1.svg">
                                    <span>HD</span>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
                <div class="render-overlay-box">
                    <span class="render-overlay">Before</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="render-img-bx fadeIn">
                <img class="rendered-img" src="{{ $design->generated_image }}" alt="" loading="lazy">
                <div class="downld-bx">
                    <div class="sharetab sharetab-buttons share text-center"
                        onclick="previewImage('{{ $design->generated_image }}')" title="Open">
                        <img src="/web/images/magnifying1.svg" alt="" loading="lazy">
                        <span>Show</span>
                    </div>
                    <a class="sharetab sharetab-buttons download" href="javascript:void(0)"
                        data-download-url="{{ $design->generated_image }}" title="Download" download>
                        <img src="/web/images/download1-hover.svg" alt="" loading="lazy">
                        <span>Download</span>
                    </a>
                    @if ($design->show_data)
                        @if ($design->showHdButton)
                            @if ($design->precisionUpUser == 'true')
                                <div class="sharetab sharetab-buttons full_hd_quality share text-center"
                                    onclick="showUpdateModal()" data-img="{{ $design->generated_image }}"
                                    data-sec="{{ $design->section }}" title="Full Hd Quality">
                                    <img src="/web/images/hd1.svg">
                                    <span>HD</span>
                                </div>
                            @else
                                <div class="sharetab sharetab-buttons full_hd_quality generate_hd_img share text-center"
                                    data-img="{{ $design->generated_image }}" data-sec="{{ $design->section }}"
                                    title="Full Hd Quality">
                                    <img src="/web/images/hd1.svg">
                                    <span>HD</span>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
                <div class="chkimg imgcheck">
                    <input type="checkbox" class="ml_dw_img"
                        onclick="getMultipleImages('{{ $design->generated_image }}')" />
                </div>
                <div class="render-overlay-box">
                    <span class="render-overlay">After</span>
                    <span class="render-overlay">Style: {{ $design->style }}</span>
                    @if ($design->room_type != null && $design->room_type != '')
                        <span class="render-overlay">Room Type: {{ $design->room_type }}</span>
                    @endif
                    @if ($design->mode != null && $design->mode != '')
                        <span class="render-overlay">Mode: {{ $design->mode }}</span>
                    @endif
                </div>
            </div>
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
