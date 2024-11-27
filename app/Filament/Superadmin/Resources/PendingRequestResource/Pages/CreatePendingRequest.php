<?php

namespace App\Filament\Superadmin\Resources\PendingRequestResource\Pages;

use App\Filament\Superadmin\Resources\PendingRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePendingRequest extends CreateRecord
{
    protected static string $resource = PendingRequestResource::class;
}
