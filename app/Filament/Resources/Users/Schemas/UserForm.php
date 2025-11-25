<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                ->columns(2)
                ->schema([
                     TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()                    
                    ->required(),
                    TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn (  $state) =>Hash::make($state))        
                    ->dehydrated(fn (string $context) : bool =>$context === 'create') 
                    ->required(fn (string $context) : bool => $context === 'create'),        
                    TextInput::make('phone')
                    ->tel()
                    ->default(null),
                    DatePicker::make('date_of_birth'),
                    Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                    Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()->preload()->searchable()
                ]),               
                
                Section::make('Employement Details')
                ->columns(2)->schema([
                    TextInput::make('employee_id')
                    ->label('Employee Code')
                    ->readOnly()
                    ->hiddenOn('create')
                    ->unique(ignoreRecord:true)
                    ->default(null),
                    Select::make('department_id')
                    ->relationship('department', 'name')
                    ->default(null)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(),
                    Select::make('position_id')
                    ->relationship('position', 'title', 
                    fn($query, Get $get) => $query->where('department_id',  $get('department_id')))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->default(null),
                    DatePicker::make('hire_date')
                    ->required(),
                    ToggleButtons::make('employment_type')
                        ->options([
                                'full_time' => 'Full Time',
                                'part_time' => 'Part Time',
                                'contract' => 'Contract',
                                'intern' => 'Intern',        ])
                                ->colors([
                                    'full_time' => 'success',
                                    'part_time' => 'danger',
                                    'contract' => 'primary',
                                    'intern' => 'info',
                                ])
                        ->default('full_time')
                        ->columnSpanFull()->grouped()
                        ->required(),
                    Select::make('status')
                        ->options([
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'on_leave' => 'On leave',
                            'terminated' => 'Terminated',        ])
                        ->default('active')
                        ->required(),
                    TextInput::make('salary')
                        ->numeric()
                        ->default(null),
                
                ]),
                
                Section::make('Emergency Contact')
                ->columns(2)->schema([
                    TextInput::make('emergency_contact')
                    ->default(null),
                TextInput::make('emergency_contact_phone')
                    ->tel()
                    ->default(null),
                ])
                
            ]);
    }
}
