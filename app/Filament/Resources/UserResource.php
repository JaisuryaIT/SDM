<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset as ComponentsFieldset;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $activeNavigationIcon = 'heroicon-s-users';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('User Details')->schema([Group::make([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->required()->email(),
                    TextInput::make('password')->required()->password()->dehydrateStateUsing(fn (string $state): string => Hash::make($state))->dehydrated(fn (?string $state): bool => filled($state))->revealable(),
                ])->columnSpan(4)->columns(2),
                Group::make([
                Toggle::make('is_admin')->label('Is Admin')
                ->onColor('primary')
                ->offColor('warning')->inline(false)
                ])->visibleOn('view')
                ])->columns(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('')->rowIndex(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->wrap()->icon('heroicon-m-envelope')->iconColor('primary'),
                TextColumn::make('created_at')->label('Created On')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Updated On')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_admin')->label('Is Admin')
            ])->defaultSort('updated_at', 'desc')
            ->filters([
                TernaryFilter::make('is_admin')
                ->label('Users')
                ->placeholder('All Users')
                ->trueLabel('Admin User')
                ->falseLabel('Normal User')
                ->native(0)
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->successNotification(
                        Notification::make()
                            ->danger()
                            ->title('User Deleted'),
                    )
                ])->tooltip('Actions')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsFieldset::make('User Details')->schema([
                    ComponentsGroup::make([
                        TextEntry::make('name'),
                        TextEntry::make('email')->icon('heroicon-m-envelope')->iconColor('primary')
                    ])->columnSpan(3)->columns(2),
                    ComponentsGroup::make([
                    TextEntry::make('is_admin')->label('User Role')->getStateUsing(function (Model $record) {
                        return ($record->is_admin) ? 'Admin User' : 'Normal User';
                    })
                    ])
                    ])->columns(4)
            ]);
    }
    public static function getRelations(): array
    {
        return [
        ];
    }
    

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
