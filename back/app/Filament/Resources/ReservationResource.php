<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use App\Models\Stay;
use App\Models\StayRoom;
use App\Models\Room;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('guest_id')
                ->relationship('guest', 'first_name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('room_id')
                ->relationship('room', 'room_number')
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('check_in_date')
                ->required(),

            Forms\Components\DatePicker::make('check_out_date')
                ->required(),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                    'checked_in' => 'Checked In',
                ])
                ->default('pending'),

            Forms\Components\Textarea::make('notes'),
        ]);
}

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('guest.first_name')
                ->label('Guest')
                ->searchable(),

            Tables\Columns\TextColumn::make('check_in_date'),
            Tables\Columns\TextColumn::make('check_out_date'),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->colors([
                    'warning' => 'pending',
                    'success' => 'confirmed',
                    'danger' => 'cancelled',
                    'primary' => 'checked_in',
                ]),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
        ])
        ->actions([
            Tables\Actions\Action::make('check_in')
                ->label('Check In')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Reservation $record) => $record->status === 'confirmed')
                ->action(function (Reservation $record) {
                    DB::transaction(function () use ($record) {
                        // Create the stay
                        $stay = Stay::create([
                            'guest_id' => $record->guest_id,
                            'reservation_id' => $record->id,
                            'check_in_date' => now(),
                            'check_out_date' => $record->check_out_date,
                            'status' => 'active',
                            'total_price' => $record->total_price ?? 0,
                        ]);

                        // Create the stay room
                        StayRoom::create([
                            'stay_id' => $stay->id,
                            'room_id' => $record->room_id,
                            'price_per_night' => $record->room->roomType->base_price ?? 0,
                            'check_in' => now(),
                        ]);

                        // Update room status
                        $record->room->update(['status' => 'occupied']);

                        // Update reservation status
                        $record->update(['status' => 'checked_in']);
                    });
                })
                ->requiresConfirmation()
                ->successNotificationTitle('Guest checked in successfully.'),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
