<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\Analytics\Ga4RefundReporter;
use Illuminate\Console\Command;

/**
 * Отправка возврата в GA4 (ТЗ 17).
 *
 * Возврат подтверждают в учётной системе, покупателя на сайте в этот момент
 * нет — поэтому событие уходит с сервера. Команду вызывает менеджер или
 * обмен с 1С.
 *
 *   php artisan ga4:refund 100123                       — возврат всего заказа
 *   php artisan ga4:refund 100123 --item=50000029:2     — частичный возврат
 *   php artisan ga4:refund 100123 --amount=250.50       — своя сумма возврата
 *   php artisan ga4:refund 100123 --debug               — проверка без записи в отчёты
 */
final class Ga4RefundCommand extends Command
{
    protected $signature = 'ga4:refund
        {order : Номер заказа или его id}
        {--item=* : Возвращаемая позиция в виде код:количество}
        {--amount= : Сумма возврата, если отличается от расчётной}
        {--debug : Отправить в отладочный адрес Google и показать ответ}';

    protected $description = 'Сообщает в GA4 о возврате заказа';

    public function handle(Ga4RefundReporter $reporter): int
    {
        $key = (string) $this->argument('order');

        $order = Order::where('order_number', $key)->first() ?? Order::find($key);

        if ($order === null) {
            $this->error("Заказ {$key} не найден");

            return self::FAILURE;
        }

        $quantities = [];

        foreach ((array) $this->option('item') as $pair) {
            [$code, $quantity] = array_pad(explode(':', (string) $pair, 2), 2, '1');
            $code = trim($code);

            if ($code === '') {
                continue;
            }

            $quantities[$code] = max(1, (int) $quantity);
        }

        $amount = $this->option('amount') !== null ? (float) $this->option('amount') : null;

        $result = $reporter->report($order, $quantities, $amount, (bool) $this->option('debug'));

        $this->table(
            ['заказ', 'сумма', 'позиций', 'отправлено'],
            [[
                $result['payload']['transaction_id'],
                $result['payload']['value'],
                count($result['payload']['items'] ?? []),
                $result['sent'] ? 'да' : 'нет: ' . ($result['reason'] ?? 'см. журнал'),
            ]]
        );

        if ($this->option('debug')) {
            $this->line(json_encode($result['response'] ?? null, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }

        return $result['sent'] ? self::SUCCESS : self::FAILURE;
    }
}
