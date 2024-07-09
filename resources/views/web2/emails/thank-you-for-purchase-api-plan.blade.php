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
            <p style="margin: 0; padding: 0;">Hello, {{ $message['fullName'] }}</p>
            <div class="inner-body" style="margin-top: 20px; text-align: left;">
                <!-- Your email content goes here -->
                <p>A warm welcome to <a href="{{config('app.url')}}">{{ config('app.name') }}</a>! We're thrilled to have you on board and excited to embark on this journey of transformation with you. By choosing us, you've unlocked a world where creativity meets technology, enabling you to bring your interior design visions to life with unparalleled ease and precision.</p> <br>
                <p>What You Can Look Forward To:</p>
                <ul>
                    <li>Unlimited Design Possibilities: With our AI-driven platform, explore over 40 design styles across various room types, ensuring every space you envision can be brought to life.</li>
                    <li>Efficiency and Ease: Forget about the traditional hassles and long timelines of physical staging. Our tool allows you to fully redesign a room in just 20 seconds, streamlining your design process like never before.</li>
                    <li>Cost-Effective Solutions: Say goodbye to expensive staging costs. Our subscription offers an affordable way to stage homes, enhance listings, and attract more buyers, all with a few clicks.</li>
                    <li>Integration and Customization: Seamlessly integrate our tool with your website for a smooth, branded experience that stands out to your clients.</li>
                </ul></br>
                <p>Get Started:</p></br>
                <p>Dive right into our user-friendly platform with these first steps:</p></br>
                <ol>
                    <li>Dig into the documentation: Here you will find everything you need to know about setting up your API: <a href="{{config('app.url')}}api-documentation">{{config('app.url')}}api-documentation</a></li>
                    <li>Explore the Dashboard: Familiarize yourself with our range of features and settings to customize your experience <a href="{{config('app.url')}}api-guide">{{config('app.url')}}api-guide</a>.</li>
                    <li>Get creative: Set-up your front-end and get ready to be amazed.</li>
                </ol></br>
                <p>Need Assistance?</p></br>
                <p>Our dedicated support team is here to help you every step of the way. Whether you have questions about getting started, need technical support, or want to share feedback, don't hesitate to reach out through our Customer Support <a href="https://homedesignsai.reamaze.com/chat-with-us">https://homedesignsai.reamaze.com/chat-with-us</a></p></br>

                <p>Thank you for choosing <a href="{{config('app.url')}}">{{ config('app.name') }}</a>. We're excited to see the incredible spaces you'll create. Here's to a journey filled with innovation, creativity, and breathtaking designs!</p></br>

            </div>
            <p style="margin: 0; padding: 0; margin-top: 20px;">Warmest regards,</p>
            <p style="margin: 0; padding: 0; font-weight: bold;">{{ config('app.name') }} Team</p>
        </div>

        <!-- Footer -->
        <div class="footer" style="padding: 20px;">
            <p style="margin: 0; padding: 0; text-align: center; color: #333333bf;">© {{ date('Y') }}
                {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
