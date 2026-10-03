<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head><meta charset="utf-8"><title>{{ __('contact.form_mail_subject', ['name' => $lead['name'] ?? '']) }}</title></head>
<body style="font-family: Arial, sans-serif; color: #252d3b; line-height: 1.5;">
    <h2 style="margin:0 0 16px;font-size:18px;">{{ __('contact.form_mail_heading') }}</h2>

    <table cellpadding="6" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
        <tr><td style="color:#646e7c;">{{ __('contact.form_name') }}</td><td><b>{{ $lead['name'] }}</b></td></tr>
        @if(!empty($lead['phone']))
            <tr><td style="color:#646e7c;">{{ __('contact.form_phone') }}</td><td><b>{{ $lead['phone'] }}</b></td></tr>
        @endif
        @if(!empty($lead['email']))
            <tr><td style="color:#646e7c;">{{ __('contact.form_email') }}</td><td><b>{{ $lead['email'] }}</b></td></tr>
        @endif
        <tr><td style="color:#646e7c;">{{ __('contact.form_page') }}</td><td>{{ $lead['page'] }}</td></tr>
    </table>

    <p style="margin:16px 0 4px;color:#646e7c;font-size:14px;">{{ __('contact.form_message') }}</p>
    <p style="margin:0;white-space:pre-line;font-size:14px;">{{ $lead['message'] }}</p>
</body>
</html>
