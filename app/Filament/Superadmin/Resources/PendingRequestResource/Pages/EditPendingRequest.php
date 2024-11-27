<?php

namespace App\Filament\Superadmin\Resources\PendingRequestResource\Pages;

use App\Filament\Superadmin\Resources\PendingRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingRequest extends EditRecord
{
    protected static string $resource = PendingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
