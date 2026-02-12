<?php

namespace App\Filament\Resources\Papers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaperInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('year')
                    ->numeric(),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('type'),
                TextEntry::make('file_path'),
                TextEntry::make('preview_path'),
                // TextEntry::make('category_id')
                //     ->numeric(),
                // TextEntry::make('grade_level_id')
                //     ->numeric(),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ]);
    }
}
