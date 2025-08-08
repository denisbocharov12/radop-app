<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

final class CleanupTempFilesCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'cleanup:temp-files';

    /**
     * @var string
     */
    protected $description = 'Очистка временных файлов импорта изображений';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info('Начинаем очистку временных файлов...');

        // Очистка временной папки
        $tempPath = storage_path('app/temp');
        if (File::exists($tempPath)) {
            File::deleteDirectory($tempPath);
            $this->info('Очищена папка: ' . $tempPath);
        }

        // Очистка временного диска
        $tempDisk = Storage::disk('temp_import');
        $files = $tempDisk->allFiles();
        
        if (!empty($files)) {
            foreach ($files as $file) {
                $tempDisk->delete($file);
            }
            $this->info('Очищено файлов с временного диска: ' . count($files));
        }

        $this->info('Очистка завершена!');
        return 0;
    }
} 