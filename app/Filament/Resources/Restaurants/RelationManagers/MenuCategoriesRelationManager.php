<?php

namespace App\Filament\Resources\Restaurants\RelationManagers;

use App\Filament\Forms\Locales;
use App\Filament\Resources\MenuCategories\MenuCategoryResource;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Unique;

class MenuCategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'menuCategories';

    protected static ?string $title = 'Меню — категории';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedListBullet;

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Html::make(new HtmlString(
                    '<div id="restaurant-menu" data-restaurant-menu-rm class="scroll-mt-8"></div>'
                )),
                $this->getTabsContentComponent(),
                RenderHook::make(PanelsRenderHook::RESOURCE_RELATION_MANAGER_BEFORE),
                EmbeddedTable::make(),
                RenderHook::make(PanelsRenderHook::RESOURCE_RELATION_MANAGER_AFTER),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Категория')
                    ->columns(2)
                    ->schema([
                        TextInput::make('key')
                            ->label('Key')
                            ->required()
                            ->maxLength(255)
                            ->unique(
                                table: 'menu_categories',
                                column: 'key',
                                ignoreRecord: true,
                                modifyRuleUsing: function (Unique $rule): Unique {
                                    return $rule->where('restaurant_id', $this->getOwnerRecord()->getKey());
                                },
                            ),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                    ]),
                Locales::text('label', 'Название', required: true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('key')
            ->columns([
                TextColumn::make('label')
                    ->label('Название (EN)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('label', 'en'))
                    ->searchable(false),
                TextColumn::make('key')
                    ->label('Key')
                    ->badge(),
                TextColumn::make('items_count')
                    ->label('Позиций')
                    ->counts('items'),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->paginated([10, 25, 50])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('items')
                    ->label('Позиции')
                    ->icon(Heroicon::OutlinedQueueList)
                    ->url(fn ($record) => MenuCategoryResource::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}