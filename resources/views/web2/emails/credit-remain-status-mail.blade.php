<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        .btn-primary {
            background: #7558ea;
            border-color: #7558ea;
            font-size: 15px;
            cursor: pointer;
            padding: 11px;
            text-align: center;
            display: inline-block;
            color: #ffffffe0;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
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
                @if($emailData['percentage'] == 50)
                    <p>{{$emailData['message']}}</p>
                @elseif($emailData['percentage'] == 10)
                    <p>{{$emailData['message']}}</p>
                @elseif($emailData['percentage'] == 0)
                    <p>{{$emailData['message']}}</p>
                @endif
            </div>
            <p style="margin: 0; padding: 0; margin-top: 20px;">Regards,</p>
            <p style="margin: 0; padding: 0; font-weight: bold;">{{ config('app.name') }}</p>

            <div style="display: flex; justify-content: center; align-items: center;">
                <a href="{{ route('api.custom-credit') }}" class="btn-primary">
                    Send Custom Credit Request Now!
                </a>
            </div>
        </div>


        <!-- Footer -->
        <div class="footer" style="padding: 20px;">
            <p style="margin: 0; padding: 0; text-align: center; color: #333333bf;">© {{ date('Y') }}
                {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
