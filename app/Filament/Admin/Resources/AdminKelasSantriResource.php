<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdminKelasSantriResource\Pages;
use App\Filament\Admin\Resources\AdminKelasSantriResource\RelationManagers;
use App\Models\AdminKelasSantri;
use App\Models\KelasSantri;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Qism;
use App\Models\QismDetail;
use App\Models\QismDetailHasKelas;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\TahunBerjalan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class AdminKelasSantriResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->id == 1;
    }

    protected static ?string $navigationGroup = 'Kesantrian';

    protected static ?int $navigationSort = 04010;

    protected static ?string $modelLabel = 'Kelas Santri';

    protected static ?string $navigationLabel = 'Kelas Santri';

    protected static ?string $pluralModelLabel = 'Kelas Santri';

    protected static ?string $model = KelasSantri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([

                TextColumn::make('santri_id')
                    ->label('Santri ID')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->sortable(),

                TextColumn::make('santri.nism')
                    ->label('Santri-NISM')
                    ->searchable(isIndividual: true)
                    ->extraAttributes([
                        'style' => 'width:150px'
                    ])
                    ->sortable(),

                SelectColumn::make('qism_detail_id')
                    ->label('Qism Detail')
                    ->options(QismDetail::all()->pluck('abbr_qism_detail', 'id'))
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width:150px'
                    ]),

                SelectColumn::make('kelas_id')
                    ->label('Kelas')
                    ->options(Kelas::all()->pluck('kelas', 'id'))
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width:150px'
                    ]),

                TextInputColumn::make('kelas_internal')
                    ->label('Kelas Internal')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    // ->toggledHiddenByDefault(true)
                    ->extraAttributes([
                        'style' => 'width:150px'
                    ])
                    ->sortable(),

                TextColumn::make('santri.nama_lengkap')
                    ->label('Santri')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('walisantri.ak_nama_lengkap')
                    ->label('Nama Walisantri')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('walisantri.user.id')
                    ->label('User ID')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->sortable(),

                TextInputColumn::make('walisantri.user.username')
                    ->label('Username')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->extraAttributes([
                        'style' => 'width:200px'
                    ])
                    ->sortable(),

                TextColumn::make('user.tsnunique')
                    ->label('tsnunique')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->sortable(),

                TextColumn::make('walisantri.ak_nama_kunyah')
                    ->label('Nama Hijroh')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->sortable(),

                TextInputColumn::make('kartu_keluarga')
                    ->label('KelasSantri-KK')
                    ->searchable(isIndividual: true)
                    ->extraAttributes([
                        'style' => 'width:200px'
                    ])
                    ->sortable(),

                SelectColumn::make('tahun_berjalan_id')
                    ->label('Tahun Berjalan')
                    ->options(TahunBerjalan::all()->pluck('tb', 'id'))
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width:200px'
                    ]),

                SelectColumn::make('tahun_ajaran_id')
                    ->label('Tahun Ajaran')
                    ->options(TahunAjaran::all()->pluck('abbr_ta', 'id'))
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width:200px'
                    ]),

                SelectColumn::make('semester_id')
                    ->label('Semester')
                    ->options(Semester::all()->pluck('abbr_semester', 'id'))
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width:200px'
                    ]),

                SelectColumn::make('qism_id')
                    ->label('Qism')
                    ->options(Qism::all()->pluck('abbr_qism', 'id'))
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width:200px'
                    ]),



                TextColumn::make('walisantri_id')
                    ->label('Walisantri ID')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->sortable(),

                TextInputColumn::make('walisantri.ak_no_kk')
                    ->label('Walisantri-KK')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->extraAttributes([
                        'style' => 'width:200px'
                    ])
                    ->sortable(),



            ])
            ->filters([

                SelectFilter::make('qism_detail_id')
                    ->label('Qism')
                    ->multiple()
                    ->options(QismDetail::all()->pluck('abbr_qism_detail', 'id')),

                SelectFilter::make('tahun_berjalan_id')
                    ->label('Tahun Berjalan')
                    ->multiple()
                    ->options(TahunBerjalan::all()->pluck('tb', 'id')),

                SelectFilter::make('kelas_id')
                    ->label('Kelas')
                    ->multiple()
                    ->options(Kelas::all()->pluck('kelas', 'id')),


            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

                Tables\Actions\BulkAction::make('updatewsid')
                    ->label(__('Update Walisantri ID'))
                    ->color('success')
                    // ->requiresConfirmation()
                    // ->modalIcon('heroicon-o-check-circle')
                    // ->modalIconColor('success')
                    // ->modalHeading('Simpan data santri tinggal kelas?')
                    // ->modalDescription('Setelah klik tombol "Simpan", maka status akan berubah')
                    // ->modalSubmitActionLabel('Simpan')
                    ->action(fn(Collection $records, array $data) => $records->each(
                        function ($record) {

                            $wsid = Santri::where('id', $record->santri_id)->first();

                            if ($wsid === null) {
                                return;
                            } elseif ($wsid !== null) {
                                // dd($record->santri_id, $wsid->walisantri_id);
                                // $walisantriid = KelasSantri::where('santri_id', $record->santri_id)->get();
                                // $walisantriid->walisantri_id = $wsid->walisantri_id;
                                // $walisantriid->save();

                                $data['walisantri_id'] = $wsid->walisantri_id;
                                $record->update($data);

                                return $record;
                            }
                            // Notification::make()
                            //     // ->success()
                            //     ->title('Walisantri ID berhasil diupdate')
                            //     ->icon('heroicon-o-exclamation-triangle')
                            //     ->iconColor('danger')
                            //     ->color('warning')
                            //     ->send();
                        }
                    ))
                    ->deselectRecordsAfterCompletion(),

                Tables\Actions\BulkAction::make('updatekk')
                    ->label(__('Update KK'))
                    ->color('success')
                    // ->requiresConfirmation()
                    // ->modalIcon('heroicon-o-check-circle')
                    // ->modalIconColor('success')
                    // ->modalHeading('Simpan data santri tinggal kelas?')
                    // ->modalDescription('Setelah klik tombol "Simpan", maka status akan berubah')
                    // ->modalSubmitActionLabel('Simpan')
                    ->action(fn(Collection $records, array $data) => $records->each(
                        function ($record) {

                            $wsid = Santri::where('id', $record->santri_id)->first();

                            if ($wsid === null) {
                                return;
                            } elseif ($wsid !== null) {
                                // dd($record->santri_id, $wsid->walisantri_id);
                                // $walisantriid = KelasSantri::where('santri_id', $record->santri_id)->get();
                                // $walisantriid->walisantri_id = $wsid->walisantri_id;
                                // $walisantriid->save();

                                $data['kartu_keluarga'] = $wsid->kartu_keluarga;
                                $record->update($data);

                                return $record;
                            }
                            // Notification::make()
                            //     // ->success()
                            //     ->title('Walisantri ID berhasil diupdate')
                            //     ->icon('heroicon-o-exclamation-triangle')
                            //     ->iconColor('danger')
                            //     ->color('warning')
                            //     ->send();
                        }
                    ))
                    ->deselectRecordsAfterCompletion(),

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
            'index' => Pages\ListAdminKelasSantris::route('/'),
            'create' => Pages\CreateAdminKelasSantri::route('/create'),
            'view' => Pages\ViewAdminKelasSantri::route('/{record}'),
            'edit' => Pages\EditAdminKelasSantri::route('/{record}/edit'),
        ];
    }
}
