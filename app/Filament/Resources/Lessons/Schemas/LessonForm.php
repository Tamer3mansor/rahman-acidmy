<?php

namespace App\Filament\Resources\Lessons\Schemas;

use App\Filament\Schemas\Components\AudioRichEditor;
use App\Support\RichEditorAudio\AudioPlugin;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class LessonForm
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
                                Select::make('categories')
                                    ->label('التصنيفات')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('title')
                                    ->label('العنوان')
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str($state)->slug()))
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->label('الرابط (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),
                                Textarea::make('excerpt')
                                    ->label('الملخص')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                AudioRichEditor::make('body')
                                    ->label('محتوى الدرس')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('lessons/attachments')
                                    ->fileAttachmentsAcceptedFileTypes(AudioPlugin::ACCEPTED_FILE_TYPES)
                                    ->fileAttachmentsMaxSize(AudioPlugin::MAX_FILE_SIZE_KB)
                                    ->plugins([app(AudioPlugin::class)])
                                    ->helperText('يمكنك إدراج ملف صوتي داخل المحتوى، أو استخدام الصيغة: [audio:URL]')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('الإعدادات')
                            ->schema([
                                Section::make('الوسائط والروابط')
                                    ->schema([
                                        FileUpload::make('cover_image')
                                            ->label('صورة الغلاف')
                                            ->image()
                                            ->disk('public')
                                            ->directory('lessons/covers')
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('16:9')
                                            ->imageEditor()
                                            ->rule('dimensions:ratio=16/9')
                                            ->validationMessages([
                                                'dimensions' => 'صورة الغلاف يجب أن تكون بنسبة 16:9 (مثال: 1920×1080). ارفع صورة بمقاس أفقي كبير.',
                                            ])
                                            ->helperText('المقاس المطلوب: نسبة 16:9 بدقة كبيرة (يُفضّل 1920×1080).')
                                            ->columnSpanFull(),
                                        FileUpload::make('audio_url')
                                            ->label('الملف الصوتي الرئيسي')
                                            ->acceptedFileTypes([
                                                'audio/mpeg',
                                                'audio/mp3',
                                                'audio/mpeg3',
                                                'audio/x-mpeg',
                                                'audio/x-mp3',
                                                'audio/wav',
                                                'audio/x-wav',
                                                'audio/wave',
                                                'audio/ogg',
                                                'audio/oga',
                                                'audio/mp4',
                                                'audio/x-m4a',
                                                'audio/m4a',
                                                'audio/aac',
                                                'audio/webm',
                                            ])
                                            ->maxSize(51200)
                                            ->disk('public')
                                            ->directory('lessons/audio')
                                            ->helperText('ارفع الملف الصوتي الرئيسي للدرس (MP3، WAV، OGG…). الحد الأقصى 50 ميجابايت.')
                                            ->columnSpanFull(),
                                        FileUpload::make('pdf_url')
                                            ->label('ملف PDF')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->disk('public')
                                            ->directory('lessons/pdfs')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        Select::make('courses')
                                            ->label('الدورات المرتبطة')
                                            ->relationship('courses', 'title')
                                            ->multiple()
                                            ->searchable()
                                            ->preload(),
                                    ])
                                    ->columns(2),

                                Section::make('النشر')
                                    ->schema([
                                        TextInput::make('reading_time')
                                            ->label('وقت القراءة (دقائق)')
                                            ->numeric(),
                                        TextInput::make('sort_order')
                                            ->label('الترتيب')
                                            ->numeric(),
                                        Toggle::make('is_active')
                                            ->label('نشط')
                                            ->default(true),
                                    ])
                                    ->columns(3),
                            ]),

                        Tab::make('الدروس المرتبطة')
                            ->schema([
                                Select::make('relatedLessons')
                                    ->label('دروس مرتبطة')
                                    ->helperText('اختر دروساً أخرى مماثلة لتظهر في نهاية هذا الدرس كترشيحات — يمكن الاختيار من أي فئة. إن تُرك فارغاً تظهر تلقائياً دروس من نفس الفئة.')
                                    ->relationship('relatedLessons', 'title', ignoreRecord: true)
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
                                    ->image()
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
