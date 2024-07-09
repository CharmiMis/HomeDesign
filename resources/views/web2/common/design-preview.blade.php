<!-- Modal -->
<div class="modal fade gs-modal-background" id="modalImagePreview" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog gs-modal-container">
        <div class="modal-content gs-modal-content">
            <button type="button" class="gs-modal-close" data-dismiss="modal">
                <img src="{{ asset('web2/images/gs-close-icon.svg') }}">
            </button>
            <div class="gs-image-editing-slide-outer">
                <div class="gs-image-editing-slide">
                    <div class="gs-image-editing-slide-row">
                        <div class="ba-Slider" unselectable='on' onselectstart='return false;'
                            onmousedown='return false;'>
                            <div id="before" class="gs-image-editing-before">
                                <img src="" id="mip_before" />
                            </div>
                            <div class="slider"></div>
                            <div id="after" class="gs-image-editing-after">
                                <img src="" id="mip_after" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
