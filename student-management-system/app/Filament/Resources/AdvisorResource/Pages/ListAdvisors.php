<?php

namespace App\Filament\Resources\AdvisorResource\Pages;

use App\Filament\Resources\AdvisorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvisors extends ListRecords
{
    protected static string $resource = AdvisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
