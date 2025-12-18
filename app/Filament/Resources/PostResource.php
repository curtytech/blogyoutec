<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers\TagsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationGroup(): ?string
    {
        return 'Blog';
    }

    public static function getNavigationLabel(): string
    {
        return 'Posts';
    }

    public static function getModelLabel(): string
    {
        return 'Post';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Posts';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('Título')->required()->maxLength(255),
                Forms\Components\TextInput::make('description')->label('Descrição')->nullable()->maxLength(255),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('author_id')->label('Autor')
                    ->relationship('author', 'name')->searchable()->preload()->required(),
                Forms\Components\Select::make('category_id')->label('Categoria')
                    ->relationship('category', 'name')->searchable()->preload()->nullable(),
                Forms\Components\FileUpload::make('featured_image')->label('Banner')->image()->columnSpanFull(),
                Forms\Components\RichEditor::make('content')->label('Conteúdo')->columnSpanFull(),
                Forms\Components\Select::make('status')->label('Status')
                    ->options([
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                        'archived' => 'Arquivado',
                    ])->required(),
                Forms\Components\DateTimePicker::make('published_at')->label('Publicado em')->nullable(),
                Forms\Components\Toggle::make('is_featured')->label('Em destaque'),
                Forms\Components\Toggle::make('allow_comments')->label('Permitir comentários'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')->label('Banner'),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')->label('Status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'warning' => 'archived',
                    ])
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                        'archived' => 'Arquivado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('category.name')->label('Categoria')->toggleable(),
                Tables\Columns\TextColumn::make('author.name')->label('Autor')->toggleable(),
                Tables\Columns\TextColumn::make('published_at')->label('Publicado em')->dateTime()->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('Destaque')->boolean(),
            ])
            ->filters([])
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
        ];
    }
}
