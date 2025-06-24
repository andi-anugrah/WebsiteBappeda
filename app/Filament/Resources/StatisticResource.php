<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatisticResource\Pages;
use App\Models\Statistic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StatisticResource extends Resource
{
    protected static ?string $model = Statistic::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Statistik';

    protected static ?string $modelLabel = 'Statistik';

    protected static ?string $pluralModelLabel = 'Statistik';

    // protected static ?string $navigationGroup = 'Data Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Statistik')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Nama unik untuk identifikasi statistik (contoh: jumlah_penduduk)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('label')
                            ->label('Label Tampilan')
                            ->required()
                            ->helperText('Label yang akan ditampilkan di website')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('value')
                            ->label('Nilai')
                            ->required()
                            ->helperText('Nilai statistik (contoh: 351085, 84.85, 3.29)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('unit')
                            ->label('Satuan')
                            ->helperText('Satuan nilai (contoh: %, orang, program)')
                            ->maxLength(50),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka untuk menentukan urutan tampil (semakin kecil semakin atas)'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->width(80),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Key')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('unit')
                    ->label('Satuan')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStatistics::route('/'),
            'create' => Pages\CreateStatistic::route('/create'),
            'edit' => Pages\EditStatistic::route('/{record}/edit'),
        ];
    }
}