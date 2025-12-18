<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Blog';
    }

    public static function getNavigationLabel(): string
    {
        return 'Categorias';
    }

    public static function getModelLabel(): string
    {
        return 'Categoria';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Categorias';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome')->required()->maxLength(255),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')->label('Descrição')->columnSpanFull(),
                Forms\Components\Select::make('parent_id')->label('Categoria pai')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->searchable(),
                Tables\Columns\TextColumn::make('parent.name')->label('Pai'),
                Tables\Columns\TextColumn::make('created_at')->label('Criado em')->dateTime()->sortable(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Excluir selecionados'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
