<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/**
 * @param User $client
 * @param string $filePath
 * @param string $fileName
 * @param string $exportType
 * @param string $identifier
 */
final class ManagerExportReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param User $client
     * @param string $filePath
     * @param string $fileName
     * @param string $exportType
     * @param string $identifier
     */
    public function __construct(
        public readonly User $client,
        public readonly string $filePath,
        public readonly string $fileName,
        public readonly string $exportType,
        public readonly string $identifier
    ) {
    }

    /**
     * @return ManagerExportReadyMail
     */
    public function build(): ManagerExportReadyMail
    {
        $fullPath = storage_path("app/{$this->filePath}");

        $exportTypeLabel = match($this->exportType) {
            'categories' => 'Категории',
            'brands' => 'Бренды',
            default => 'Экспорт',
        };

        $subject = "Персонализированный экспорт {$exportTypeLabel} (Цены 1C)";

        $mail = $this->subject($subject)
            ->view('emails.manager-export-ready', [
                'client' => $this->client,
                'exportType' => $exportTypeLabel,
                'identifier' => $this->identifier,
            ]);

        if (Storage::exists($this->filePath) && file_exists($fullPath)) {
            $mail->attach($fullPath, [
                'as' => $this->fileName,
            ]);
        }

        return $mail;
    }
}

