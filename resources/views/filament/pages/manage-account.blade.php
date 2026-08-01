<x-filament-panels::page>
    <style>
        .lum-admin-avatar-field {
            display: flex;
            justify-content: center;
        }

        /* FilePond circle layout nudges the centered spinner with margin-left:.1875em */
        .lum-admin-avatar-field .filepond--root[data-style-panel-layout~='circle'] .filepond--load-indicator[data-align*='center'],
        .lum-admin-avatar-field .filepond--root[data-style-panel-layout~='circle'] .filepond--progress-indicator[data-align*='center'] {
            margin-left: 0 !important;
            margin-right: 0 !important;
            left: 50% !important;
            right: auto !important;
            transform: translateX(-50%);
        }

        .lum-admin-avatar-field .filepond--root[data-style-panel-layout~='circle'] .filepond--file-action-button[data-align*='center'] {
            margin-left: 0 !important;
            left: 50% !important;
            right: auto !important;
            transform: translateX(-50%);
        }
    </style>

    <form wire:submit="save" class="space-y-4">
        {{ $this->form }}
    </form>
</x-filament-panels::page>
