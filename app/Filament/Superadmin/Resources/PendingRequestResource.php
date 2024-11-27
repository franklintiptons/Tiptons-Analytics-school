<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\PendingRequestResource\Pages;
use App\Models\PendingRequest;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class PendingRequestResource extends Resource
{
    protected static ?string $model = PendingRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Pending Requests';

    protected static ?string $navigationGroup = 'SUBSCRIPTION MANAGEMENT';


    protected static ?int $navigationSort = 3;
    // Add this $casts property here at the class level, not inside methods
    protected $casts = [
        'status' => 'string',
    ];
 // Add your desired badge text here public static function getNavigationBadge(): ?string
 public static function getNavigationBadge(): ?string
 {
     $count = static::getModel()::where('status', 'pending')->count();

     return $count > 0 ? (string)$count : null;
 }

 public static function getNavigationBadgeColor(): ?string
 {
     $count = static::getModel()::where('status', 'pending')->count();

     // Return badge color based on the count
     return $count > 1 ? 'warning' : 'primary';
 }


    public static function form(Form $form): Form
    {
        return $form
               ->schema([
               Forms\Components\Section::make('Pending request')
                  ->description('Enter pending request for you school if you school has subscribe for the package.')
                  ->icon('heroicon-o-arrow-path-rounded-square')
                  ->schema([
                Forms\Components\Select::make('school_id')
                    ->label('School')
                    ->required()
                    ->options(School::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->placeholder('Select a School'),

                    Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('KSH') // Adds "KSH" before the input field
                    ->label('Price'),


                Forms\Components\TextInput::make('payment_for')
                    ->required()
                    ->maxLength(255)
                    ->label('Payment For'),

                Forms\Components\FileUpload::make('payment_document')
                    ->label('Payment Document')
                    ->image()
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->directory('payment_documents')
                    ->maxSize(10240)
                    ->required(false)
                    ->default(null),


          ])
            ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->label('School Name')
                    ->sortable()
                    ->icon('heroicon-o-building-office-2')
                    ->searchable(),


                Tables\Columns\TextColumn::make('price')
                     ->icon('heroicon-o-currency-pound')
                     ->badge()
                     ->colors(['danger'])
                     ->money('KES', true) // 'KES' for Kenyan Shillings
                     ->sortable()
                     ->label('Price'),



                Tables\Columns\TextColumn::make('payment_for')
                    ->searchable()
                    ->sortable()
                    ->label('Payment For'),



                Tables\Columns\TextColumn::make('payment_document')
                    ->badge()
                    ->icon('heroicon-o-document-text')
                    ->label('Payment Document'),
                    Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function ($state): string {  // Use $state here
                        return match($state) {
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            'suspended' => 'info',  // Adjusted typo
                            default => 'secondary',
                        };
                    })
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'suspended' => 'Suspended',
                    ])
                    ->label('Status Filter'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->action(function (PendingRequest $pendingRequest) {
                        $pendingRequest->approve();
                        $pendingRequest->save();
                    })
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation('Are you sure you want to approve this request?'),
                Action::make('reject')
                    ->label('Reject')
                    ->action(function (PendingRequest $pendingRequest) {
                        $pendingRequest->reject();
                        $pendingRequest->save();
                    })
                    ->icon('heroicon-o-archive-box-x-mark')
                    ->requiresConfirmation('Are you sure you want to reject this request?'),
                Action::make('suspend')
                    ->label('Suspend')
                    ->action(function (PendingRequest $pendingRequest) {
                        $pendingRequest->suspend();
                        $pendingRequest->save();
                    })
                    ->icon('heroicon-o-pause')
                    ->requiresConfirmation('Are you sure you want to suspend this request?'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships if needed (e.g., PendingRequest -> School)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendingRequests::route('/'),
            'create' => Pages\CreatePendingRequest::route('/create'),
            'view' => Pages\ViewPendingRequest::route('/{record}'),
            'edit' => Pages\EditPendingRequest::route('/{record}/edit'),
        ];
    }
}