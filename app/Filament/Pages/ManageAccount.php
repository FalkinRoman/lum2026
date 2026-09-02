<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use UnitEnum;

class ManageAccount extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected static ?string $navigationLabel = 'Аккаунт';

    protected static ?int $navigationSort = 94;

    protected static ?string $title = 'Аккаунт';

    protected string $view = 'filament.pages.manage-account';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();

        $this->form->fill([
            'avatar' => $user?->avatar,
            'name' => $user?->name,
            'email' => $user?->email,
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Профиль')
                    ->schema([
                        FileUpload::make('avatar')
                            ->hiddenLabel()
                            ->disk('lum')
                            ->directory('avatars')
                            ->visibility('public')
                            ->avatar()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->nullable(),
                        TextInput::make('name')->label('Имя')->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->rules(fn () => [
                                Rule::unique('users', 'email')->ignore(auth()->id()),
                            ]),
                    ]),

                Section::make('Пароль')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Текущий пароль')
                            ->password()
                            ->revealable()
                            ->autocomplete('current-password'),
                        TextInput::make('password')
                            ->label('Новый пароль')
                            ->password()
                            ->revealable()
                            ->rule(Password::defaults())
                            ->confirmed()
                            ->dehydrated(fn ($state) => filled($state))
                            ->autocomplete('new-password'),
                        TextInput::make('password_confirmation')
                            ->label('Повтор пароля')
                            ->password()
                            ->revealable()
                            ->dehydrated(false)
                            ->autocomplete('new-password'),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Сохранить')
                ->icon(Heroicon::OutlinedCheck)
                ->action('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $nameChanged = ($state['name'] ?? '') !== $user->name;
        $emailChanged = ($state['email'] ?? '') !== $user->email;
        $passwordChanging = filled($state['password'] ?? null);
        $needsPassword = $nameChanged || $emailChanged || $passwordChanging;

        if ($needsPassword) {
            $rateKey = 'manage-account-password:'.auth()->id();

            if (RateLimiter::tooManyAttempts($rateKey, 5)) {
                Notification::make()
                    ->title('Слишком много попыток. Подождите 15 минут.')
                    ->danger()
                    ->send();

                return;
            }

            if (! Hash::check((string) ($state['current_password'] ?? ''), $user->password)) {
                RateLimiter::hit($rateKey, 900);

                Notification::make()
                    ->title('Неверный текущий пароль')
                    ->danger()
                    ->send();

                return;
            }

            RateLimiter::clear($rateKey);
        }

        $user->avatar = $state['avatar'] ?? null;
        $user->name = $state['name'];
        $user->email = $state['email'];

        if ($passwordChanging) {
            $user->password = $state['password'];
        }

        $user->save();

        if ($passwordChanging) {
            auth()->logoutOtherDevices((string) $state['current_password']);
        }

        $user->refresh();
        auth()->setUser($user);

        $this->form->fill([
            'avatar' => $user->avatar,
            'name' => $user->name,
            'email' => $user->email,
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // Topbar / sidebar are separate Livewire components — force re-render.
        $this->dispatch('refresh-topbar');
        $this->dispatch('refresh-sidebar');

        Notification::make()
            ->title('Аккаунт обновлён')
            ->success()
            ->send();
    }
}
