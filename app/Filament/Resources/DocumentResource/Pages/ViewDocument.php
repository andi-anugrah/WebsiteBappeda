<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Support\Enums\FontWeight;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download')
                ->label('Download File')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn () => $this->record->file_url)
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->file_dokumen),
                
            Actions\EditAction::make(),
        ];
    }
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Dokumen')
                    ->schema([
                        TextEntry::make('judul_dokumen')
                            ->label('Judul Dokumen')
                            ->weight(FontWeight::Bold)
                            ->size('lg'),
                            
                        TextEntry::make('kategori_label')
                            ->label('Kategori')
                            ->badge()
                            ->color(fn (string $state): string => match (true) {
                                str_contains($state, 'RPJMD') => 'success',
                                str_contains($state, 'RPJPD') => 'info',
                                str_contains($state, 'RKPD') => 'warning',
                                str_contains($state, 'RENJA') => 'primary',
                                str_contains($state, 'RENSTRA') => 'gray',
                                str_contains($state, 'Dokumen Lainnya') => 'danger',
                                default => 'secondary',
                            }),
                            
                        TextEntry::make('tahun')
                            ->label('Tahun'),
                            
                        IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                    ])
                    ->columns(2),
                    
                Section::make('File Dokumen')
                    ->schema([
                        TextEntry::make('original_filename')
                            ->label('Nama File')
                            ->url(fn () => $this->record->file_url, true)
                            ->color('primary'),
                            
                        TextEntry::make('file_size_formatted')
                            ->label('Ukuran File'),
                            
                        TextEntry::make('file_type')
                            ->label('Tipe File'),
                    ])
                    ->columns(3)
                    ->visible(fn () => $this->record->file_dokumen),
                    
                Section::make('Deskripsi')
                    ->schema([
                        TextEntry::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Tidak ada deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn () => $this->record->deskripsi),
                    
                Section::make('Informasi Sistem')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat pada')
                            ->dateTime('d M Y, H:i'),
                            
                        TextEntry::make('updated_at')
                            ->label('Diperbarui pada')
                            ->dateTime('d M Y, H:i'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}