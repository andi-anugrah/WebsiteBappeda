<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

FilamentColor::register([
    'black' => Color::hex('#000000'),
]);

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Dokumen';
    
    protected static ?string $modelLabel = 'Dokumen';
    
    protected static ?string $pluralModelLabel = 'Dokumen';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('judul_dokumen')
                            ->label('Judul Dokumen')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Masukkan judul dokumen yang jelas dan deskriptif'),
                            
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options(Document::getKategoriOptions())
                            ->required()
                            ->searchable()
                            ->helperText('Pilih kategori dokumen yang sesuai'),
                            
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(date('Y') + 5)
                            ->default(date('Y'))
                            ->helperText('Tahun dokumen dibuat atau berlaku'),
                    ])
                    ->columns(2)
                    ->collapsible(),
                    
                Forms\Components\Section::make('File Dokumen')
                    ->schema([
                        Forms\Components\FileUpload::make('file_dokumen')
                            ->label('Upload File')
                            ->directory('documents')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            ])
                            ->maxSize(20480) // 20MB
                            ->downloadable()
                            ->openable()
                            ->previewable(false)
                            ->columnSpanFull()
                            ->helperText('Format yang didukung: PDF, DOC, DOCX, XLS, XLSX. Maksimal 20MB.')
                            ->saveUploadedFileUsing(function ($file, $set) {
                                $filename = $file->getClientOriginalName();
                                $size = $file->getSize();
                                $type = $file->getClientMimeType();
                                
                                $set('original_filename', $filename);
                                $set('file_size', $size);
                                $set('file_type', $type);
                                
                                return $file->store('documents', 'public');
                            }),
                            
                        Forms\Components\Hidden::make('original_filename'),
                        Forms\Components\Hidden::make('file_size'),
                        Forms\Components\Hidden::make('file_type'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_dokumen')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->wrap()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('kategori_label')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'RPJMD') => 'success',
                        str_contains($state, 'RPJPD') => 'info',
                        str_contains($state, 'RKPD') => 'warning',
                        str_contains($state, 'RENJA') => 'primary',
                        str_contains($state, 'RENSTRA') => 'gray',
                        str_contains($state, 'Dokumen Lainnya') => 'black',
                        default => 'secondary',
                    })
                    ->sortable(['kategori'])
                    ->searchable(['kategori']),
                    
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('original_filename')
                    ->label('File')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->original_filename)
                    ->url(fn ($record) => $record->file_url, true)
                    ->color('primary')
                    ->icon('heroicon-o-document')
                    ->iconPosition('before'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options(Document::getKategoriOptions())
                    ->multiple(),
                    
                Tables\Filters\Filter::make('tahun')
                    ->form([
                        Forms\Components\Select::make('tahun')
                            ->label('Tahun')
                            ->options(function () {
                                $currentYear = date('Y');
                                $years = [];
                                for ($i = $currentYear; $i >= 2000; $i--) {
                                    $years[$i] = $i;
                                }
                                return $years;
                            })
                            ->placeholder('Pilih Tahun'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['tahun'], fn (Builder $query, $tahun): Builder => $query->where('tahun', $tahun));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        // Delete the file when record is deleted
                        if ($record->file_dokumen && Storage::disk('public')->exists($record->file_dokumen)) {
                            Storage::disk('public')->delete($record->file_dokumen);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // Delete files for bulk deletion
                            foreach ($records as $record) {
                                if ($record->file_dokumen && Storage::disk('public')->exists($record->file_dokumen)) {
                                    Storage::disk('public')->delete($record->file_dokumen);
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s'); // Auto refresh every 30 seconds
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }
    
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['kategori']);
    }
    
    public static function getGloballySearchableAttributes(): array
    {
        return ['judul_dokumen', 'kategori', 'original_filename'];
    }
}