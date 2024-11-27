<?php

namespace App\Filament\Superadmin\Resources\SuperadminResource\Pages;

use App\Filament\Superadmin\Resources\SuperadminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuperadmins extends ListRecords
{
    protected static string $resource = SuperadminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
