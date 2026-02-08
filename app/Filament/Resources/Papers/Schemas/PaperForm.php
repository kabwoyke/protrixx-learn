<?php

namespace App\Filament\Resources\Papers\Schemas;

use Filament\Actions\AttachAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class PaperForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),


                Select::make('category_id')
                    ->relationship('category' , 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('grade_level_id')
                    ->relationship('grade_level' , 'name')
                    ->searchable()
                    ->columnSpan(2)
                    ->preload(),

                FileUpload::make('file_path')
                    ->disk('spaces')
                    ->directory('papers')
                    ->visibility('public')
                    ->columnSpan(2)
                    ->preserveFilenames(),

                FileUpload::make('preview_path')
                    ->disk('spaces')
                    ->directory('papers')
                    ->columnSpan(2)
                    ->visibility('public')
                    ->preserveFilenames(),

            ]);
    }
}
