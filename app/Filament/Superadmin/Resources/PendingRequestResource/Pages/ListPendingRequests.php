<?php

namespace App\Filament\Superadmin\Resources\PendingRequestResource\Pages;

use App\Filament\Superadmin\Resources\PendingRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingRequests extends ListRecords
{
    protected static string $resource = PendingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
