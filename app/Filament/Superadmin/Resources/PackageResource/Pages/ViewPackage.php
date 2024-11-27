<?php

namespace App\Filament\Superadmin\Resources\PackageResource\Pages;

use App\Filament\Superadmin\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPackage extends ViewRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
