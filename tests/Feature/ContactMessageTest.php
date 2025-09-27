<?php

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('contact page loads successfully', function () {
    $response = $this->get('/contact');
    $response->assertStatus(200);
    $response->assertSee('Send Me a Message');
});

test('can submit contact form', function () {
    $contactData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'subject' => 'project',
        'budget' => '5k-10k',
        'message' => 'This is a test message for the contact form functionality.',
    ];

    $response = $this->post('/contact', $contactData);

    $response->assertRedirect('/contact');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'subject' => 'project',
        'budget' => '5k-10k',
        'status' => 'new',
    ]);
});

test('contact form validation works', function () {
    $response = $this->post('/contact', []);

    $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
});

it('contact message model functions work', function () {
    $message = ContactMessage::factory()->create([
        'status' => 'unread',
        'read_at' => null,
    ]);

    expect($message->isRead())->toBeFalse();
    expect($message->status)->toBe('unread');

    $message->markAsRead();
    $message->refresh(); // Refresh the model to get updated values

    expect($message->isRead())->toBeTrue();
    expect($message->status)->toBe('read');
    expect($message->read_at)->not->toBeNull();
});
