<?php

namespace App\Modules\Notices\Filament\Resources\NoticeResource\RelationManagers;

use App\Enums\Language;
use App\Modules\Notices\Notice;
use App\Modules\Notices\Services\TranslateNotice;
use App\Modules\Notices\TranslatedNotice;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class TranslatedNoticesRelationManager extends RelationManager
{
    protected static string $relationship = 'translatedNotices';

    protected static ?string $title = 'Translations';

    public function form(Form $form): Form
    {
        $contentMaxLength = 300;

        return $form
            ->schema([
                Toggle::make('enable_auto_translation')
                    ->live()
                    ->default(true),

                Select::make('language')
                    ->required()
                    ->formatStateUsing(fn (?TranslatedNotice $record) => $record?->getLanguage()->name)
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: function (Unique $rule) {
                            return $rule->where('notice_id', $this->ownerRecord->id);
                        })
                    ->options(
                        Language::collect()
                            ->filter(fn (Language $language) => $language->name !== 'en')
                            ->mapWithKeys(fn (Language $language) => [$language->name => $language->getEnglishLabel()])
                    ),

                Textarea::make('content')
                    ->columnSpan(2)
                    ->maxLength(fn (Get $get) => $get('enable_auto_translation') === false ? $contentMaxLength : null)
                    ->rows(10)
                    ->required(fn (Get $get) => $get('enable_auto_translation') === false)
                    ->disabled(fn (Get $get) => $get('enable_auto_translation') === true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('language')
                    ->label('')
                    ->getStateUsing(fn (TranslatedNotice $record) => $record->getLanguage()->getEnglishLabel()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Translation')
                    ->after(function (TranslatedNotice $record) {
                        if ($record->enable_auto_translation) {
                            $translateNotice = resolve(TranslateNotice::class);
                            $translateNotice->singleTranslation($record);
                        }
                    }),
                Tables\Actions\Action::make('create-all-translations')
                    ->label('Create all missing translations')
                    ->action(function () {
                        /** @var Notice $notice */
                        $notice = $this->ownerRecord;

                        $noticeLanguages = $notice->translatedNotices
                            ->map(fn (TranslatedNotice $translateNotice) => $translateNotice->getLanguage()->name);

                        Language::collect()
                            ->map(fn (Language $language) => $language->name)
                            ->filter(fn (string $lang) => $lang !== 'en')
                            ->diff($noticeLanguages)
                            ->each(function (string $language) use ($notice) {
                                return $notice->translatedNotices()
                                    ->create(['language' => $language, 'enable_auto_translation' => true]);
                            });
                        $notice->unsetRelations();

                        $translateNotice = resolve(TranslateNotice::class);
                        $translateNotice($notice);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (TranslatedNotice $record) {
                        if ($record->enable_auto_translation && ! empty($this->oldFormState)) {
                            $translateNotice = resolve(TranslateNotice::class);
                            $translateNotice->singleTranslation($record);
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
