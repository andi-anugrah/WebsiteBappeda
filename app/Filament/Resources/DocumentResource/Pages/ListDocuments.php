<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Dokumen')
                ->icon('heroicon-o-plus'),
        ];
    }
    
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge($this->getModel()::count()),
                
            'rpjmd' => Tab::make('RPJMD')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', 'rpjmd'))
                ->badge($this->getModel()::where('kategori', 'rpjmd')->count()),
                
            'rpjpd' => Tab::make('RPJPD')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', 'rpjpd'))
                ->badge($this->getModel()::where('kategori', 'rpjpd')->count()),
                
            'rkpd' => Tab::make('RKPD')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', 'rkpd'))
                ->badge($this->getModel()::where('kategori', 'rkpd')->count()),
                
            'renja' => Tab::make('RENJA')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', 'renja'))
                ->badge($this->getModel()::where('kategori', 'renja')->count()),
                
            'renstra' => Tab::make('RENSTRA')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', 'renstra'))
                ->badge($this->getModel()::where('kategori', 'renstra')->count()),
                
            'others' => Tab::make('Lainnya')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', 'dokumen_lainnya'))
                ->badge($this->getModel()::where('kategori', 'dokumen_lainnya')->count()),
        ];
    }
}