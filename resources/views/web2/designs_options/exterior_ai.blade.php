<option value="very_low">Very Low AI Intervention</option>
<option value="low">Low AI Intervention</option>
<option selected="" value="mid">Medium AI Intervention</option>
@if ($userActivePlan == 'free' || $precisionUser == true)
<option class="paid_feature_modal">Extreme AI Intervention &nbsp;&#xf023;</option>
@else
<option value="extreme">Extreme AI Interventio</option>
@endif