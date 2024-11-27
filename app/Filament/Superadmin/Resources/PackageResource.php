<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift-top';

    protected static ?string $navigationGroup = 'SUBSCRIPTION MANAGEMENT';

    protected static ?int $navigationSort = 1;


    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    // Form schema
    public static function form(Form $form): Form
    {
        return $form

          ->schema([
          Forms\Components\Section::make('Create package')
             ->description('Create package for the schools.')
             ->icon('heroicon-o-gift-top')
            ->schema([
                // Package Name
                Forms\Components\TextInput::make('name')
                    ->label('Package Name')  // Display label
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter package name'),

                // Description
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull()  // Make the description field take full width
                    ->placeholder('Enter package description'),

                // Price
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->prefix('KSH')  // Prefix the value with a dollar sign
                    ->placeholder('Enter price'),

                // Interval (e.g., monthly, yearly)
                Forms\Components\TextInput::make('interval')
                    ->label('Interval')
                    ->required()
                    ->placeholder('Enter interval (e.g., monthly, yearly)'),

                // Period (e.g., number of months/years)
                Forms\Components\TextInput::make('period')
                    ->label('Period')
                    ->required()
                    ->numeric()
                    ->placeholder('Enter period (e.g., 12 for months)'),

                // Student Limit
                Forms\Components\TextInput::make('student_limit')
                    ->label('Student Limit')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->placeholder('Enter student limit (default is 0 for no limit)'),

                    ]) ->columns(2),


            ]);
    }

    // Table schema for displaying the packages
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Package Name
                Tables\Columns\TextColumn::make('name')
                    ->label('Package Name')
                    ->searchable()
                    ->sortable(),

                // Price
                Tables\Columns\TextColumn::make('price')
                     ->icon('heroicon-o-currency-pound')
                     ->badge()
                     ->colors(['danger'])
                     ->money('KES', true) // 'KES' for Kenyan Shillings
                     ->sortable()
                     ->label('Price'),


                // Interval (e.g., monthly, yearly)
                Tables\Columns\TextColumn::make('interval')
                    ->label('Interval')
                    ->sortable(),

                // Period (e.g., 12 months, 1 year)
                Tables\Columns\TextColumn::make('period')
                    ->label('Period')
                    ->numeric()
                    ->sortable(),

                // Student Limit
                Tables\Columns\TextColumn::make('student_limit')
                ->badge()
                ->colors([
                    'warning'
                ])
                    ->label('Student Limit')
                    ->numeric()
                    ->sortable(),

                    Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                // Created at timestamp
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Updated at timestamp
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add search filters here if needed (e.g., filter by package name or price)

                // Add filters here if needed (e.g., filter by price or student limit)
            ])
            ->actions([
                // View and edit actions
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Delete action
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                // Bulk delete action
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Relations (if any, currently no relations are defined)
    public static function getRelations(): array
    {
        return [
            // Add related models here if needed
        ];
    }

    // Pages for CRUD operations
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'view' => Pages\ViewPackage::route('/{record}'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}