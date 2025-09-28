<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class WebsiteLinksWidget extends Widget
{
    protected static ?int $sort = 8;

    protected int|string|array $columnSpan = 1;

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.admin.widgets.website-links');
    }
}