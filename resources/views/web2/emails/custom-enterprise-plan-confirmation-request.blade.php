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
                <img src="https://homedesigns.ai/web/images/NewHomeDesignsAILogo.png" alt="HomeDesigns AI Logo" style="width: 30%;">
            </a>
        </div>

        <!-- Email Body -->
        <div class="body" style="background-color: #fff; padding: 20px; max-width: 600px; margin: 0 auto;">
            <!-- Body content -->
            <p style="margin: 0; padding: 0;">Dear {{ $message['fullName'] }}</p>
            <div class="inner-body" style="margin-top: 20px; text-align: left;">
                <!-- Your email content goes here -->
                <p>Thank you for reaching out to us HomeDesigns.ai business solution! We have received your request and one of our sales representatives will be in touch shortly.</p>
                <p>If you would like to expedite the process, feel free to schedule a call directly with one of our sales agents using the links below:</p>
                <ul>
                    <!-- <li><a href="https://calendly.com/george-homedesignsai">https://calendly.com/george-homedesignsai</a></li> -->
                    <li><a href="https://calendly.com/genevive-homedesignsai">https://calendly.com/genevive-homedesignsai</a></li>
                    <li><a href="https://calendly.com/vladhomedesignsai/">https://calendly.com/vladhomedesignsai/</a></li>
                </ul>
                <p>We look forward to connecting with you!</p>
                <br>
            </div>
            <p style="margin: 0; padding: 0; margin-top: 20px;">Best Regards,</p>
            <p style="margin: 0; padding: 0; font-weight: bold;">The {{ config('app.name') }}.ai Team</p>
        </div>

        <!-- Footer -->
        <div class="footer" style="padding: 20px;">
            <p style="margin: 0; padding: 0; text-align: center; color: #333333bf;">© {{ date('Y') }}
                {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
