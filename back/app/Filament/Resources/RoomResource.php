<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('room_number')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\Select::make('room_type_id')
                ->relationship('roomType', 'name')
                ->required(),

            Forms\Components\TextInput::make('floor')
                ->numeric(),

            Forms\Components\Select::make('status')
                ->options([
                    'available' => 'Available',
                    'occupied' => 'Occupied',
                    'cleaning' => 'Cleaning',
                    'maintenance' => 'Maintenance',
                ])
                ->default('available')
                ->required(),

            Forms\Components\Textarea::make('notes'),
        ]);
}

  public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('room_number')->searchable(),

            Tables\Columns\TextColumn::make('roomType.name')
                ->label('Type'),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->colors([
                    'success' => 'available',
                    'danger' => 'occupied',
                    'warning' => 'cleaning',
                    'gray' => 'maintenance',
                ]),

            Tables\Columns\TextColumn::make('floor'),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
