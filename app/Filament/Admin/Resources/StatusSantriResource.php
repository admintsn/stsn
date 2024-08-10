<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StatusSantriResource\Pages;
use App\Filament\Admin\Resources\StatusSantriResource\RelationManagers;
use App\Models\StatusSantri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusSantriResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->id == 1;
    }

    protected static ?string $navigationGroup = 'Kesantrian';

    protected static ?int $navigationSort = 04030;

    protected static ?string $modelLabel = 'Status Santri';

    protected static ?string $navigationLabel = 'Status Santri';

    protected static ?string $pluralModelLabel = 'Status Santri';

    protected static ?string $model = StatusSantri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('santri_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ket_status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keterangan_status_santri_id')
                    ->numeric(),
                Forms\Components\TextInput::make('naikqism')
                    ->maxLength(50),
                Forms\Components\DatePicker::make('tanggalupdate'),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('santri.nism')
                    ->label('NISM')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('santri.kartu_keluarga')
                    ->label('KK')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('santri.nama_lengkap')
                    ->sortable(),

                TextColumn::make('status')
                    ->searchable(isIndividual: true),

                TextColumn::make('ket_status')
                    ->searchable(isIndividual: true),

                TextColumn::make('kss.keterangan')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('naikqism')
                    ->searchable(isIndividual: true),

                TextColumn::make('tanggalupdate')
                    ->date()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListStatusSantris::route('/'),
            'create' => Pages\CreateStatusSantri::route('/create'),
            'edit' => Pages\EditStatusSantri::route('/{record}/edit'),
        ];
    }
}
