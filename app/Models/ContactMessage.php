<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'budget',
        'message',
        'status',
        'read_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function markAsRead(): void
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    public function isRead(): bool
    {
        return $this->status === 'read';
    }

    public function getBudgetLabelAttribute(): string
    {
        return match ($this->budget) {
            'under-5k' => 'Under $5,000',
            '5k-10k' => '$5,000 - $10,000',
            '10k-25k' => '$10,000 - $25,000',
            '25k-50k' => '$25,000 - $50,000',
            '50k-plus' => '$50,000+',
            'discuss' => 'Let\'s discuss',
            default => 'Not specified',
        };
    }

    public function getSubjectLabelAttribute(): string
    {
        return match ($this->subject) {
            'project' => 'New Project Inquiry',
            'collaboration' => 'Collaboration Opportunity',
            'consultation' => 'Consultation Request',
            'support' => 'Technical Support',
            'other' => 'Other',
            default => $this->subject,
        };
    }
}
