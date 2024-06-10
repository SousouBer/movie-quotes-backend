<div style="width: 100%; padding: 4rem 0; background: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%);">
    <div style="align-content: center; text-align: center; padding: 2rem 0; margin: 0 auto; width: 50%;">
        <div style="text-align: center;">
            <img src="{{ asset('/images/icon-chat.png') }}" alt="Chat icon">
        </div>
        <span style="  text-transform: uppercase; font-weight: bold; color: #DDCCAA; font-size: 12px;">movie quotes</span>
        <div style="margin: 2rem 0; text-align: start;">
            <span style="color: #fff;">Hi, {{ $username }}!</span>
            <p style="color: #fff; margin: 2rem 0">Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account.</p>
            <a style="background: #E31221; padding: 0.5rem 1.5rem; border-radius: 4px; margin-top: 1rem; color: #fff; text-decoration: none;" href="{{config('app.frontend_url') . '/landing?' . 'email=' .  $email . '&verifyLink=' . $verificationUrl }}">Verify account</a>
            <p style="color: #fff; margin: 2rem 0;">If clicking doesn't work, you can try copying and pasting it to your browser:</p>
            <a style="color: #DDCCAA; text-decoration: none;" href="{{config('app.frontend_url') . '/landing?' . 'email=' .  $email . '&verifyLink=' . $verificationUrl }}">{{config('app.frontend_url') . '/landing?' . 'email=' .  $email . '&verifyLink=' . $verificationUrl }}</a>
            <p style="color: #fff; margin: 1rem 0">If you have any problems, please contact us: support@moviequotes.ge</p>
            <span style="color: #fff";>MovieQuotes Crew</span>
         </div>
    </div>
</div>