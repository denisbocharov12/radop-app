<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Заливка дампа в базу средствами PHP.
 *
 * Нужна сборке GitHub Pages: консольный клиент mysql на раннере может
 * отсутствовать, а дамп у нас свой — простой набор DELETE и INSERT, разбирать
 * его сложным парсером незачем.
 *
 *   php artisan db:import-dump database/pages/dataset.sql.gz
 */
final class ImportSqlDumpCommand extends Command
{
    protected $signature = 'db:import-dump {file : Путь к .sql или .sql.gz}';

    protected $description = 'Заливает SQL-дамп в текущую базу';

    public function handle(): int
    {
        $file = (string) $this->argument('file');

        if (! is_file($file)) {
            $this->error("Файл не найден: {$file}");

            return self::FAILURE;
        }

        $handle = str_ends_with($file, '.gz') ? gzopen($file, 'rb') : fopen($file, 'rb');

        if ($handle === false) {
            $this->error("Не удалось открыть {$file}");

            return self::FAILURE;
        }

        $read = str_ends_with($file, '.gz')
            ? static fn () => gzgets($handle)
            : static fn () => fgets($handle);
        $eof = str_ends_with($file, '.gz')
            ? static fn () => gzeof($handle)
            : static fn () => feof($handle);

        $statement = '';
        $count = 0;

        DB::connection()->getPdo();

        while (! $eof()) {
            $line = $read();

            if ($line === false) {
                break;
            }

            $statement .= $line;

            // Запросы в дампе заканчиваются точкой с запятой в конце строки.
            if (substr(rtrim($line), -1) !== ';') {
                continue;
            }

            try {
                DB::unprepared($statement);
            } catch (\Throwable $e) {
                $this->error('Ошибка на запросе: ' . mb_substr(trim($statement), 0, 120));
                $this->error($e->getMessage());

                return self::FAILURE;
            }

            $statement = '';
            $count++;
        }

        str_ends_with($file, '.gz') ? gzclose($handle) : fclose($handle);

        $this->info("Выполнено запросов: {$count}");

        return self::SUCCESS;
    }
}
