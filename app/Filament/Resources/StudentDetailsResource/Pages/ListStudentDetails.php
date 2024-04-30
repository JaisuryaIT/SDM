<?php

namespace App\Filament\Resources\StudentDetailsResource\Pages;

use App\Filament\Resources\StudentDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentDetails extends ListRecords
{
    protected static string $resource = StudentDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Student Detail')
            ->icon('heroicon-s-plus-circle')
        ];
    }
}
