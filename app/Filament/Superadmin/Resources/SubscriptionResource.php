<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'SUBSCRIPTION MANAGEMENT';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}


    public static function form(Form $form): Form
    {
        return $form->schema([

                Forms\Components\Section::make('Create subscription')
                   ->description('Create and  make subscription for the school.')
                   ->icon('heroicon-o-banknotes')
                  ->schema([


            Forms\Components\Select::make('school_id')
                ->relationship('school', 'name') // Relationship with School model
                ->required()
                ->searchable()
                ->preload()
                ->label('School'),

            Forms\Components\Select::make('package_id')
                ->relationship('package', 'name') // Relationship with Package model (if applicable)
                ->required()
                ->searchable()
                ->preload()
                ->label('Package'),

            Forms\Components\TextInput::make('amount')
                ->placeholder('Enter Amount')
                ->required()
                ->numeric()
                ->label('Amount'),

            Forms\Components\DatePicker::make('start_date')
                ->required()
                ->label('Start Date'),

            Forms\Components\DatePicker::make('end_date')
                ->required()
                ->label('End Date'),

            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(true),


              ]) ->columns(2),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('school.name')
                ->label('School Name')
                ->sortable()
                ->icon('heroicon-o-building-office-2')
                ->searchable(),

            Tables\Columns\TextColumn::make('package.name')
                ->icon('heroicon-o-gift-top') // Assumes packages have a name field
                ->label('Package')
                ->sortable()
                ->badge()
                    ->colors([
                        'info'
                    ])
                ->searchable(),

            Tables\Columns\TextColumn::make('amount')
                ->money('KSH') // Adjust currency as needed
                ->icon('heroicon-o-currency-pound')
                ->label('Amount')
                ->sortable()
                ->badge()
                ->colors([
                    'danger'
                ])

                ->money('KSH'), // Adjust currency as needed

            Tables\Columns\TextColumn::make('start_date')
                ->label('Start Date')
                ->sortable()
                ->date(),

            Tables\Columns\TextColumn::make('end_date')
                ->label('End Date')
                ->sortable()
                ->date(),

            Tables\Columns\IconColumn::make('is_active')
                ->sortable()
                ->label('Active')
                ->boolean(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->sortable()
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated At')
                ->sortable()
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\Filter::make('active')
                ->query(fn (Builder $query) => $query->where('is_active', true))
                ->label('Active Subscriptions'),

            Tables\Filters\Filter::make('expired')
                ->query(fn (Builder $query) => $query->where('end_date', '<', now()))
                ->label('Expired Subscriptions'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'view' => Pages\ViewSubscription::route('/{record}'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}