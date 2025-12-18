<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

final class CleanupManagerExportsCommand extends Command
{
    protected $signature = 'manager-exports:cleanup';

    protected $description = 'Очистка всех файлов экспорта менеджеров';

    public function handle(): void
    {
        $disk = Storage::disk('manager_exports');
        $files = $disk->files();

        if (empty($files)) {
            $this->info('Файлы для очистки не найдены.');
            return;
        }

        $deletedCount = 0;
        foreach ($files as $file) {
            if ($disk->delete($file)) {
                $deletedCount++;
            }
        }

        $this->info("Успешно удалено файлов: {$deletedCount} из " . count($files));
    }
}
