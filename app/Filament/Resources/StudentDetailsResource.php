<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentDetailsResource\Pages;
use App\Models\StudentDetails;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Filament\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

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
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Academic')
                        ->schema([
                            TextInput::make('name')
                                ->label('Name')
                                ->required()
                                ->columnSpan(1),
                            TextInput::make('roll_no')
                                ->label('Roll Number')
                                ->required()
                                ->columnSpan(1),
                            Select::make('course')
                                ->label('Course')
                                ->options([
                                    'B.E' => 'B.E',
                                    'B.Tech' => 'B.Tech',
                                ])
                                ->columnSpan(1)
                                ->required(),
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->columnSpan(1),
                            Select::make('year')
                                ->label('Year')
                                ->options([
                                    'I' => 'I',
                                    'II' => 'II',
                                    'III' => 'III',
                                    'IV' => 'IV',
                                ])
                                ->columnSpan(1)
                                ->required(),
                            Select::make('department')
                                ->label('Department')
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
                                ])
                                ->columnSpan(1)
                                ->required(),
                            \Filament\Forms\Components\DatePicker::make('date_of_admission')
                                ->label('Date of Admission')
                                ->required()
                                ->columnSpan(1),
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'Active' => 'Active',
                                    'Inactive' => 'Inactive',
                                ])
                                ->required()
                                ->columnSpan(1),
                            Select::make('accommodation')
                                ->label('Accommodation')
                                ->options([
                                    'Hosteller' => 'Hosteller',
                                    'Dayscholar' => 'Dayscholar',
                                ])
                                ->required()
                                ->columnSpan(1),
                        ])->columnSpan(2),
                    Tabs\Tab::make('Personal')
                        ->schema([
                            Select::make('gender')
                                ->label('Gender')
                                ->options([
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                ])
                                ->required(),
                            TextInput::make('blood_group')
                                ->label('Blood Group')
                                ->required(),
                            Select::make('residency_status')
                                ->label('Residency Status')
                                ->options([
                                    'India' => 'India',
                                    'Other' => 'Other',
                                ])
                                ->required(),
                            Select::make('community')
                                ->label('Community')
                                ->options([
                                    'SC' => 'SC',
                                    'ST' => 'ST',
                                    'BC' => 'BC',
                                    'BCM' => 'BCM',
                                    'MBC' => 'MBC',
                                    'DC' => 'DC',
                                ])
                                ->required(),
                            Select::make('religion')
                                ->label('Religion')
                                ->options([
                                    'Hindu' => 'Hindu',
                                    'Muslim' => 'Muslim',
                                    'Christian' => 'Christian',
                                ])
                                ->required(),
                            TextInput::make('seat_category')
                                ->label('Seat Category')
                                ->required(),
                            TextInput::make('quota')
                                ->label('Quota')
                                ->required(),
                        ]),
                ])->columnSpan(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('')->rowIndex(),
                TextColumn::make('name')->searchable()->sortable()->summarize(Count::make()->label('Count'))->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('roll_no')->searchable()->sortable()->copyable()->copyMessage('Roll Number copied')->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('email')->searchable()->sortable()->icon('heroicon-m-envelope')->iconColor('primary')->copyable()->copyMessage('Email copied')->copyMessageDuration(1500),
                TextColumn::make('course')->toggleable(isToggledHiddenByDefault: true)->badge()
                ->color(fn (string $state): string => match ($state) {
                    'B.E' => 'gray',
                    'B.Tech' => 'info'
                }),
                TextColumn::make('department')->sortable()->wrap()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('date_of_admission')->date()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')->toggleable(isToggledHiddenByDefault: true)->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Male' => 'primary',
                    'Female' => 'warning'
                })->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('blood_group')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('year')->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('status')->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Active' => 'success',
                    'Inactive' => 'danger'
                })->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('accommodation')->label('Accomodation')->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Hosteller' => 'info',
                    'Dayscholar' => 'danger'
                })->toggleable(isToggledHiddenByDefault: false),
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
            ])->defaultSort('updated_at','desc')
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
                ])->native(0)->searchable(),
                SelectFilter::make('gender')
                ->placeholder('Filter by Gender')
                ->options([
                    'Male' => 'Male',
                    'Female' => 'Female',
                ])->native(0),
                Filter::make('from')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('start')
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
                    \Filament\Forms\Components\DatePicker::make('end')
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
                    ])->native(0)->searchable(),
                SelectFilter::make('status')
                    ->placeholder('Filter by Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])->native(0),
                SelectFilter::make('accommodation')
                    ->placeholder('Filter by Accommodation')
                    ->options([
                        'Hosteller' => 'Hosteller',
                        'Dayscholar' => 'Dayscholar',
                    ])->native(0),
                SelectFilter::make('community')
                    ->placeholder('Filter by Community')
                    ->options([
                        'SC' => 'SC',
                        'ST' => 'ST',
                        'BC' => 'BC',
                        'BCM' => 'BCM',
                        'MBC' => 'MBC',
                        'DC' => 'DC',
                    ])->native(0)->searchable(),
                SelectFilter::make('seat_category')
                    ->placeholder('Filter by Seat Category')
                    ->options([
                        'Management' => 'Management',
                        'Government Normal' => 'Government Normal',
                        'Government Special' => 'Government Special',
                    ])->native(0),
                SelectFilter::make('course')
                    ->placeholder('Filter by Course')
                    ->options([
                        'B.E' => 'B.E',
                        'B.Tech' => 'B.Tech',
                    ])->native(0),
                SelectFilter::make('religion')
                    ->placeholder('Filter by Religion')
                    ->options([
                        'Hindu' => 'Hindu',
                        'Muslim' => 'Muslim',
                        'Christian' => 'Christian',
                    ])->native(0),
                SelectFilter::make('residency_status')
                    ->placeholder('Filter by Residency Status')
                    ->options([
                        'India' => 'India',
                        'Other' => 'Other',
                    ])->native(0),
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
                    ])->native(0)->searchable()
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->successNotification(
                        Notification::make()
                            ->danger()
                            ->title('Student Detail Deleted'),
                    )
                ])->tooltip('Actions')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make('table')->exports([
                        ExcelExport::make()->fromTable()->only([
                        'name', 'roll_no', 'email', 'course', 'department', 'year', 'status', 'accommodation', 'blood_group', 'date_of_admission', 'gender', 'community', 'religion', 'seat_category', 'quota','residency_status'
                        ])
                        ->askForFilename(),
                    ])->icon('heroicon-s-folder-arrow-down')->color('success')->label('Export Into Excel')
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
