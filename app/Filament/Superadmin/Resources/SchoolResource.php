<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\SchoolResource\Pages;
use App\Filament\Superadmin\Resources\SchoolResource\RelationManagers\AdminsRelationManager;
use App\Models\School;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Schools';


    protected static ?string $title = 'School Name';

    protected static ?string $slug ='schools';

    protected static ?string $view = 'filament::resources.school-resource';

    protected static ?int $navigationSort = 1;



    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count(); // Counts all schools
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('School Information')
                     ->description('Enter School information to create.')
                     ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter School name')
                            ->label('School Name'),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter Email Address')
                            ->label('School Email'),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255)
                            ->placeholder('Enter Phone Number')
                            ->label('School Phone'),

                        Forms\Components\TextInput::make('address')
                            ->maxLength(255)
                            ->placeholder('Enter School Address')
                            ->label('School Address'),

                            Forms\Components\FileUpload::make('image')
                            ->label('School Logo')
                            ->image()
                            ->disk('public')
                            ->directory('schools')
                            ->maxSize(2048) // Limit to 2MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png']) // Restrict to JPEG and PNG images

                    ])
                    ->columns(2),

                Forms\Components\Section::make('Admins Information')
                    ->description('Manage admins associated with this school.')
                    ->icon('heroicon-o-user-plus')
                    ->schema([
                        Forms\Components\Repeater::make('admins')
                            ->relationship('admins')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Admin Name')
                                    ->placeholder('Enter Admin name')
                                    ->required(),

                                Forms\Components\TextInput::make('email')
                                    ->label('Admin Email')
                                    ->email()
                                    ->placeholder('Enter Admin Email Address')
                                    ->required()
                                    ->unique(Admin::class), // Ensure email uniqueness

                                Forms\Components\TextInput::make('phone')
                                    ->label('Admin Phone')
                                    ->placeholder('Enter Admin Phone Number')
                                    ->tel(),

                                Forms\Components\TextInput::make('password')
                                    ->label('Admin Password')
                                    ->placeholder('Enter Admin Password')
                                    ->password()
                                    ->required(fn ($get) => !$get('id')) // Only required for new admins
                                    ->minLength(8)
                                    ->confirmed()
                                    ->dehydrated(false), // Prevent password field from being saved if empty

                                Forms\Components\TextInput::make('password_confirmation')
                                    ->label('Confirm Admin Password')
                                    ->placeholder('Confirm Admin Password')
                                    ->password()
                                    ->required(fn ($get) => !$get('id')) // Only required for new admins
                                    ->minLength(8)
                                    ->dehydrated(false), // Prevent password confirmation from being saved if empty
                            ])
                            ->createItemButtonLabel('Add  Another Admin'),

                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->sortable()
                    ->label('School Logo')
                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/schools/' . $record->image) : null),

                Tables\Columns\TextColumn::make('name')
                     ->sortable()
                    ->label('School Name')
                    ->icon('heroicon-o-building-office-2')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-o-envelope')
                    ->badge()
                    ->colors(['warning'])
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->icon('heroicon-o-phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable(),


                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->icon('heroicon-o-calendar-days')
                    ->sortable()
                    ->dateTime()
                    ->label('Created At'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('adminList')
                    ->label('Admins')
                    ->color('primary')
                    ->icon('heroicon-o-users')
                    ->action(function ($record) {
                        return redirect()->route('admin.index', ['schoolId' => $record->id]);
                    }),
            ])



            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AdminsRelationManager::class, // Handles Admin Management in a separate tab
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'view' => Pages\ViewSchool::route('/{record}'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }

    // Override the saving process to hash the password if provided
    public static function afterSave($record, array $data): void
    {
        if (isset($data['admins'])) {
            foreach ($data['admins'] as $adminData) {
                if (isset($adminData['password']) && !empty($adminData['password'])) {
                    // Hash the password before saving
                    $admin = Admin::find($adminData['id']);
                    if ($admin) {
                        $admin->password = Hash::make($adminData['password']);
                        $admin->save();
                    }
                }
            }
        }
    }
}