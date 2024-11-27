<?php

namespace App\Filament\Superadmin\Resources\SchoolResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;

class AdminsRelationManager extends RelationManager
{
    protected static string $relationship = 'admins';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('name')
                ->label('Admin Name')
                ->required(),
            Forms\Components\TextInput::make('email')
                ->label('Admin Email')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('phone')
                ->label('Admin Phone')
                ->tel(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->icon('heroicon-o-user')
                    ->sortable()
                    ->label('Admin Name'),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->badge()
                    ->colors(['warning'])
                    ->label('Admin Email'),
                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->icon('heroicon-o-phone')
                    ->searchable()
                    ->label('Admin Phone'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}