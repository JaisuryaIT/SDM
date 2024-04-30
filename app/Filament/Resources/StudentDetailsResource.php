<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentDetailsResource\Pages;
use App\Models\StudentDetails;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentDetailsResource extends Resource
{
    protected static ?string $model = StudentDetails::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $activeNavigationIcon = 'heroicon-s-academic-cap';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('')->rowIndex(),
                TextColumn::make('name')->searchable()->sortable()->summarize(Count::make()->label('Count')),
                TextColumn::make('roll_no')->searchable()->sortable()->copyable()->copyMessage('Roll Number copied')->copyMessageDuration(1500),
                TextColumn::make('email')->searchable()->sortable()->icon('heroicon-m-envelope')->iconColor('primary')->copyable()->copyMessage('Email copied')->copyMessageDuration(1500),
                TextColumn::make('course')->toggleable(isToggledHiddenByDefault: true)->badge()
                ->color(fn (string $state): string => match ($state) {
                    'B.E' => 'gray',
                    'B.Tech' => 'info'
                }),
                TextColumn::make('department')->sortable()->wrap(),
                TextColumn::make('date_of_admission')->date()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')->toggleable(isToggledHiddenByDefault: true)->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Male' => 'primary',
                    'Female' => 'warning'
                }),
                TextColumn::make('blood_group')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('year'),
                TextColumn::make('status')->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Active' => 'success',
                    'Inactive' => 'danger'
                }),
                TextColumn::make('accommodation')->label('Accomodation')->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Hosteller' => 'info',
                    'Dayscholar' => 'danger'
                }),
                TextColumn::make('residency_status')->toggleable(isToggledHiddenByDefault: true)->badge()
                ->color(fn (string $state): string => match ($state) {
                    'India' => 'primary',
                    'Other' => 'warning'
                }),
                TextColumn::make('community')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('religion')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('seat_category')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('quota')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label('Created On')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Updated On')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                SelectFilter::make('department')
                ->placeholder('Filter by Department')
                ->options([
                    'AE' => 'Aeronautical Engineering',
                    'AG' => 'Agriculture Engineering',
                    'AD' => 'Artificial Intelligence and Data Science',
                    'AL' => 'Artificial Intelligence and Machine Learning',
                    'AU' => 'Automobile Engineering',
                    'BM' => 'Biomedical Engineering',
                    'BT' => 'Biotechnology',
                    'CE' => 'Civil Engineering',
                    'CB' => 'Computer Science & Business Systems',
                    'CD' => 'Computer Science & Design',
                    'CS' => 'Computer Science & Engineering',
                    'CT' => 'Computer Technology',
                    'EE' => 'Electrical & Electronics Engineering',
                    'EC' => 'Electronics & Communication Engineering',
                    'EI' => 'Electronics & Instrumentation Engineering',
                    'FT' => 'Fashion Technology',
                    'FD' => 'Food Technology',
                    'IS' => 'Information Science & Engineering',
                    'IT' => 'Information Technology',
                    'ME' => 'Mechanical Engineering',
                    'MC' => 'Mechatronics Engineering',
                    'TT' => 'Textile Technology',
                ])->searchable(),
                SelectFilter::make('gender')
                ->placeholder('Filter by Gender')
                ->options([
                    'Male' => 'Male',
                    'Female' => 'Female',
                ]),
                Filter::make('from')
                ->form([
                    DatePicker::make('start')
                    ->label('Admitted From'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['start'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date_of_admission', '>=', $date),
                        );
                })
                ->indicateUsing(function (array $data): ?string {
                    if (!$data['start']) {
                        return null;
                    }
                    return "From: " . Carbon::parse($data['start'])->format('d M Y');
                }),
                Filter::make('to')
                ->form([
                    DatePicker::make('end')
                    ->label('Admitted To'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['end'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date_of_admission', '<=', $date),
                        );
                })
                ->indicateUsing(function (array $data): ?string {
                    if (!$data['end']) {
                        return null;
                    }
                    return "To: " . Carbon::parse($data['end'])->format('d M Y');
                }),
                SelectFilter::make('year')
                    ->placeholder('Filter by Year')
                    ->options([
                        'I' => 'I',
                        'II' => 'II',
                        'III' => 'III',
                        'IV' => 'IV',
                    ])->searchable(),
                SelectFilter::make('status')
                    ->placeholder('Filter by Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ]),
                SelectFilter::make('accommodation')
                    ->placeholder('Filter by Accommodation')
                    ->options([
                        'Hosteller' => 'Hosteller',
                        'Dayscholar' => 'Dayscholar',
                    ]),
                SelectFilter::make('community')
                    ->placeholder('Filter by Community')
                    ->options([
                        'SC' => 'SC',
                        'ST' => 'ST',
                        'BC' => 'BC',
                        'BCM' => 'BCM',
                        'MBC' => 'MBC',
                        'DC' => 'DC',
                    ])->searchable(),
                SelectFilter::make('seat_category')
                    ->placeholder('Filter by Seat Category')
                    ->options([
                        'Management' => 'Management',
                        'Government Normal' => 'Government Normal',
                        'Government Special' => 'Government Special',
                    ]),
                SelectFilter::make('course')
                    ->placeholder('Filter by Course')
                    ->options([
                        'B.E' => 'B.E',
                        'B.Tech' => 'B.Tech',
                    ]),
                SelectFilter::make('religion')
                    ->placeholder('Filter by Religion')
                    ->options([
                        'Hindu' => 'Hindu',
                        'Muslim' => 'Muslim',
                        'Christian' => 'Christian',
                    ]),
                SelectFilter::make('residency_status')
                    ->placeholder('Filter by Residency Status')
                    ->options([
                        'India' => 'India',
                        'Other' => 'Other',
                    ]),
                SelectFilter::make('blood_group')
                    ->placeholder('Filter by Blood Group')
                    ->options([
                        'A+' => 'A+',
                        'A-' => 'A-',
                        'B+' => 'B+',
                        'B-' => 'B-',
                        'O+' => 'O+',
                        'O-' => 'O-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                    ])->searchable()
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->successNotification(
                        Notification::make()
                            ->danger()
                            ->title('User Deleted'),
                    )
                ])->tooltip('Actions')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListStudentDetails::route('/'),
            'create' => Pages\CreateStudentDetails::route('/create'),
            'edit' => Pages\EditStudentDetails::route('/{record}/edit'),
        ];
    }
}
