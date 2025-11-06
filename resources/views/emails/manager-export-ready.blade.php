<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог с ценами 1C готов</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; border-radius: 10px; padding: 30px; margin-bottom: 20px;">
        <h2 style="color: #2c3e50; margin-top: 0;">Здравствуйте!</h2>
        
        <p style="font-size: 16px;">
            Ваш экспорт каталога <strong>{{ $exportType }}</strong> с ценами 1C готов.
        </p>

        <p style="font-size: 14px; color: #666;">
            Файл Excel с ценами из 1C прикреплен к этому письму.
        </p>

        <div style="background-color: #e8f4f8; border-left: 4px solid #3498db; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; font-size: 14px;">
                <strong>Тип экспорта:</strong> {{ $exportType }}<br>
                <strong>Цены:</strong> Напрямую из 1C (без коэффициентов)
            </p>
        </div>
    </div>

    <div style="text-align: center; color: #999; font-size: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
        <p>С уважением,<br>Команда Radop</p>
    </div>
</body>
</html>

