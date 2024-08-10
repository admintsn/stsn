<?php

namespace App\Filament\Tsn\Resources\Imtihan;

use App\Filament\Tsn\Resources\Imtihan\NilaiTulisLisanResource\Pages;
use App\Filament\Tsn\Resources\Imtihan\NilaiTulisLisanResource\RelationManagers;
use App\Models\Nilai;
use App\Models\NilaiTulisLisan;
use App\Models\Pengajar;
use App\Models\TahunBerjalan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class NilaiTulisLisanResource extends Resource
{

    public static function canViewAny(): bool
    {

        if (auth()->user()->id === 1 || auth()->user()->id === 2) {
            return true;
        } else {

            $cek = Nilai::whereHas('pengajar', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
                ->where('jenis_soal_id', 4)->count();

            if ($cek !== 0) {

                return true;
            } else {

                return false;
            }
        }
    }

    protected static ?string $navigationGroup = 'Nilai Imtihan';

    protected static ?int $navigationSort = 03010;

    protected static ?string $modelLabel = 'Nilai Tulis/Lisan';

    protected static ?string $navigationLabel = 'Nilai Tulis/Lisan';

    protected static ?string $pluralModelLabel = 'Nilai Tulis/Lisan';

    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon = 'heroicon-s-document';

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
            ->heading('Daftar mata pelajaran yang diampu')
            ->description(new HtmlString('<div>
            <table class="table w-fit">
            <!-- head -->
            <thead>
                <tr>
                    <th class="text-tsn-header text-xs" colspan="2"></th>
                </tr>
            </thead>
            <tbody>
            <tr>
            <th class="text-xs align-top">-</th>
            <td class="text-xs">Klik "Input" untuk mulai input nilai</td>
            </tr>
            <tr>
            <th class="text-xs align-top">-</th>
            <td class="text-xs">Centang Status untuk menandai bahwa input nilai telah selesai</td>
            </tr>
            <tr>
            <th class="text-xs align-top">-</th>
            <td class="text-xs">Jika terdapat data yang kurang sesuai, harap disampaikan ke admin agar direvisi oleh admin</td>
            </tr>
            </tbody>
            </table>
                                </div>'))
            ->recordUrl(null)
            ->defaultPaginationPageOption('all')
            // ->striped()
            ->columns([

                TextColumn::make('file_nilai')
                    ->label('Link')
                    ->formatStateUsing(fn (string $state): string => __("Input"))
                    ->icon('heroicon-s-pencil-square')
                    ->iconColor('success')
                    // ->circular()
                    ->alignCenter()
                    ->url(function (Model $record) {
                        if ($record->file_nilai !== null) {

                            return ($record->file_nilai);
                        }
                    })
                    ->badge()
                    ->color('info')
                    ->openUrlInNewTab(),

                CheckboxColumn::make('is_nilai_selesai')
                    ->label('Status')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('kelas.kelas')
                    ->label('Kelas')
                    ->sortable(),

                TextColumn::make('mapel.mapel')
                    ->label('Mapel')
                    ->sortable(),

                TextColumn::make('kode_soal')
                    ->label('Kode Soal')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pengajar.nama')
                    ->label('Nama Pengajar')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->groups([
                Group::make('qismDetail.abbr_qism_detail')
                    ->titlePrefixedWithLabel(false)
            ])

            ->defaultGroup('qismDetail.abbr_qism_detail')
            ->groupingSettingsHidden()
            ->defaultSort('kode_soal')
            ->filters([

                SelectFilter::make('qism_detail_id')
                    ->label('Qism')
                    ->multiple()
                    ->options([
                        '1' => 'TAPa',
                        '2' => 'TAPi',
                        '3' => 'PTPa',
                        '4' => 'PTPi',
                        '5' => 'TQPa',
                        '6' => 'TQPi',
                        '7' => 'IDD',
                        '8' => 'MTW',
                        '9' => 'TN',
                    ])
                    ->hidden(auth()->user()->id !== 1 || auth()->user()->id !== 2),

                SelectFilter::make('kelas_id')
                    ->label('Kelas')
                    ->multiple()
                    ->options([
                        '1' => 'Kelas 1',
                        '2' => 'Kelas 2',
                        '3' => 'Kelas 3',
                        '4' => 'Kelas 4',
                        '5' => 'Kelas 5',
                        '6' => 'Kelas 6',
                        '7' => 'Kelas A',
                        '8' => 'Kelas B',
                        '9' => 'Kelas MTW',
                    ])
                    ->hidden(auth()->user()->id !== 1 || auth()->user()->id !== 2),

                Filter::make('is_nilai_selesai')
                    ->label('Nilai Selesai')
                    ->query(fn (Builder $query): Builder => $query->where('is_nilai_selesai', 1))
                    ->hidden(auth()->user()->id !== 1 || auth()->user()->id !== 2),

                Filter::make('Nilai Belum Selesai')
                    ->label('Nilai Belum Selesai')
                    ->query(fn (Builder $query): Builder => $query->where('is_nilai_selesai', 0))
                    ->hidden(auth()->user()->id !== 1 || auth()->user()->id !== 2),

            ], layout: FiltersLayout::AboveContent)
            ->actions([])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                // Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->emptyStateHeading('Tidak ada data')
            ->emptyStateIcon('heroicon-o-book-open');
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
            'index' => Pages\ListNilaiTulisLisans::route('/'),
            'create' => Pages\CreateNilaiTulisLisan::route('/create'),
            'view' => Pages\ViewNilaiTulisLisan::route('/{record}'),
            'edit' => Pages\EditNilaiTulisLisan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $tahunberjalan = TahunBerjalan::where('is_active', 1)->first();

        if (Auth::user()->id === 1 or Auth::user()->id === 2) {
            return parent::getEloquentQuery()->where('jenis_soal_id', 4)->where('is_nilai', 1)->where('tahun_berjalan_id', $tahunberjalan->id);
        } else {

            return parent::getEloquentQuery()->whereHas('pengajar', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->where('jenis_soal_id', 4)->where('is_nilai', 1)->where('tahun_berjalan_id', $tahunberjalan->id);
        }
    }
}
