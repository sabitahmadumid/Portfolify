<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessageDatabaseNotification;
use Filament\Notifications\Notification;

class ContactMessageObserver
{
    /**
     * Handle the ContactMessage "created" event.
     */
    public function created(ContactMessage $contactMessage): void
    {
        // Send a session-based notification (for immediate feedback)
        $this->sendFilamentNotification($contactMessage);

        // Send database notifications to all admin users
        $this->sendDatabaseNotificationToAdmins($contactMessage);
    }

    /**
     * Send Filament notification for new contact messages
     */
    private function sendFilamentNotification(ContactMessage $contactMessage): void
    {
        // Create a session-based notification for immediate feedback
        Notification::make()
            ->title('New Contact Message')
            ->success()
            ->body("New message from {$contactMessage->name} ({$contactMessage->email})")
            ->icon('heroicon-o-envelope')
            ->send();
    }

    /**
     * Send database notifications to all admin users
     */
    private function sendDatabaseNotificationToAdmins(ContactMessage $contactMessage): void
    {
        // Get all admin users (assuming they have an email_verified_at field)
        // You can modify this query based on your user roles/permissions setup
        $adminUsers = User::whereNotNull('email_verified_at')->get();

        foreach ($adminUsers as $adminUser) {
            $adminUser->notify(new NewContactMessageDatabaseNotification($contactMessage));
        }
    }
}
