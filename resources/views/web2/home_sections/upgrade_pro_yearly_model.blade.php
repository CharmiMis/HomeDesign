@php
    $user = Auth::user();
    $currentPlan = $user->activePlan();
    $closeBtnCount = $user->getCountOfCloseButton();
@endphp
@if(($currentPlan == 'homedesignsai-individual' || 'homedesignsai-individual-2' || $currentPlan == 'homedesignsai-pro' || $currentPlan == 'homedesignsai-pro-2') && $user->total_designs > 100 && $closeBtnCount < 2)
    <div id="upgradeToProYearly" class="modal pro-yearly-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {{-- <div class="mdp-cl-btn mdl-close-btn">
                    <span class="precision_suggestion_closebt closeProYearlyModal" data-bs-dismiss="modal">
                        <i class="fa fa-times fa-unset" aria-hidden="true"></i>
                    </span>
                </div> --}}
                <div class="logo">
                    <h4><b>Upgrade to Yearly</b> Billing and Enjoy 4 Months FREE on Us!</h4>
                </div>
                <div class="upgrade_yearly_body">
                    <div class="upgrade_yearly_image">
                        <img src="{{asset('web/images/gift-box-with-a-bow.svg')}}" alt="">
                    </div>
                    <div class="upgrade_yearly_text">
                        <p>You're on a roll with 100 creations and this is only the beginning of your journey🎉.</p>
                        <p>As a thank you, we're offering you 4 months free when you <b>switch to PRO with yearly billing.</b></p>
                        <p>Just copy the discount code below and use it at checkout to get 4 months free.</p>
                        <div class="copy_part_btn">
                            <input type="text" class="text" value="3FGK3G" disabled/>
                            <a href="#" class="gt-stbtn"><img src="{{asset('web/images/copy.svg')}}" alt="" title="Copy"></a>
                        </div>
                    </div>
                </div>
                <p class="important_peregraph_modal"> <span>IMPORTANT:</span>This coupon is uniquely yours and is <span style="text-decoration: underline">only valid for 24 hours.</span> To apply the coupon, click on 'Enter Promotional Code' on checkout. </p>
                <div class="upgrade_yearly_buttons">
                    {{-- <a href="{{ route('getsubDetails.users', encrypt($customer->subscription->id)) }}" class="gt-stbtn">Upgrade to PRO Yearly</a> --}}
                    <a href="#" class="gt-stbtn" data-fsc-item-path='pro-yearly-modal' data-fsc-item-path-value='pro-yearly-modal' data-fsc-action="Add, Checkout">Upgrade to PRO Yearly</a>
                    <button class="upgd-go" id="closeProYearlyModal">No,THANKS</button>
                </div>
            </div>
        </div>
    </div>
    <div id="proYearlyModelRoute" class="hidden" data-route="{{ route('admin.increaseCloseBtnCount') }}"></div>
@endif
