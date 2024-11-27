<?php

namespace App\Filament\Superadmin\Resources\SuperadminResource\Pages;

use App\Filament\Superadmin\Resources\SuperadminResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSuperadmin extends ViewRecord
{
    protected static string $resource = SuperadminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
