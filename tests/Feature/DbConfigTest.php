<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('db_config helper can retrieve configuration values', function () {
    // Seed the configuration data
    $this->seed(\Database\Seeders\ConfigSeeder::class);
    
    // Test retrieving blog settings
    $postsPerPage = db_config('blog.posts_per_page', 5);
    expect($postsPerPage)->toBe('10');
    
    // Test retrieving general settings
    $siteName = db_config('general.site_name', 'Default Site');
    expect($siteName)->toBe('Portfolify');
    
    // Test retrieving SEO settings
    $metaTitle = db_config('seo.default_meta_title', 'Default Title');
    expect($metaTitle)->toBe('Portfolify - Modern Portfolio & Blog');
    
    // Test default values for non-existent keys
    $nonExistent = db_config('nonexistent.key', 'default_value');
    expect($nonExistent)->toBe('default_value');
});

test('blog controller uses db_config for posts per page', function () {
    // Seed the configuration data
    $this->seed(\Database\Seeders\ConfigSeeder::class);
    
    // Test that the blog page loads successfully (it uses db_config internally)
    $response = $this->get('/blog');
    
    $response->assertStatus(200);
});