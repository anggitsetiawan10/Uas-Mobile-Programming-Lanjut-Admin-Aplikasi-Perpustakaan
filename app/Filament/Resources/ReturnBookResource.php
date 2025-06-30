<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnBookResource\Pages;
use App\Models\Loan;
use App\Models\ReturnBook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReturnBookResource extends Resource
{
    protected static ?string $model = ReturnBook::class;

    protected static ?string $navigationIcon = 'fluentui-book-arrow-clockwise-24';

    protected static ?string $navigationGroup = 'Peminjaman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('loan_id')
                    ->label('Loan') 
                    ->options(
                        Loan::with('user') 
                            ->get()
                            ->mapWithKeys(function ($loan) {
                                return [$loan->id => "Loan #{$loan->id} - {$loan->user->name}"];
                            })
                    )
                    ->required()
                    ->searchable(),

                Forms\Components\DatePicker::make('return_date')
                    ->label('Return Date')
                    ->required(),

                Forms\Components\TextInput::make('fine')
                    ->label('Fine (Denda)')
                    ->required()
                    ->numeric()
                    ->default(0.00),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('loan.id')
                    ->label('Loan ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('loan.user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('return_date')
                    ->label('Return Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fine')
                    ->label('Fine')
                    ->money('IDR', locale: 'id_ID') // tampilkan format uang
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make() ->label('Hapus'),
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
            'index' => Pages\ListReturnBooks::route('/'),
            'create' => Pages\CreateReturnBook::route('/create'),
            'edit' => Pages\EditReturnBook::route('/{record}/edit'),
        ];
    }
}
