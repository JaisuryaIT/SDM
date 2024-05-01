<?php

namespace App\Filament\Resources\StudentDetailsResource\Pages;

use App\Filament\Resources\StudentDetailsResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListStudentDetails extends ListRecords
{
    protected static string $resource = StudentDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()->label('Import Student Detail')->color('primary')->icon('heroicon-s-arrow-up-tray'),
            Actions\CreateAction::make()->label('Create Student Detail')
            ->icon('heroicon-s-plus-circle')->successNotification(
                Notification::make()
                     ->success()
                     ->title('Student Detail Created')
             )
        ];
    }
}
