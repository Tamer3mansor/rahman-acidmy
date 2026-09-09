<?php

namespace App\Filament\Resources\PricingPackages\Pages;

use App\Filament\Resources\PricingPackages\PricingPackageResource;
use App\Models\PricingSettings;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListPricingPackages extends ListRecords
{
    protected static string $resource = PricingPackageResource::class;

    public function getSubheading(): ?string
    {
        return 'السعر العام للساعة: '.number_format(PricingSettings::singleton()->per_hour_price, 2).' € — تُحسب الباقات من نوع "السعر/ساعة" تلقائياً منه.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('editGlobalPrice')
                ->label('تعديل السعر العام')
                ->icon(Heroicon::OutlinedCurrencyEuro)
                ->modalHeading('تعديل السعر العام للحصة')
                ->modalDescription('يُحدَّث تلقائياً في كل الباقات من نوع "السعر/ساعة".')
                ->schema([
                    TextInput::make('per_hour_price')
                        ->label('السعر/ساعة (€)')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->suffix('€')
                        ->default(fn (): float => PricingSettings::singleton()->per_hour_price),
                ])
                ->action(function (array $data): void {
                    PricingSettings::singleton()->update([
                        'per_hour_price' => $data['per_hour_price'],
                    ]);

                    Notification::make()
                        ->title('تم تحديث السعر العام')
                        ->success()
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
