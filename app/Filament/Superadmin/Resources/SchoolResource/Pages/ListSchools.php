<?php

namespace App\Filament\Superadmin\Resources\SchoolResource\Pages;

use App\Filament\Superadmin\Resources\SchoolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class ListSchools extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('toggleStatus')
                ->label(fn (Model $record) => $record->status === 'active' ? 'Deactivate' : 'Activate')
                ->color(fn (Model $record) => $record->status === 'active' ? 'danger' : 'success')
                ->action(function (Model $record) {
                    $record->update([
                        'status' => $record->status === 'active' ? 'inactive' : 'active',
                    ]);
                    $this->notify('success', 'School status updated successfully.');
                }),

            Tables\Actions\Action::make('adminList')
                ->label('Admin List')
                ->icon('heroicon-o-users')
                ->url(fn (Model $record) => route('filament.resources.admins.index', ['school' => $record->id]))
                ->color('primary'),

            Tables\Actions\EditAction::make(),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->label('School Name')->searchable(),
            Tables\Columns\TextColumn::make('email')->label('School Email')->searchable(),
            Tables\Columns\TextColumn::make('phone')->label('School Phone')->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->enum([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                ->color(fn ($state) => $state === 'active' ? 'success' : 'danger'),
        ];
    }
}