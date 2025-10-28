<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('theme.personalized_export_email_subject') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .content {
            padding: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('theme.personalized_export_email_title') }}</h1>
    </div>

    <div class="content">
        <p>{{ __('theme.personalized_export_greeting', ['name' => $user->email]) }}</p>

        <p>{{ __('theme.personalized_export_ready_message') }}</p>

        <p>{{ __('theme.personalized_export_type_info', ['type' => __('theme.export_type_' . $exportType)]) }}</p>

        <p>{{ __('theme.personalized_export_attachment_info') }}</p>

        <p>{{ __('theme.personalized_export_contact_info') }}</p>
    </div>

    <div class="footer">
        <p>{{ __('theme.personalized_export_footer') }}</p>
        <p class="highlight">{{ config('app.name') }}</p>
    </div>
</body>
</html>
