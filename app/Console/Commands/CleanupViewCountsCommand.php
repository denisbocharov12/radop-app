<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\CleanupViewCountsJob;
use Illuminate\Console\Command;

final class CleanupViewCountsCommand extends Command
{
    protected $signature = 'view-counts:cleanup {--days=30 : Количество дней для удаления старых записей}';

    protected $description = 'Очищает старые записи просмотров';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $this->info("Запуск очистки записей просмотров старше {$days} дней...");

        CleanupViewCountsJob::dispatch($days);

        $this->info("Job для очистки записей просмотров добавлен в очередь.");

        return self::SUCCESS;
    }
} 