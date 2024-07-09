@php
    $user = Auth::user();
@endphp
@if (isset($user->feedback_confirmation) &&
        isset($user->total_designs) &&
        $user->feedback_confirmation == 0 &&
        $user->total_designs > 60)
    <div id="feedbackModel" class="modal gs-modal-background feedback-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog gs-modal-container" role="document">
            <div class="modal-content gs-modal-content">
                <button type="button" class="gs-modal-close" data-dismiss="modal" id="closefeedbackModal">
                    <img src="{{ asset('web2/images/gs-close-icon.svg') }}">
                </button>
                <div class="logo"><img src="{{ asset('web/images/NewHomeDesignsAILogo.svg') }}"></div>
                <div class="feedback_heading_div">
                    <p class="feedback_heading">How happy are you with our app?</p>
                    <form id="feedbackRatingForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="rate">
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>
                        <div class="rating_submit_btn">
                            <button class="btn btn-primary btn-sm" type="button"
                                id="submitFeedbackRating">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="bad_review hidden review_part_star">
                    <h6>Thank you for your honest feedback!</h6>
                    <p>Tell us how we can improve your experience on HomeDesigns AI by typing your suggestions
                        in the box below:</p>
                    <form id="feedbackForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <textarea class="form-control" type="text" placeholder="Please write your suggestions." name="userfeedback"
                                rows="3"></textarea>
                        </div>
                        <div class="rating_submit_btn">
                            <button class="btn btn-primary btn-sm" type="button" id="submitFeedback">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="good_review hidden review_part_star">
                    <h6>Thank you for your feedback!</h6>
                    <p>It would mean the world to us if you could spread the word and leave us a review on Trustpilot.
                    </p>
                    <!-- TrustBox widget - Review Collector -->
                    <div class="trustpilot-widget" data-locale="en-US" data-template-id="56278e9abfbbba0bdcd568bc"
                        data-businessunit-id="63dc0db78c7acc4ede62f398" data-style-height="52px"
                        data-style-width="100%">
                        <a href="https://www.trustpilot.com/review/homedesigns.ai" target="_blank"
                            rel="noopener">Trustpilot</a>
                    </div>
                    <!-- End TrustBox widget -->
                    <p class="mt-2">Contact us after you leave a review for a special gift.🎁</p>
                </div>
            </div>
        </div>
    </div>
    <div id="feedbackModelRoute" class="hidden" data-route="{{ route('closeUserfeedback') }}"></div>
@endif
