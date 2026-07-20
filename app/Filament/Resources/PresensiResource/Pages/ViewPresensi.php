<?php

namespace App\Filament\Resources\PresensiResource\Pages;

use App\Filament\Resources\PresensiResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Log;

class ViewPresensi extends ViewRecord
{
    protected static string $resource = PresensiResource::class;

    public function getTitle(): string
    {
        return 'Lihat Presensi';
    }   

    public ?array $data = [];

    public function mount(int|string $record): void
    {
        parent::mount($record);
        
        // Load the relationship if not already loaded
        if (!$this->record->relationLoaded('asisten')) {
            $this->record->load('asisten');
        }
        
        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Informasi Presensi')
                    ->schema([
                        $this->getAsistenField(),
                        $this->getActivityField(),
                        $this->getDescriptionField(),
                        $this->getDateTimeFields(),
                    ])
                    ->columns(1)
            ]);
    }

    protected function getAsistenField(): Components\TextInput
    {
        return Components\TextInput::make('asisten.name')
            ->label('Asisten')
            ->formatStateUsing(fn () => $this->record->asisten->name ?? '-')
            ->disabled()
            ->columnSpanFull();
    }

    protected function getActivityField(): Components\TextInput
    {
        return Components\TextInput::make('activity')
            ->label('Aktivitas')
            ->default(fn () => $this->record->activity ?? '-')
            ->disabled()
            ->columnSpanFull();
    }

    protected function getDescriptionField(): Components\Textarea
    {
        return Components\Textarea::make('description')
            ->label('Deskripsi Kegiatan')
            ->default(fn () => $this->record->description ?? '-')
            ->disabled()
            ->columnSpanFull()
            ->rows(3);
    }

    protected function getDateTimeFields(): Components\Grid
    {
        return Components\Grid::make(2)
            ->schema([
                Components\TextInput::make('date')
                    ->label('Tanggal')
                    ->formatStateUsing(fn () => $this->record->date ? \Carbon\Carbon::parse($this->record->date)->isoFormat('dddd, D MMMM YYYY') : null)
                    ->disabled(),
                Components\TextInput::make('time')
                    ->label('Waktu')
                    ->formatStateUsing(fn () => $this->record->time ? \Carbon\Carbon::parse($this->record->time)->format('H:i:s') : null)
                    ->disabled(),
            ]);
    }

    protected function formatDate($date): string
    {
        if (empty($date)) {
            return '-';
        }

        try {
            if ($date instanceof \Carbon\Carbon) {
                return $date->isoFormat('dddd, D MMMM YYYY');
            }
            return Carbon::parse($date)->isoFormat('dddd, D MMMM YYYY');
        } catch (\Exception $e) {
            return 'Format tanggal tidak valid';
        }
    }

    protected function formatTime($time): string
    {
        if (empty($time)) {
            return '-';
        }

        try {
            if ($time instanceof \Carbon\Carbon) {
                return $time->format('H:i:s');
            }
            return Carbon::parse($time)->format('H:i:s');
        } catch (\Exception $e) {
            return 'Format waktu tidak valid';
        }
    }
}