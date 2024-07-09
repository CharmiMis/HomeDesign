<option>Beautiful Redesign</option>
{{-- <option>Change Colors</option> --}}
@if (
    $userActivePlan == 'homedesignsai-individual' ||
        $userActivePlan == 'homedesignsai-pro' ||
        $userActivePlan == 'pro-yearly' ||
        $userActivePlan == 'homedesignsai-individual-2' ||
        $userActivePlan == 'homedesignsai-pro-2' ||
        $precisionUser == false)
    <option>Creative Redesign</option>
@else
    <option class="paid_feature_modal">Creative Redesign&nbsp;&#xf023;</option>
@endif

@if ($userActivePlan == 'homedesignsai-pro' || 
        $userActivePlan == 'pro-yearly' ||
        $userActivePlan == 'homedesignsai-pro-2' ||
        $precisionUser == false)
    <option value="Sketch to Render">Sketch to Render</option>
@else
    <option class="paid_feature_modal">Sketch to Render&nbsp;&#xf023;</option>
@endif

<option>Fill The Room</option>
