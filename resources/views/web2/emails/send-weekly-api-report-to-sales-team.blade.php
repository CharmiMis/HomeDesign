<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
</head>

<body>
    <div style="width: 100%;background-color: #baeaea;">
        <!-- Header -->
        <div class="header" style="padding: 20px;text-align: center;">
            <a href="{{ config('app.url') }}"
                style="display: inline-block; color: #000000e0; text-decoration: none; font-weight: bold;">
                <img src="https://homedesigns.ai/web/images/NewHomeDesignsAILogo.png" alt="homedesignsai logo" style="width: 30%;" />
            </a>
        </div>

        <!-- Email Body -->
        <div class="body" style="background-color: #fff; padding: 20px; max-width: 600px; margin: 0 auto;">
            <!-- Body content -->
            <p style="margin: 0; padding: 0;">Dear <b>{{$salesmember_name}}</b>,</p>
            <div class="inner-body" style="margin-top: 20px; text-align: left;">
                <!-- Your email content goes here -->
                <p>Here's your weekly B2B API sales summary for the week of <b>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($startDate))->format('Y/m/d').' - '.\Carbon\Carbon::createFromTimeStamp(strtotime($endDate))->format('Y/m/d') }}</b></p> <br>
                <p>New Client Recap:</p>
                @if($data['success'])
                <table style="font-size: 0.8rem;">
                    <th>User ID</th>
                    <th>User Name</th>    
                    <th>User Email</th>    
                    <th>Purchased Plan</th>    
                    <th>API Generation Count</th>    

                    <tbody>
                        @if(isset($data['data']['registered_users']) && count($data['data']['registered_users']) > 0)
                            @foreach($data['data']['registered_users'] as $registered_user)
                            <tr>
                                <td>{{$registered_user->id}}</td>
                                <td>{{$registered_user->name}}</td>
                                <td>{{$registered_user->email}}</td>
                                <td>{{isset($registered_user->activeSubscription) && !empty($registered_user->activeSubscription) ? $registered_user->activeSubscription->plan_name: "" }}</td>
                                <td>{{isset($registered_user->activeSubscription) && !empty($registered_user->activeSubscription) ? $registered_user->activeSubscription->used_credit: "" }}</td>
                            </tr>
                            @endforeach
                        @else

                        <tr><td colspan="5">No new records found.</td></tr>
                        @endif
                    </tbody>
                </table>

                @endif
                <br><p>Cancelled (Churned) Clients Recap:</p>

                <table style="font-size: 0.8rem;">
                    <th>User ID</th>
                    <th>User Name</th>    
                    <th>User Email</th>    
                    <th>Purchased Plan</th>    
                    <th>API Generation Count</th>    

                    <tbody>
                        @if(isset($data['data']['registered_users_canceled']) && count($data['data']['registered_users_canceled']) > 0)
                            @foreach($data['data']['registered_users_canceled'] as $registered_canceled_user)
                            <tr>
                                <td>{{$registered_canceled_user->id}}</td>
                                <td>{{$registered_canceled_user->name}}</td>
                                <td>{{$registered_canceled_user->email}}</td>
                                <td>{{isset($registered_canceled_user->activeSubscription) && !empty($registered_canceled_user->activeSubscription) ? $registered_canceled_user->activeSubscription->plan_name: "" }}</td>
                                <td>{{isset($registered_canceled_user->activeSubscription) && !empty($registered_canceled_user->activeSubscription) ? $registered_canceled_user->activeSubscription->used_credit: "" }}</td>
                            </tr>
                            @endforeach
                        @else
                        <tr><td colspan="5">No new records found.</td></tr>
                        @endif
                    </tbody>
                </table>
                <br>
                <p>Important Notes:</p>
                <ul>
                    <li>Please follow up with all new clients to facilitate a smooth onboarding process and ensure they're leveraging our API to its full potential.</li>
                    <li>Consider providing onboarding resources or scheduling introductory calls as needed.</li>
                    <li>Track their API usage and offer support as needed.</li>
                    <li>Reach out to every cancelled API subscriber to understand the reasons and look for ways to get them back a subscription.</li>
                </ul></br>

            </div>
            <p style="margin: 0; padding: 0; margin-top: 20px;">Best,</p>
            <p style="margin: 0; padding: 0; font-weight: bold;">{{ config('app.name') }} Admin Bot</p>
        </div>

        <!-- Footer -->
        <div class="footer" style="padding: 20px;">
            <p style="margin: 0; padding: 0; text-align: center; color: #333333bf;">© {{ date('Y') }}
                {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
