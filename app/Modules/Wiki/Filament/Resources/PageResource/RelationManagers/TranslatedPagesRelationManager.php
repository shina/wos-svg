<?php

namespace App\Modules\Wiki\Filament\Resources\PageResource\RelationManagers;

use App\Enums\Language;
use App\Modules\Wiki\Page;
use App\Modules\Wiki\Services\TranslatePage;
use App\Modules\Wiki\TranslatedPage;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class TranslatedPagesRelationManager extends RelationManager
{
    protected static string $relationship = 'translatedPages';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('enable_auto_translation')
                    ->live()
                    ->default(true),

                Select::make('language')
                    ->required()
                    ->formatStateUsing(fn (?TranslatedPage $record) => $record?->getLanguage()->name)
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: function (Unique $rule) {
                            return $rule->where('page_id', $this->ownerRecord->id);
                        })
                    ->options(
                        Language::collect()
                            ->filter(fn (Language $language) => $language->name !== 'en')
                            ->mapWithKeys(fn (Language $language) => [$language->name => $language->getEnglishLabel()])
                    ),

                Textarea::make('content')
                    ->columnSpan(2)
                    ->rows(10)
                    ->required(fn (Get $get) => $get('enable_auto_translation') === false)
                    ->disabled(fn (Get $get) => $get('enable_auto_translation') === true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('language')
            ->columns([
                Tables\Columns\TextColumn::make('language')
                    ->label('')
                    ->getStateUsing(fn (TranslatedPage $record) => $record->getLanguage()->getEnglishLabel()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Translation')
                    ->after(function (TranslatedPage $record) {
                        if ($record->enable_auto_translation) {
                            $translatePage = resolve(TranslatePage::class);
                            $translatePage->singleTranslation($record);
                        }
                    }),
                Tables\Actions\Action::make('create-all-translations')
                    ->label('Create all missing translations')
                    ->action(function () {
                        // todo make a service for that and use in the command too

                        /** @var Page $page */
                        $page = $this->ownerRecord;

                        $pageLanguages = $page->translatedPages
                            ->map(fn (TranslatedPage $translatedPage) => $translatedPage->getLanguage()->name);

                        Language::collect()
                            ->map(fn (Language $language) => $language->name)
                            ->filter(fn (string $lang) => $lang !== 'en')
                            ->diff($pageLanguages)
                            ->each(function (string $language) use ($page) {
                                return $page->translatedPages()
                                    ->create(['language' => $language, 'enable_auto_translation' => true]);
                            });
                        $page->unsetRelations();

                        $translatePage = resolve(TranslatePage::class);
                        $translatePage($page);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (TranslatedPage $record) {
                        if ($record->enable_auto_translation && ! empty($this->oldFormState)) {
                            $translatePage = resolve(TranslatePage::class);
                            $translatePage->singleTranslation($record);
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
