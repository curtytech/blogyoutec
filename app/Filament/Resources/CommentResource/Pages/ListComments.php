<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    protected static ?string $title = 'Comentários';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Comentário'),
        ];
    }
}

