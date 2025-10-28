<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/**
 * @param User $user
 * @param string $filePath
 * @param string $fileName
 * @param string $exportType
 */
final class PersonalizedExportReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param User $user
     * @param string $filePath
     * @param string $fileName
     * @param string $exportType
     */
    public function __construct(
        public readonly User $user,
        public readonly string $filePath,
        public readonly string $fileName,
        public readonly string $exportType
    ) {
    }

    /**
     * @return PersonalizedExportReadyMail
     */
    public function build(): PersonalizedExportReadyMail
    {
        $fullPath = storage_path("app/{$this->filePath}");

        $mail = $this->subject(__('theme.personalized_export_email_subject'))
            ->view('emails.personalized-export-ready', [
                'user' => $this->user,
                'exportType' => $this->exportType,
            ]);

        if (Storage::exists($this->filePath) && file_exists($fullPath)) {
            $mail->attach($fullPath, [
                'as' => $this->fileName,
            ]);
        }

        return $mail;
    }
}
