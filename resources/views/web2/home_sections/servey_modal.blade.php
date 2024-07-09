@php
    $user = Auth::user();
    $servey_variant_zero = config('serveyQuestions.variant_zero');
    $servey_variant_one = config('serveyQuestions.variant_one');
    $servey_variant_two = config('serveyQuestions.variant_two');
@endphp
@if (isset($user->servery_confirmation) && $user->servery_confirmation == 0)
    <div id="serveyModal" class="modal gs-modal-background survey-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog gs-modal-container" role="document">
            <div class="modal-content gs-modal-content">
                <button type="button" class="gs-modal-close" data-dismiss="modal" id="closeserveyModal">
                    <img src="{{ asset('web2/images/gs-close-icon.svg') }}">
                </button>
                <div class="logo"><img src="{{ asset('web/images/NewHomeDesignsAILogo.svg') }}"></div>
                <div class="survey_heading_div">
                    <p class="survey_video_heading">Welcome to HomeDesigns AI!👋</p>
                    <p class="survey_video_text">Before we get started, please take the time to watch this short
                        onboarding video to get familiar
                        with all the available functions in our platform. </p>
                </div>
                <div class="welcome_video welcome_content active" welcome-variant="1">
                    <iframe id="welcome_video_frame" width="auto" height="180"
                        src="https://www.youtube.com/embed/cIYIejIHjDA" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="servey_welcome welcome_content" welcome-variant="2">
                    <h3 class="servey_heading">In order to customize the dashboard around your needs, please answer
                        three simple questions.</h3>
                    <p class="servey_heading2">This will help us personalize your experience in HomeDesignsAI.</p>
                </div>
                <div class="bottom-btn">
                    <div class="prgressBarfirst">
                        <progress class="uk-progress progress-green progress-start" value="0"
                            max="100"></progress>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-secondary btn-sm hidden" type="button" id="skip">Skip</button>
                        <button class="btn btn-primary btn-sm" type="button" welcome-active-variant="1"
                            id="continue">Continue</button>
                    </div>
                </div>
                <form id="servey_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="variant_zero" class="question_variant" data-variant="0">
                        @foreach ($servey_variant_zero as $key => $zeroData)
                            <div class="question-outer" data-question="{{ $zeroData['question_id'] }}">
                                <label class="question">{{ $zeroData['question'] }}</label>
                                <div class="options-outer">
                                    <ul class="option-items clearfix">
                                        @foreach ($zeroData['options'] as $key => $zeroDataOptions)
                                            <li>
                                                <div class="option-item">
                                                    <input id="optionid-{{ $zeroDataOptions['option_id'] }}"
                                                        type="radio" value="{{ $zeroDataOptions['value'] }}"
                                                        name="question[{{ $zeroData['question_id'] }}]"
                                                        data-target-variant="{{ $zeroDataOptions['target_variant'] }}">
                                                    <label
                                                        for="optionid-{{ $zeroDataOptions['option_id'] }}">{{ $zeroDataOptions['text'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="variant_one" class="question_variant" data-variant="1">
                        @foreach ($servey_variant_one as $key => $firstData)
                            <div class="question-outer" data-question="{{ $firstData['question_id'] }}">
                                <label class="question">{{ $firstData['question'] }}</label>
                                <div class="options-outer">
                                    <ul class="option-items clearfix">
                                        @foreach ($firstData['options'] as $key => $firstDataOptions)
                                            <li>
                                                <div class="option-item">
                                                    <input id="optionid-{{ $firstDataOptions['option_id'] }}"
                                                        type="radio" name="question[{{ $firstData['question_id'] }}]"
                                                        value="{{ $firstDataOptions['value'] }}"
                                                        onchange="showOtherTextArea(this, '{{ $firstData['question_id'] }}')">
                                                    <label
                                                        for="optionid-{{ $firstDataOptions['option_id'] }}">{{ $firstDataOptions['text'] }}</label>

                                                    @if ($firstDataOptions['value'] == 'other')
                                                        <input type="text" placeholder="Type your answer here."
                                                            name="other_text[{{ $firstData['question_id'] }}]"
                                                            value="" class="other_text" style="display: none;"
                                                            required autocomplete="off">
                                                    @endif
                                                </div>
                                                @error('other_text.' . $firstData['question_id'])
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="variant_two" class="question_variant" data-variant="2">
                        @foreach ($servey_variant_two as $key => $secondData)
                            <div class="question-outer" data-question="{{ $secondData['question_id'] }}">
                                <label class="question">{{ $secondData['question'] }}</label>
                                <div class="options-outer">
                                    <ul class="option-items clearfix">
                                        @foreach ($secondData['options'] as $key => $secondDataOptions)
                                            <li>
                                                <div class="option-item">
                                                    <input id="optionid-{{ $secondDataOptions['option_id'] }}"
                                                        type="radio" value="{{ $secondDataOptions['value'] }}"
                                                        name="question[{{ $secondData['question_id'] }}]"
                                                        onchange="showOtherTextArea(this, '{{ $secondData['question_id'] }}')">
                                                    <label
                                                        for="optionid-{{ $secondDataOptions['option_id'] }}">{{ $secondDataOptions['text'] }}</label>

                                                    @if ($secondDataOptions['value'] == 'other')
                                                        <input type="text" placeholder="Type your answer here."
                                                            name="other_text[{{ $secondData['question_id'] }}]"
                                                            value="" class="other_text" style="display: none;" autocomplete="off"/>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <section class="question-footer">
                        <div class="uk-container uk-container-small uk-margin-top questions-footer"
                            style="display: none;">
                            <progress class="uk-progress progress-green progrss-value" value="33.33"
                                max="100"></progress>
                        </div>
                        <div class="pull-right gs-modal-btns">
                            <button class="btn btn-secondary btn-sm prev hidden" type="button"
                                id="survey-prev-button">Back</button>
                            <button class="btn btn-primary btn-sm hidden" type="button" id="survey-next-button"
                                data-active-variant="0" data-active-question="1">Next</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@endif
