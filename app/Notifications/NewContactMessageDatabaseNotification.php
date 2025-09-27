<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewContactMessageDatabaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ContactMessage $contactMessage
    ) {}

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
     * Get the database notification representation.
     */
    public function toDatabase(User $notifiable): array
    {
        return FilamentNotification::make()
            ->title('New Contact Message')
            ->body("New message from {$this->contactMessage->name} ({$this->contactMessage->email})")
            ->icon('heroicon-o-envelope')
            ->color('success')
            ->actions([
                Action::make('view')
                    ->label('View Message')
                    ->url('/admin/contact-messages/'.$this->contactMessage->id.'/edit')
                    ->button()
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
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
            'contact_message_name' => $this->contactMessage->name,
            'contact_message_email' => $this->contactMessage->email,
            'contact_message_subject' => $this->contactMessage->subject,
        ];
    }
}
