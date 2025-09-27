<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ContactMessage $contactMessage)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Message from '.$this->contactMessage->name)
            ->line('You have received a new contact message.')
            ->line('From: '.$this->contactMessage->name.' ('.$this->contactMessage->email.')')
            ->line('Subject: '.$this->contactMessage->subject_label)
            ->line('Message: '.substr($this->contactMessage->message, 0, 100).'...')
            ->action('View Message', url('/admin/contact-messages/'.$this->contactMessage->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_message_id' => $this->contactMessage->id,
            'name' => $this->contactMessage->name,
            'email' => $this->contactMessage->email,
            'subject' => $this->contactMessage->subject_label,
            'message_preview' => substr($this->contactMessage->message, 0, 100),
            'received_at' => $this->contactMessage->created_at->toISOString(),
        ];
    }

    /**
     * Send Filament notification to admin users
     */
    public static function sendFilamentNotification(ContactMessage $contactMessage): void
    {
        FilamentNotification::make()
            ->title('New Contact Message')
            ->body("From: {$contactMessage->name} ({$contactMessage->email})")
            ->icon('heroicon-o-envelope')
            ->color('warning')
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->button()
                    ->url(route('filament.admin.resources.contact-messages.contact-messages.edit', $contactMessage))
                    ->label('View Message'),
            ])
            ->persistent()
            ->sendToDatabase(auth()->user());
    }
}
