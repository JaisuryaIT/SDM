<?php

namespace App\Filament\Resources\StudentDetailsResource\Pages;

use App\Filament\Resources\StudentDetailsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentDetails extends CreateRecord
{
    protected static string $resource = StudentDetailsResource::class;
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Student Detail Created';
    }
}
