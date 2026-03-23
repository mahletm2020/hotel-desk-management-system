<?php

namespace App\Filament\Resources\StayResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StayRoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'stayRooms';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'room_number')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('price_per_night')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\DateTimePicker::make('check_in')
                    ->required()
                    ->default(now()),
                Forms\Components\DateTimePicker::make('check_out'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('room_id')
            ->columns([
                Tables\Columns\TextColumn::make('room.room_number')
                    ->label('Room #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('check_out')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
