<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ 
        state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }},
        isLoading: false,
        insertMedia: function(mediaId) {
            // Implementation for inserting media into the editor
            this.insertMediaAtCursor(mediaId);
        },
        insertMediaAtCursor: function(mediaId) {
            // This would integrate with the rich editor to insert media
            console.log('Inserting media:', mediaId);
        }
    }">
        @if($hasMediaIntegration())
        <div class="mb-2">
            <x-filament::button
                size="sm"
                color="gray"
                @click="$dispatch('open-modal', { id: 'media-picker' })"
            >
                <x-heroicon-o-photo class="h-4 w-4 mr-1" />
                Insert Media
            </x-filament::button>
        </div>
        @endif
        
        <div {{ $attributes->merge($getExtraAttributes())->class([
            'filament-forms-rich-editor-component'
        ]) }}>
            <x-filament-forms::rich-editor 
                :state-path="$getStatePath()"
                :toolbar-buttons="$getToolbarButtons()"
                :placeholder="$getPlaceholder()"
                :disabled="$isDisabled()"
                :extra-input-attributes="$getExtraInputAttributes()"
                :file-attachments-disk="$getFileAttachmentsDisk()"
                :file-attachments-directory="$getFileAttachmentsDirectory()"
                :file-attachments-visibility="$getFileAttachmentsVisibility()"
            />
        </div>
    </div>
</x-dynamic-component>