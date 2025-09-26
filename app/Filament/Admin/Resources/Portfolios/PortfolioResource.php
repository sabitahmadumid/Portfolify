<?php

namespace App\Filament\Admin\Resources\Portfolios;

use App\Filament\Admin\Resources\Portfolios\Pages\CreatePortfolio;
use App\Filament\Admin\Resources\Portfolios\Pages\EditPortfolio;
use App\Filament\Admin\Resources\Portfolios\Pages\ListPortfolios;
use App\Filament\Admin\Resources\Portfolios\Schemas\PortfolioForm;
use App\Filament\Admin\Resources\Portfolios\Tables\PortfoliosTable;
use App\Models\Portfolio;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Projects';

    protected static ?string $modelLabel = 'Project';

    protected static ?string $pluralModelLabel = 'Projects';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-briefcase';
    }

    public static function form(Schema $schema): Schema
    {
        return PortfolioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortfoliosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPortfolios::route('/'),
            'create' => CreatePortfolio::route('/create'),
            'edit' => EditPortfolio::route('/{record}/edit'),
        ];
    }
}
