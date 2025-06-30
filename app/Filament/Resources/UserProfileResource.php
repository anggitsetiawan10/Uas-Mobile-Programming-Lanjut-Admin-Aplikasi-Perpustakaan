<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProfileResource\Pages;
use App\Models\UserProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserProfileResource extends Resource
{
    protected static ?string $model = UserProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Profil Pengguna';
    protected static ?string $pluralModelLabel = 'Profil Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // User hanya muncul jika belum punya profil
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'email',
                        modifyQueryUsing: fn ($query) => $query->whereDoesntHave('profile')
                    )
                    ->required()
                    ->searchable()
                    ->visibleOn('create'),

                // Untuk edit (readonly)
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'email')
                    ->disabled()
                    ->visibleOn('edit'),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Lengkap'),

                Forms\Components\Select::make('gender')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required()
                    ->label('Jenis Kelamin'),

                Forms\Components\TextInput::make('birth_place')
                    ->required()
                    ->label('Tempat Lahir'),

                Forms\Components\DatePicker::make('birth_date')
                    ->required()
                    ->label('Tanggal Lahir'),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->label('No. Telepon'),

                Forms\Components\Textarea::make('address')
                    ->required()
                    ->label('Alamat'),

                Forms\Components\TextInput::make('occupation')
                    ->label('Pekerjaan'),

                Forms\Components\TextInput::make('institution')
                    ->label('Instansi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')->label('User'),
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('gender')->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('birth_place')->label('Tempat Lahir'),
                Tables\Columns\TextColumn::make('birth_date')->label('Tanggal Lahir')->date(),
                Tables\Columns\TextColumn::make('phone')->label('Telepon'),
                Tables\Columns\TextColumn::make('occupation')->label('Pekerjaan')->sortable(),
                Tables\Columns\TextColumn::make('institution')->label('Instansi')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                        'Lainnya' => 'Lainnya',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserProfiles::route('/'),
            'create' => Pages\CreateUserProfile::route('/create'),
            'edit' => Pages\EditUserProfile::route('/{record}/edit'),
        ];
    }
}
