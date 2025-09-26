<?php

namespace App\Filament\Components\Forms;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Actions\Action;
use Awcodes\Curator\Models\Media;
use Closure;

class EnhancedRichEditor extends RichEditor
{
    protected string $view = 'filament.components.enhanced-rich-editor';
    
    protected array $customToolbarButtons = [];
    
    public static function make(string $name): static
    {
        $static = parent::make($name);
        
        return $static
            ->toolbarButtons([
                ['bold', 'italic', 'underline', 'strike', 'link'],
                ['h1', 'h2', 'h3'],
                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                ['table', 'attachFiles'],
                ['undo', 'redo'],
            ])
            ->fileAttachmentsDisk('public')
            ->fileAttachmentsDirectory('attachments')
            ->fileAttachmentsVisibility('public')
            ->extraInputAttributes([
                'style' => 'min-height: 300px;'
            ])
            ->placeholder('Start writing your content...');
    }

    public function mediaButton(): static
    {
        $this->customToolbarButtons[] = 'media';
        
        return $this;
    }

    public function getCustomToolbarButtons(): array
    {
        return $this->customToolbarButtons;
    }

    public function withMediaIntegration(): static
    {
        return $this->mediaButton();
    }
}