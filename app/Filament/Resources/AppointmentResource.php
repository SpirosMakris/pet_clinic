<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    Forms\Components\Section::make([
                        Forms\Components\DatePicker::make('date')
                            ->native(false)
                            ->live(onBlur: true)
                            ->autofocus()
                            ->displayFormat('F j, Y')
                            ->required()
                            ->placeholder(__('Date')),
                        Forms\Components\TimePicker::make('start')
                            // ->native(false)
                            ->live(onBlur: true)
                            ->required()
                            ->seconds(false)
                            ->minutesStep(15)
                            ->closeOnDateSelection(true)
                            ->datalist([
                                '09:00',
                                '09:30',
                                '10:00',
                                '10:30',
                                '11:00',
                                '11:30',
                                '12:00',
                            ])
                            ->displayFormat('g:i A')
                            ->placeholder(__('Start time')),
                        Forms\Components\TimePicker::make('end')
                            ->native(false)
                            ->live(onBlur: true)
                            ->required()
                            ->seconds(false)
                            ->minutesStep(15)
                            ->displayFormat('g:i A')
                            ->placeholder(__('End time')),
                        Forms\Components\Select::make('pet_id')
                            ->native(false)
                            ->live(onBlur: true)
                            ->relationship('pet', 'name')
                            ->placeholder(__('Pet'))
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('description')
                            ->live(onBlur: true)
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('Description')),
                        Forms\Components\Select::make('status')
                            ->native(false)
                            ->options(AppointmentStatus::class)
                            ->default(AppointmentStatus::CREATED)
                            ->visibleOn(Pages\EditAppointment::class)
                            ->placeholder(__('Status')),
                    ]),
                ]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start')
                    ->time('g:i A')
                    ->label(__('From'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->time('g:i A')
                    ->label(__('To'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Confirm')
                    ->action(function (Appointment $record) {
                        $record->update([
                            'status' => AppointmentStatus::CONFIRMED,
                        ]);
                    })
                    ->visible(fn (Appointment $record) => $record->status === AppointmentStatus::CREATED)
                    ->color('success')
                    ->icon('heroicon-s-check'),
                Tables\Actions\Action::make('Cancel')
                    ->action(function (Appointment $record) {
                        $record->update([
                            'status' => AppointmentStatus::CANCELLED,
                        ]);
                    })
                    ->visible(fn (Appointment $record) => $record->status !== AppointmentStatus::CANCELLED)
                    ->color('danger')
                    ->badge()
                    ->icon('heroicon-o-x-mark'),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
