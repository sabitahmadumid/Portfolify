<?php

use Awcodes\Curator\Models\Media;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('can access curator media table', function () {
    // Test that the curator table exists and is accessible
    $media = Media::query()->get();
    expect($media)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
});

it('can create curator picker component', function () {
    // Test that we can create a CuratorPicker component
    $picker = CuratorPicker::make('test_image');
    expect($picker)->toBeInstanceOf(CuratorPicker::class);
});

it('curator media model has correct table', function () {
    $media = new Media();
    expect($media->getTable())->toBe('curator');
});

it('can query distinct directories from curator table', function () {
    // This is the specific query that was failing in the original error
    $directories = Media::select('directory')->distinct()->whereNotNull('directory')->get();
    expect($directories)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
});