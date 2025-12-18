<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationGroup(): ?string
    {
        return 'Blog';
    }

    public static function getNavigationLabel(): string
    {
        return 'Comentários';
    }

    public static function getModelLabel(): string
    {
        return 'Comentário';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Comentários';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('post_id')->label('Post')
                    ->relationship('post', 'title')->searchable()->preload()->required(),
                Forms\Components\Select::make('user_id')->label('Usuário')
                    ->relationship('user', 'name')->searchable()->preload()->nullable(),
                Forms\Components\Select::make('parent_id')->label('Comentário pai')
                    ->relationship('parent', 'id')->nullable(),
                Forms\Components\Textarea::make('content')->label('Conteúdo')->required()->columnSpanFull(),
                Forms\Components\Select::make('status')->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Rejeitado',
                    ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post.title')->label('Post')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Usuário')->toggleable(),
                Tables\Columns\TextColumn::make('content')->label('Conteúdo')->limit(50),
                Tables\Columns\BadgeColumn::make('status')->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Rejeitado',
                        default => $state,
                    }),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
