<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static ?string $title = 'Tags';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()->label('Associar'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->label('Desassociar'),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make()->label('Desassociar selecionados'),
            ]);
    }
}
