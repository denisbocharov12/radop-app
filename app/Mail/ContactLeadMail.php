<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Заявка с сайта менеджерам. Отвечать удобно прямо из письма, поэтому почта
 * покупателя идёт в reply-to.
 */
final class ContactLeadMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @param array<string, string|null> $lead
     */
    public function __construct(private readonly array $lead)
    {
    }

    public function build(): self
    {
        $mail = $this->subject(__('contact.form_mail_subject', ['name' => $this->lead['name'] ?? '']))
            ->view('emails.contact-lead', ['lead' => $this->lead]);

        if (! empty($this->lead['email'])) {
            $mail->replyTo((string) $this->lead['email'], (string) ($this->lead['name'] ?? ''));
        }

        return $mail;
    }
}
