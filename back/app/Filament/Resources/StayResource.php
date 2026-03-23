<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StayResource\Pages;
use App\Filament\Resources\StayResource\RelationManagers;
use App\Filament\Resources\StayResource\RelationManagers\StayRoomsRelationManager;
use App\Filament\Resources\StayResource\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\StayResource\RelationManagers\ServiceChargesRelationManager;
use App\Models\Stay;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class StayResource extends Resource
{
    protected static ?string $model = Stay::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('guest_id')
                    ->relationship('guest', 'first_name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('reservation_id')
                    ->relationship('reservation', 'id')
                    ->searchable(),
                Forms\Components\DateTimePicker::make('check_in_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('check_out_date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'checked_out' => 'Checked Out',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('guest.first_name')
                    ->label('Guest')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('reservation_id')
                    ->label('Res #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'primary' => 'active',
                        'success' => 'checked_out',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('check_out')
                    ->label('Check Out')
                    ->icon('heroicon-o-logout')
                    ->color('danger')
                    ->visible(fn (Stay $record) => $record->status === 'active')
                    ->action(function (Stay $record) {
                        DB::transaction(function () use ($record) {
                            // Calculate total duration
                            $checkIn = \Carbon\Carbon::parse($record->check_in_date);
                            $checkOut = now();
                            $days = max(1, $checkIn->diffInDays($checkOut));

                            // Calculate room total
                            $roomTotal = $record->stayRooms->sum(fn ($sr) => $sr->price_per_night * $days);
                            
                            // Calculate service charges
                            $serviceCharges = $record->serviceCharges->sum('amount');

                            $total = $roomTotal + $serviceCharges;

                            // Update Stay
                            $record->update([
                                'status' => 'checked_out',
                                'check_out_date' => $checkOut,
                                'total_price' => $total,
                            ]);

                            // Update rooms status to cleaning
                            foreach ($record->stayRooms as $stayRoom) {
                                $stayRoom->room->update(['status' => 'cleaning']);
                            }
                        });
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('Guest checked out successfully.'),
                Tables\Actions\ViewAction::make(),
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
            StayRoomsRelationManager::class,
            PaymentsRelationManager::class,
            ServiceChargesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStays::route('/'),
            'create' => Pages\CreateStay::route('/create'),
            'view' => Pages\ViewStay::route('/{record}'),
            'edit' => Pages\EditStay::route('/{record}/edit'),
        ];
    }
}
