<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('the application returns a successful response', function () {
    // Seed basic configuration data for the test
    $this->seed(\Database\Seeders\ConfigSeeder::class);
    
    $response = $this->get('/');

    $response->assertStatus(200);
});
