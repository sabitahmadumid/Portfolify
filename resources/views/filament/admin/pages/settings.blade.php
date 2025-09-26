<x-filament-panels::page>
    <form wire:submit="save" class="fi-page-content">
        {{ $this->form }}
        
        <div class="mt-6">
            {{ $this->getSaveFormAction() }}
        </div>
    </form>
</x-filament-panels::page>