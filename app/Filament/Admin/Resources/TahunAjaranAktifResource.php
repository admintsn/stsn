<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TahunAjaranAktifResource\Pages;
use App\Filament\Admin\Resources\TahunAjaranAktifResource\RelationManagers;
use App\Models\Qism;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\TahunAjaranAktif;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TahunAjaranAktifResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->id == 1;
    }

    protected static ?string $navigationGroup = 'TSN Configs';

    protected static ?int $navigationSort = 98030;

    protected static ?string $modelLabel = 'Tahun Ajaran Aktif';

    protected static ?string $navigationLabel = 'Tahun Ajaran Aktif';

    protected static ?string $pluralModelLabel = 'Tahun Ajaran Aktif';

    protected static ?string $model = TahunAjaranAktif::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('qism_id')
                    ->label('Qism')
                    ->options(Qism::all()->pluck('abbr_qism', 'id'))
                    ->native(false),

                Select::make('tahun_ajaran_id')
                    ->label('Tahun Ajaran')
                    ->options(TahunAjaran::all()->pluck('abbr_ta', 'id'))
                    ->native(false),

                Select::make('semester_id')
                    ->label('Semester')
                    ->options(Semester::all()->pluck('semester', 'id'))
                    ->native(false),

                Toggle::make('is_active')
                    ->label('Status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('qism.abbr_qism')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahunAjaran.abbr_ta')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.semester')
                    ->sortable(),
                ToggleColumn::make('is_active'),
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
            'index' => Pages\ListTahunAjaranAktifs::route('/'),
            'create' => Pages\CreateTahunAjaranAktif::route('/create'),
            'edit' => Pages\EditTahunAjaranAktif::route('/{record}/edit'),
        ];
    }
}
