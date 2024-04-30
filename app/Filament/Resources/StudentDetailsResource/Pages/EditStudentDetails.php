<?php

namespace App\Filament\Resources\StudentDetailsResource\Pages;

use App\Filament\Resources\StudentDetailsResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditStudentDetails extends EditRecord
{
    protected static string $resource = StudentDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Delete Student Detail')
            ->icon('heroicon-s-trash')->successNotification(
                Notification::make()
                     ->danger()
                     ->title('Student Detail Deleted')
             )
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Student Detail Updated';
    }
}
