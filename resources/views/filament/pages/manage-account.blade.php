<x-filament-panels::page>
    <style>
        .lum-admin-avatar-field {
            display: flex;
            justify-content: center;
        }
    </style>

    <form wire:submit="save" class="space-y-4">
        {{ $this->form }}
    </form>
</x-filament-panels::page>
