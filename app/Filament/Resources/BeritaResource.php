<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Models\Berita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Berita')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('author')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama penulis'),

                        DatePicker::make('tgl_publikasi')
                            ->label('Tanggal Publikasi')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Gambar')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Berita')
                            ->image()
                            ->directory('berita')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048) // 2MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Upload gambar dengan ukuran maksimal 2MB. Format yang didukung: JPEG, PNG, WebP'),
                    ]),

                Forms\Components\Section::make('Konten')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Isi Berita')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl(url('/images/placeholder.png')),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('author')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tgl_publikasi')
                    ->label('Tanggal Publikasi')
                    ->date('d M Y')
                    ->sortable()
                    ->color(fn ($record) => $record->tgl_publikasi > now() ? 'warning' : 'success'),

                TextColumn::make('content')
                    ->label('Konten')
                    ->html()
                    ->limit(100)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = strip_tags($column->getState());
                        if (strlen($state) <= 100) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                Filter::make('published')
                    ->label('Sudah Dipublikasi')
                    ->query(fn (Builder $query): Builder => $query->where('tgl_publikasi', '<=', now())),
                    
                Filter::make('draft')
                    ->label('Draft')
                    ->query(fn (Builder $query): Builder => $query->where('tgl_publikasi', '>', now())),

                Tables\Filters\Filter::make('tgl_publikasi')
                    ->form([
                        DatePicker::make('published_from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('published_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tgl_publikasi', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tgl_publikasi', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tgl_publikasi', 'desc');
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'view' => Pages\ViewBerita::route('/{record}'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}