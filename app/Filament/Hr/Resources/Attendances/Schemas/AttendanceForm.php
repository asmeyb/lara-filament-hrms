<?php

namespace App\Filament\Hr\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('check_in'),
                TimePicker::make('check_out'),
                ToggleButtons::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'late' => 'Late',
                        'early' => 'Early',
                        'half_day' => 'Half day',
                        'overtime' => 'Overtime',
                     ])
                    ->default('present')
                    ->grouped()
                    ->colors([
                        'present' => 'success',
                        'absent' => 'danger',
                        'late' => 'warning',
                        'early' => 'success',
                        'half_day' => 'info',
                        'overtime' => 'primary',
                    ])
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
