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
                {{ config('app.name') }}
            </a>
        </div>

        <!-- Email Body -->
        <div class="body" style="background-color: #fff; padding: 20px; max-width: 600px; margin: 0 auto;">
            <!-- Body content -->
            <p style="margin: 0; padding: 0;">Hello,</p>
            <div class="inner-body" style="margin-top: 20px; text-align: left;">
                <!-- Your email content goes here -->
                <p>Custom Enterprise Plan form details as below !</p> <br>
                <p>Full Name: {{ $message['fullName'] }}</p>
                <p>Work Email: {{ $message['workEmail'] }}</p>
                <p>Company Name: {{ $message['companyEmail'] }}</p>
                <p>Company Size: {{ $message['companySize'] }}</p>
                <p>Use Case: {{ $message['useCase'] }}</p>
                <p>Development Team: {{ $message['developmentTeam'] }}</p>

            </div>
            <p style="margin: 0; padding: 0; margin-top: 20px;">Regards,</p>
            <p style="margin: 0; padding: 0; font-weight: bold;">{{ config('app.name') }}</p>
        </div>

        <!-- Footer -->
        <div class="footer" style="padding: 20px;">
            <p style="margin: 0; padding: 0; text-align: center; color: #333333bf;">© {{ date('Y') }}
                {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
