<section class="section-password-reset" style="padding: 40px 0; background-color: #f9f9f9;">
    <div class="password-reset-container" style="max-width: 800px; margin: auto; background-color: #ffffff; padding: 40px; border: 1px solid #eaeaea; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif; color: #333333; line-height: 1.6;">
        <div class="header" style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 32px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 2px; color: #333333;">{{__('emails.password_reset')}}</h1>
            <p style="font-size: 18px; color: #555555;">{{__('emails.password_reset_text')}}</p>
        </div>

        <div class="message" style="margin-bottom: 40px; text-align: center;">
            <p style="font-size: 18px; color: #555555;">{{__('emails.password_reset_action')}}</p>
            <a href="{{ config('app.url') }}/auth/reset-password/{{ $token }}" style="display: inline-block; margin-top: 20px; padding: 15px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">{{__('emails.password_reset_button_text')}}</a>
        </div>

        <div class="footer" style="text-align: center; font-size: 14px; color: #777777; border-top: 1px solid #eaeaea; padding-top: 20px;">
            <p>{{__('emails.password_reset_action_warning')}}</p>
            <p>radop.md | radop112@radop.md | 022-78-21-00</p>
        </div>
    </div>
</section>
