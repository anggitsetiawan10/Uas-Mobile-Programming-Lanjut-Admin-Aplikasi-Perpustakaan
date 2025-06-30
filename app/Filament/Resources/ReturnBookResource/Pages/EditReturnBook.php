<?php

namespace App\Filament\Resources\ReturnBookResource\Pages;

use App\Filament\Resources\ReturnBookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturnBook extends EditRecord
{
    protected static string $resource = ReturnBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
