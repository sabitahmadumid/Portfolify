<?php

namespace App\Livewire;

use Livewire\Component;
use Awcodes\Curator\Models\Media;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Awcodes\Curator\Components\Modals\CuratorModal;

class EnhancedRichEditor extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public string $content = '';
    public string $name = 'content';
    public bool $required = false;
    public ?string $label = null;
    public array $toolbarButtons = [];

    public function mount(
        string $content = '', 
        string $name = 'content', 
        bool $required = false, 
        ?string $label = null,
        array $toolbarButtons = []
    ): void {
        $this->content = $content;
        $this->name = $name;
        $this->required = $required;
        $this->label = $label;
        $this->toolbarButtons = empty($toolbarButtons) ? [
            'attachFiles',
            'blockquote',
            'bold',
            'bulletList',
            'codeBlock',
            'h1',
            'h2',
            'h3',
            'italic',
            'link',
            'orderedList',
            'redo',
            'strike',
            'table',
            'underline',
            'undo',
        ] : $toolbarButtons;
    }

    public function insertMediaAction(): Action
    {
        return Action::make('insertMedia')
            ->label('Insert Media')
            ->icon('heroicon-o-photo')
            ->modalHeading('Select Media')
            ->modalWidth('5xl')
            ->form([
                \Awcodes\Curator\Components\Forms\CuratorPicker::make('media')
                    ->label('Select Media')
                    ->multiple()
                    ->buttonLabel('Select Images')
                    ->color('primary'),
            ])
            ->action(function (array $data): void {
                if (empty($data['media'])) {
                    return;
                }

                $mediaItems = Media::whereIn('id', $data['media'])->get();
                $insertText = '';

                foreach ($mediaItems as $media) {
                    $url = $media->url;
                    $alt = $media->alt ?? $media->name;
                    
                    if ($media->type === 'image') {
                        $insertText .= "<p><img src=\"{$url}\" alt=\"{$alt}\" style=\"max-width: 100%; height: auto;\"></p>";
                    } else {
                        $insertText .= "<p><a href=\"{$url}\" target=\"_blank\">{$media->name}</a></p>";
                    }
                }

                $this->dispatch('insert-content', content: $insertText);
            });
    }

    public function insertTableAction(): Action
    {
        return Action::make('insertTable')
            ->label('Insert Table')
            ->icon('heroicon-o-table-cells')
            ->form([
                \Filament\Forms\Components\TextInput::make('rows')
                    ->label('Rows')
                    ->numeric()
                    ->default(3)
                    ->required()
                    ->minValue(1)
                    ->maxValue(20),
                \Filament\Forms\Components\TextInput::make('cols')
                    ->label('Columns')
                    ->numeric()
                    ->default(3)
                    ->required()
                    ->minValue(1)
                    ->maxValue(10),
                \Filament\Forms\Components\Toggle::make('header')
                    ->label('Include header row')
                    ->default(true),
            ])
            ->action(function (array $data): void {
                $rows = (int) $data['rows'];
                $cols = (int) $data['cols'];
                $hasHeader = $data['header'] ?? false;

                $table = '<table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">';
                
                for ($i = 0; $i < $rows; $i++) {
                    $table .= '<tr>';
                    $cellTag = ($i === 0 && $hasHeader) ? 'th' : 'td';
                    $cellStyle = ($i === 0 && $hasHeader) 
                        ? 'style="border: 1px solid #ddd; padding: 8px; background-color: #f5f5f5; font-weight: bold;"'
                        : 'style="border: 1px solid #ddd; padding: 8px;"';
                    
                    for ($j = 0; $j < $cols; $j++) {
                        $table .= "<{$cellTag} {$cellStyle}>&nbsp;</{$cellTag}>";
                    }
                    $table .= '</tr>';
                }
                
                $table .= '</table><p>&nbsp;</p>';

                $this->dispatch('insert-content', content: $table);
            });
    }

    public function render()
    {
        return view('livewire.enhanced-rich-editor');
    }
}