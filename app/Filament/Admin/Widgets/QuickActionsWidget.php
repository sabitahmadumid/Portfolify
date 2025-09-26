<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.quick-actions';

    protected static ?int $sort = 7;

    protected int | string | array $columnSpan = 'full';
}