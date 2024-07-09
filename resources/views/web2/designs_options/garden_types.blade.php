<div class="modal fade gs-modal-background" id="view_all_garden_type" role="dialog">
    <div class="modal-dialog gs-modal-container">
        <div class="modal-content gs-modal-content">
            <button type="button" class="gs-modal-close" data-dismiss="modal"><img
                    src="{{ asset('web2/images/gs-close-icon.svg') }}"></button>
            <h3>All Garden Type </h3>
            <div class="gs-select-room-style-row" id="allRoomTypes2">
                <div class="gs-select-room-style-single" data-room-type="Backyard" onclick="selectRoomType('Backyard',2)">
                    <img src="{{ asset('web2/images/select-room-type1.png') }}">
                    <span>Backyard</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Patio" onclick="selectRoomType('Patio',2)">
                    <img src="{{ asset('web2/images/select-room-type2.png') }}">
                    <span>Patio</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Terrace" onclick="selectRoomType('Terrace',2)">
                    <img src="{{ asset('web2/images/select-room-type3.png') }}">
                    <span>Terrace</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Front Yard" onclick="selectRoomType('Front Yard',2)">
                    <img src="{{ asset('web2/images/select-room-type4.png') }}">
                    <span>Front Yard</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Garden" onclick="selectRoomType('Garden',2)">
                    <img src="{{ asset('web2/images/select-room-type5.png') }}">
                    <span>Garden</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Courtyard" onclick="selectRoomType('Courtyard',2)">
                    <img src="{{ asset('web2/images/select-room-type6.png') }}">
                    <span>Courtyard</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Pool Area" onclick="selectRoomType('Pool Area',2)">
                    <img src="{{ asset('web2/images/select-room-type7.png') }}">
                    <span>Pool Area</span>
                </div>
                @if($userActivePlan == 'free' || empty($crossShellPlan) || !in_array('Extra Rooms', $crossShellPlan))
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Porch">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Porch</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Playground">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Playground</span>
                    </div>
                @else
                    <div class="gs-select-room-style-single" data-room-type="Porch" onclick="selectRoomType('Porch',2)">
                        <img src="{{ asset('web2/images/select-room-type7.png') }}">
                        <span>Porch</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Playground" onclick="selectRoomType('Playground',2)">
                        <img src="{{ asset('web2/images/select-room-type7.png') }}">
                        <span>Playground</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
