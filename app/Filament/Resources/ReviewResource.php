<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use App\Models\User;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star'; 

    protected static ?string $navigationGroup = 'Manajemen Buku';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->required()
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),

                Forms\Components\Select::make('book_id')
                    ->label('Book')
                    ->required()
                    ->options(Book::all()->pluck('title', 'id'))
                    ->searchable(),

                Forms\Components\ToggleButtons::make('rating')
                    ->options([
                            5 => 'Sangat Bagus',
                            4 => 'Bagus',
                            2 => 'Buruk',
                        ])
                        ->colors([
                            5 => 'info',
                            4 => 'warning',
                            2 => 'danger',
                        ])
                        ->icons([
                            5 => 'heroicon-s-star',
                            4 => 'heroicon-o-hand-thumb-up',
                            2 => 'heroicon-o-hand-thumb-down',
                        ])
                        ->required(),

                Forms\Components\MarkdownEditor::make('comment')
                    ->label('Comment')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('book.title')
                    ->label('Book')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable(),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                 ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
