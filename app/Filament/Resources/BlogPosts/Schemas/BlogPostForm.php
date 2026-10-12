<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Filament\Schemas\Components\AudioRichEditor;
use App\Support\RichEditorAudio\AudioPlugin;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make('المحتوى')
                            ->schema([
                                TextInput::make('title')
                                    ->label('العنوان')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str($state)->slug()))
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->label('الرابط (Slug)')
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('اتركه فارغاً للإنشاء تلقائياً من العنوان')
                                    ->columnSpanFull(),
                                Select::make('categories')
                                    ->label('التصنيفات')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Textarea::make('excerpt')
                                    ->label('الملخص')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                AudioRichEditor::make('body')
                                    ->label('محتوى المقال')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('blog/attachments')
                                    ->fileAttachmentsAcceptedFileTypes(AudioPlugin::ACCEPTED_FILE_TYPES)
                                    ->fileAttachmentsMaxSize(AudioPlugin::MAX_FILE_SIZE_KB)
                                    ->plugins([app(AudioPlugin::class)])
                                    ->required()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('الإعدادات')
                            ->schema([
                                Section::make('معلومات الكاتب والغطاء')
                                    ->schema([
                                        TextInput::make('author_name')
                                            ->label('اسم الكاتب')
                                            ->required()
                                            ->maxLength(255),
                                        FileUpload::make('author_image')
                                            ->label('صورة الكاتب')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                            ->disk('public')
                                            ->directory('blog/authors')
                                            ->imageResizeMode('cover')
                                            ->imageEditor(),
                                        FileUpload::make('cover_image')
                                            ->label('صورة الغلاف')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                            ->disk('public')
                                            ->directory('blog/covers')
                                            ->imageResizeMode('cover')
                                            ->imageEditor(),
                                        TextInput::make('reading_time')
                                            ->label('وقت القراءة (دقائق)')
                                            ->numeric()
                                            ->required()
                                            ->default(5),
                                    ])
                                    ->columns(2),

                                Section::make('النشر')
                                    ->schema([
                                        DateTimePicker::make('published_at')
                                            ->label('تاريخ النشر')
                                            ->default(now())
                                            ->required(),
                                        Toggle::make('is_featured')
                                            ->label('مقال مميز')
                                            ->default(false),
                                        Toggle::make('is_active')
                                            ->label('نشط')
                                            ->default(true),
                                    ])
                                    ->columns(3),
                            ]),

                        Tab::make('المقالات المرتبطة')
                            ->schema([
                                Select::make('relatedPosts')
                                    ->label('مقالات مرتبطة')
                                    ->helperText('اختر مقالات أخرى مماثلة لتظهر في نهاية هذا المقال كترشيحات — يمكن الاختيار من أي تصنيف. إن تُرك فارغاً تظهر تلقائياً مقالات من نفس التصنيف.')
                                    ->relationship('relatedPosts', 'title', ignoreRecord: true)
                                    ->multiple()
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Tab::make('تحسين محركات البحث (SEO)')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('عنوان الميتا (Meta Title)')
                                    ->helperText('يُوصى بألا يتجاوز 60 حرفاً')
                                    ->maxLength(60)
                                    ->live()
                                    ->hint(fn (?string $state): string => mb_strlen((string) $state).'/60')
                                    ->columnSpan(1),
                                Textarea::make('meta_description')
                                    ->label('وصف الميتا (Meta Description)')
                                    ->helperText('يُوصى بألا يتجاوز 160 حرفاً')
                                    ->maxLength(160)
                                    ->rows(3)
                                    ->live()
                                    ->hint(fn (?string $state): string => mb_strlen((string) $state).'/160')
                                    ->columnSpan(1),
                                FileUpload::make('og_image')
                                    ->label('صورة المشاركة (Open Graph)')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->disk('public')
                                    ->directory('images/og')
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('630')
                                    ->columnSpan(1),
                                Select::make('schema_type')
                                    ->label('نوع Schema')
                                    ->options([
                                        'Article' => 'Article',
                                        'BlogPosting' => 'BlogPosting',
                                        'NewsArticle' => 'NewsArticle',
                                        'FAQPage' => 'FAQPage',
                                    ])
                                    ->default('Article')
                                    ->columnSpan(1),
                                Toggle::make('is_indexed')
                                    ->label('السماح لفهارس البحث (Allow search engine indexing)')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
}
