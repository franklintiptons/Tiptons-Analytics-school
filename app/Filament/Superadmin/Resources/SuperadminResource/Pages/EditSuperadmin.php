<?php

namespace App\Filament\Superadmin\Resources\SuperadminResource\Pages;

use App\Filament\Superadmin\Resources\SuperadminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuperadmin extends EditRecord
{
    protected static string $resource = SuperadminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
