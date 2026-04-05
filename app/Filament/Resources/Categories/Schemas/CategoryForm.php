<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                ->required(),
                TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true) // Menambahkan validasi slug harus unik,
                ->maxLength(255), // Menambahkan validasi maksimal 255 karakter
            ]);
    }
}
