<?php

namespace App\Filament\Resources\AdvisorResource\Pages;

use App\Filament\Resources\AdvisorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdvisor extends ViewRecord
{
    protected static string $resource = AdvisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
