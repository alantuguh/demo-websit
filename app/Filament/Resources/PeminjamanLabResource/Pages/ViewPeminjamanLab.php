<?php

namespace App\Filament\Resources\PeminjamanLabResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PeminjamanLabResource;
use App\Models\PeminjamanLab;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ViewPeminjamanLab extends ViewRecord
{
    protected static string $resource = PeminjamanLabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('approve')
                ->label('Setujui')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn (): bool => 
                    PeminjamanLabResource::userIsAdmin() && 
                    $this->record->status === 'menungju'
                )
                ->action(function () {
                    $this->record->update([
                        'status' => 'disetujui',
                        'disetujui_oleh' => Auth::id(),
                        'disetujui_pada' => now(),
                    ]);
                    $this->refreshFormData([
                        'status',
                        'disetujui_oleh',
                        'disetujui_pada',
                    ]);
                    
                    $this->dispatch('refresh');
                })
                ->requiresConfirmation(),
            Actions\Action::make('reject')
                ->label('Tolak')
                ->icon('heroicon-o-x-mark')
                ->color('danger')
                ->visible(fn (): bool => 
                    PeminjamanLabResource::userIsAdmin() && 
                    $this->record->status === 'menungju'
                )
                ->form([
                    \Filament\Forms\Components\Textarea::make('catatan_admin')
                        ->label('Alasan Penolakan')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'ditolak',
                        'catatan_admin' => $data['catatan_admin'],
                        'disetujui_oleh' => Auth::id(),
                        'disetujui_pada' => now(),
                    ]);
                    $this->refreshFormData([
                        'status',
                        'catatan_admin',
                        'disetujui_oleh',
                        'disetujui_pada',
                    ]);
                    
                    $this->dispatch('refresh');
                })
                ->requiresConfirmation(),
        ];
    }
}
