<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Filament\Resources\PetResource\RelationManagers;
use App\Models\Owner;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\PetType;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\search;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\FileUpload::make('avatar')
                        ->image()
                        ->directory('pets/avatars')
                        ->imageEditor(),
                    Forms\Components\TextInput::make('name')
                        ->autofocus()
                        ->live(onBlur: true)
                        ->required()
                        ->maxLength(255)
                        ->placeholder(__('Name')),
                    Forms\Components\DatePicker::make('date_of_birth')
                        ->native(false)
                        ->displayFormat('F j, Y')
                        ->required()
                        ->placeholder(__('Date of Birth')),
                    Forms\Components\Select::make('type')
                        ->native(false)
                        ->options(PetType::class)
                        ->default(PetType::Dog)
                        ->placeholder(__('Pet Type')),
                    Forms\Components\Select::make('owner_id')
                        ->native(false)
                        ->relationship('owner', 'name')
                        ->placeholder(__('Owner'))
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            // Same as OnwerResource form schema
                            Forms\Components\TextInput::make('name')
                                ->autofocus()
                                ->live(onBlur: true)
                                ->required()
                                ->maxLength(255)
                                ->placeholder(__('Name')),
                            Forms\Components\TextInput::make('email')
                                ->live(onBlur: true)
                                ->email()
                                ->required()
                                ->unique(Owner::class, 'email', ignoreRecord: true)
                                ->maxLength(255)
                                ->placeholder(__('Email')),
                            Forms\Components\TextInput::make('phone')
                                ->live(onBlur: true)
                                ->tel()
                                ->required()
                                ->maxLength(255)
                                ->placeholder(__('Phone')),
                        ])
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->url(fn (Pet $pet) => $pet->avatarUrl)
                    ->label(__('Avatar')),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('Name')),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable()
                    ->label(__('Type')),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date('F j, Y')
                    ->sortable()
                    ->label(__('Date of Birth')),
                Tables\Columns\TextColumn::make('owner.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('Owner')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Pet $record) {
                        // Delete the avatar file
                        $avatar_file = 'public/' . $record->avatar;
                        Log::info('Deleting avatar file: ' . $avatar_file);
                        Storage::delete($avatar_file);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title(__('Pet deleted'))
                            ->body(__('Pet has been deleted.')),
                    )
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
