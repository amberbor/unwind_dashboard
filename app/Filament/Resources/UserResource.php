<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = "Settings";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(50),
                    Forms\Components\DateTimePicker::make('email_verified_at'),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn($state)=>Hash::make($state))
                        ->dehydrated(fn($state)=>filled($state))
                        ->required(fn(Page $livewire) => ($livewire instanceof Createuser))
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('photo')->image()
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->rows(10)
                        ->cols(20)
                        ->required(),
                    Forms\Components\Select::make('category')
                        ->options([
                            'techno' => 'Techno',
                            'live-music' => 'Live Music',
                            'concert' => 'Concert',
                            'hiking' => 'Hiking',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('location')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone_number')
                        ->required()
                        ->maxLength(255),
                Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')->preload(),
                Select::make('permissions')
                    ->multiple()
                    ->relationship('permissions', 'name')->preload()])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
