<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Product\ProductErrorScanner;
use Illuminate\Console\Command;

/**
 * Rescans every product and refreshes the product_errors table. Intended to
 * run after the 1C import cycle completes (scheduled daily) and on demand from
 * the admin "Пересканировать" button.
 */
final class ScanProductErrorsCommand extends Command
{
    protected $signature = 'products:scan-errors';

    protected $description = 'Scan all products for quality issues (missing images, categories, brand, description, attributes) and refresh the product_errors table.';

    public function handle(ProductErrorScanner $scanner): int
    {
        $this->info('Scanning products for errors...');

        $processed = 0;
        $summary = $scanner->scanAll(function (int $count) use (&$processed): void {
            $processed += $count;
            $this->output->write("\rProcessed: {$processed}");
        });

        $this->newLine();
        $this->info(sprintf(
            'Done. Scanned %d products — %d with errors (%d critical, %d minor).',
            $summary['scanned'],
            $summary['with_errors'],
            $summary['critical'],
            $summary['minor'],
        ));

        return self::SUCCESS;
    }
}
