<?php

namespace App\Filament\Resources\Posts\Schemas;

use Dom\Text;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;

use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
{
    return $schema
    ->components([
        // --- BAGIAN KIRI (2/3 dari total 3 kolom) ---
        Section::make("Post Details")
            ->description("Fill in the details of the post.")
            ->icon('heroicon-o-document-text')
            ->schema([
                TextInput::make("title")
                    ->required()
                    ->minLength(5) // [Perbaikan Tugas 1] Title minimal 5 karakter
                    ->validationMessages([ // [Tugas 3] Custom message 1
                        'required' => 'Judul artikel wajib diisi.',
                        'min'      => 'Judul harus terdiri dari minimal 5 karakter.' 
                    ]),
                
                TextInput::make("slug")
                    ->required()
                    ->minLength(3) // [Perbaikan Tugas 1] Slug minimal 3 karakter
                    ->unique(ignoreRecord: true) // [Perbaikan Tugas 1] Tambahkan ignoreRecord agar aman saat diedit
                    ->validationMessages([ // [Tugas 3] Custom message 2
                        'unique' => 'Slug ini sudah dipakai, silakan gunakan yang lain.'
                    ]),
                    
                Select::make("category_id")
                    ->relationship("category", "name")
                    ->preload()
                    ->searchable()
                    ->required(), // [Sudah Benar Tugas 1] Category wajib dipilih
                    
                ColorPicker::make("color"),
                
                MarkdownEditor::make("content")
                    ->columnSpanFull(), // Agar editor memenuhi 2 kolom
            ])
            ->columns(2) // Membuat tampilan rapi: 2 kolom untuk field utama
            ->columnSpan(2), // Field kiri mengambil porsi 2/3

        // --- BAGIAN KANAN (1/3 dari total 3 kolom) ---
        Group::make([
            // Section 2: Media
            Section::make("Image Upload")
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make("image")
                        ->disk("public")
                        ->directory("posts")
                        ->required(), // [Sudah Benar Tugas 1] Image wajib diupload
                ]),

            // Section 3: Meta
            Section::make("Meta Information")
                ->icon('heroicon-o-tag')
                ->schema([
                    TagsInput::make("tags"),
                    Checkbox::make("published"),
                    DateTimePicker::make("published_at"),
                ]),
        ])->columnSpan(1), // Meta kanan mengambil porsi 1/3

    ])->columns(3); // Total grid adalah 3 kolom // Total grid adalah 3 kolom
}
}
