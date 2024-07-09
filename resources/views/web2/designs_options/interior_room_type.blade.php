<div class="modal fade gs-modal-background" id="view_all_interior_room_type" role="dialog">
    <div class="modal-dialog gs-modal-container">
        <div class="modal-content gs-modal-content">
            <button type="button" class="gs-modal-close" data-dismiss="modal"><img
                    src="{{ asset('web2/images/gs-close-icon.svg') }}"></button>
            <h3>All Room Types</h3>
            <div class="gs-select-room-style-row" id="allRoomTypes0">
                <div class="gs-select-room-style-single" data-room-type="Living Room"
                    onclick="selectRoomType('Living Room',0)">
                    <img src="{{ asset('web2/images/select-room-type1.png') }}">
                    <span>Living Room</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Bedroom"
                    onclick="selectRoomType('Bedroom',0)">
                    <img src="{{ asset('web2/images/select-room-type2.png') }}">
                    <span>Bedroom</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Bathroom"
                    onclick="selectRoomType('Bathroom',0)">
                    <img src="{{ asset('web2/images/select-room-type3.png') }}">
                    <span>Bathroom</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Kitchen"
                    onclick="selectRoomType('Kitchen',0)">
                    <img src="{{ asset('web2/images/select-room-type4.png') }}">
                    <span>Kitchen</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Dining Room"
                    onclick="selectRoomType('Dining Room',0)">
                    <img src="{{ asset('web2/images/select-room-type5.png') }}">
                    <span>Dining Room</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Attic"
                    onclick="selectRoomType('Attic',0)">
                    <img src="{{ asset('web2/images/select-room-type6.png') }}">
                    <span>Attic</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Study Room"
                    onclick="selectRoomType('Study Room',0)">
                    <img src="{{ asset('web2/images/select-room-type7.png') }}">
                    <span>Study Room</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Home Office"
                    onclick="selectRoomType('Home Office',0)">
                    <img src="{{ asset('web2/images/select-room-type8.png') }}">
                    <span>Home Office</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Family Room"
                    onclick="selectRoomType('Family Room',0)">
                    <img src="{{ asset('web2/images/select-room-type9.png') }}">
                    <span>Family Room</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Formal Dining Room"
                    onclick="selectRoomType('Formal Dining Room',0)">
                    <img src="{{ asset('web2/images/select-room-type10.png') }}">
                    <span>Formal Dining Room</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Kids Room"
                    onclick="selectRoomType('Kids Room',0)">
                    <img src="{{ asset('web2/images/select-room-type11.png') }}">
                    <span>Kids Room</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Balcony"
                    onclick="selectRoomType('Balcony',0)">
                    <img src="{{ asset('web2/images/select-room-type1.png') }}">
                    <span>Balcony</span>
                </div>
                <div class="gs-select-room-style-single" data-room-type="Gaming Room"
                    onclick="selectRoomType('Gaming Room',0)">
                    <img src="{{ asset('web2/images/select-room-type2.png') }}">
                    <span>Gaming Room</span>
                </div>
                @if ($userActivePlan == 'free')
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Meeting Room">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Meeting Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Workshop">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Workshop</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Fitness Gym">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Fitness Gym</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Coffee Shop">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Coffee Shop</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Clothing Store">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Clothing Store</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Restaurant">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Restaurant</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Office">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Office</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Coworking Space">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Coworking Space</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Hotel Lobby">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Hotel Lobby</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Hotel Room">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Hotel Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Hotel Bathroom">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Hotel Bathroom</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Exhibition Space">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Exhibition Space</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Onsen">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Onsen</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Working Space">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Working Space</span>
                    </div>
                @else
                    <div class="gs-select-room-style-single" data-room-type="Workshop"
                        onclick="selectRoomType('Workshop',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Workshop</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Meeting Room"
                        onclick="selectRoomType('Meeting Room',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Meeting Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Fitness Gym"
                        onclick="selectRoomType('Fitness Gym',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Fitness Gym</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Coffee Shop"
                        onclick="selectRoomType('Coffee Shop',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Coffee Shop</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Clothing Store"
                        onclick="selectRoomType('Clothing Store',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Clothing Store</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Restaurant"
                        onclick="selectRoomType('Restaurant',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Restaurant</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Office"
                        onclick="selectRoomType('Office',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Office</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Coworking Space"
                        onclick="selectRoomType('Coworking Space',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Coworking Space</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="hotel Lobby"
                        onclick="selectRoomType('hotel Lobby',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Hotel Lobby</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Hotel Room"
                        onclick="selectRoomType('Hotel Room',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Hotel Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Hotel Bathroom"
                        onclick="selectRoomType('Hotel Bathroom',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Hotel Bathroom</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Exhibition Space"
                        onclick="selectRoomType('Exhibition Space',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Exhibition Space</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Onsen"
                        onclick="selectRoomType('Onsen',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Onsen</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Working Space"
                        onclick="selectRoomType('Working Space',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Working Space</span>
                    </div>
                @endif
                @if($precisionUser == true)
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Wine Cellar">
                        <img src="{{ asset('web2/images/select-room-type4.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Wine Cellar</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Rooftop Terrace">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Rooftop Terrace</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Sunroom">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Sunroom</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Home Spa">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Home Spa</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Mudroom">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Mudroom</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Craft Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Craft Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Dressing Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Dressing Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Guest Bedroom">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Guest Bedroom</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Home Bar">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Home Bar</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Library">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Library</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Art Studio">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Art Studio</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Yoga Studio">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Yoga Studio</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Photo Studio">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Photo Studio</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Multimedia Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Multimedia Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Auditorium">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Auditorium</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Medical Exam Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Medical Exam Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Reception Area">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Reception Area</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Music Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Music Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Science Laboratory">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Science Laboratory</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_feature_modal" data-room-type="Home Theater">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Home Theater</span>
                    </div>
                @else
                    <div class="gs-select-room-style-single" data-room-type="Wine Cellar"
                        onclick="selectRoomType('wine Cellar',0)">
                        <img src="{{ asset('web2/images/select-room-type4.png') }}">
                        <span>Wine Cellar</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Rooftop Terrace"
                        onclick="selectRoomType('Rooftop Terrace',0)">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <span>Rooftop Terrace</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Sunroom"
                        onclick="selectRoomType('Sunroom',0)">
                        <img src="{{ asset('web2/images/select-room-type6.png') }}">
                        <span>Sunroom</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Home Spa"
                        onclick="selectRoomType('Home Spa',0)">
                        <img src="{{ asset('web2/images/select-room-type7.png') }}">
                        <span>Home Spa</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Mudroom"
                        onclick="selectRoomType('Mudroom',0)">
                        <img src="{{ asset('web2/images/select-room-type8.png') }}">
                        <span>Mudroom</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Craft Room"
                        onclick="selectRoomType('Craft Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Craft Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Dressing Room"
                        onclick="selectRoomType('Dressing Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Dressing Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Guest Bedroom"
                        onclick="selectRoomType('Guest Bedroom',0)">
                        <img src="{{ asset('web2/images/select-room-type10.png') }}">
                        <span>Guest Bedroom</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Home Bar"
                        onclick="selectRoomType('Home Bar',0)">
                        <img src="{{ asset('web2/images/select-room-type11.png') }}">
                        <span>Home Bar</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Library"
                        onclick="selectRoomType('Library',0)">
                        <img src="{{ asset('web2/images/select-room-type1.png') }}">
                        <span>Library</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Art Studio"
                        onclick="selectRoomType('Art Studio',0)">
                        <img src="{{ asset('web2/images/select-room-type2.png') }}">
                        <span>Art Studio</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Yoga Studio"
                        onclick="selectRoomType('Yoga Studio',0)">
                        <img src="{{ asset('web2/images/select-room-type3.png') }}">
                        <span>Yoga Studio</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Photo Studio"
                        onclick="selectRoomType('Photo Studio',0)">
                        <img src="{{ asset('web2/images/select-room-type4.png') }}">
                        <span>Photo Studio</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Multimedia Room"
                        onclick="selectRoomType('Multimedia Room',0)">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <span>Multimedia Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Auditorium"
                        onclick="selectRoomType('Auditorium',0)">
                        <img src="{{ asset('web2/images/select-room-type6.png') }}">
                        <span>Auditorium</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Medical Exam Room"
                        onclick="selectRoomType('Medical Exam Room',0)">
                        <img src="{{ asset('web2/images/select-room-type7.png') }}">
                        <span>Medical Exam Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Reception Area"
                        onclick="selectRoomType('Reception Area',0)">
                        <img src="{{ asset('web2/images/select-room-type8.png') }}">
                        <span>Reception Area</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Music Room"
                        onclick="selectRoomType('Music Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Music Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Science Laboratory"
                        onclick="selectRoomType('Science Laboratory',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Science Laboratory</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Home Theater"
                        onclick="selectRoomType('Home Theater',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Home Theater</span>
                    </div>
                @endif
                @if($userActivePlan == 'free' || empty($crossShellPlan) || !in_array('Extra Rooms', $crossShellPlan))
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Wedding Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Wedding Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Laundry Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Laundry Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Outdoor Kitchen">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Outdoor Kitchen</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Utility Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Utility Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Pet Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Pet Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Home Gym">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Home Gym</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Lounge">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Lounge</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Walk-in Closet">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Walk-in Closet</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Playroom">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Playroom</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Reading Nook">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Reading Nook</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Sauna">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Sauna</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Man Cave">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Man Cave</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Foyer">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Foyer</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Greenhouse">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Greenhouse</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="She Shed">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>She Shed</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Conservatory">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Conservatory</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Nursery">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Nursery</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Prayer Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Prayer Room</span>
                    </div>
                    <div class="gs-select-room-style-single premium_feature_types paid_roomtype_feature_modal" data-room-type="Open Kitchen Living Room">
                        <img src="{{ asset('web2/images/select-room-type5.png') }}">
                        <img class="premium_lock_icons" src="{{ asset('web2/images/gs-prompt-lock-icon.svg') }}">
                        <span>Open Kitchen Living Room</span>
                    </div>
                @else
                    <div class="gs-select-room-style-single" data-room-type="Wedding Room"
                        onclick="selectRoomType('Wedding Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Wedding Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Laundry Room"
                        onclick="selectRoomType('Laundry Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Laundry Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Outdoor Kitchen"
                        onclick="selectRoomType('Outdoor Kitchen',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Outdoor Kitchen</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Utility Room"
                        onclick="selectRoomType('Utility Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Utility Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Pet Room"
                        onclick="selectRoomType('Pet Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Pet Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Home Gym"
                        onclick="selectRoomType('Home Gym',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Home Gym</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Lounge"
                        onclick="selectRoomType('Lounge',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Lounge</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Walk-in Closet"
                        onclick="selectRoomType('Walk-in Closet',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Walk-in Closet</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Playroom"
                        onclick="selectRoomType('Playroom',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Playroom</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Reading Nook"
                        onclick="selectRoomType('Reading Nook',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Reading Nook</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Sauna"
                        onclick="selectRoomType('Sauna',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Sauna</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Man Cave"
                        onclick="selectRoomType('Man Cave',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Man Cave</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Foyer"
                        onclick="selectRoomType('Foyer',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Foyer</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Greenhouse"
                        onclick="selectRoomType('Greenhouse',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Greenhouse</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="She Shed"
                        onclick="selectRoomType('She Shed',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>She Shed</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Conservatory"
                        onclick="selectRoomType('Conservatory',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Conservatory</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Nursery"
                        onclick="selectRoomType('Nursery',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Nursery</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Prayer Room"
                        onclick="selectRoomType('Prayer Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Prayer Room</span>
                    </div>
                    <div class="gs-select-room-style-single" data-room-type="Open Kitchen Living Room"
                        onclick="selectRoomType('Open Kitchen Living Room',0)">
                        <img src="{{ asset('web2/images/select-room-type9.png') }}">
                        <span>Open Kitchen Living Room</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
