<?php

namespace App\Filament\Resources\LandingTestimonials\Tables;

use App\Enums\TestimonialPlacement;
use App\Enums\TestimonialType;
use App\Models\LandingTestimonial;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LandingTestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('النوع')
                    ->formatStateUsing(fn (?TestimonialType $state): string => $state?->getLabel() ?? '—')
                    ->badge()
                    ->color(fn (?TestimonialType $state): string => $state?->color() ?? 'gray'),
                TextColumn::make('placements')
                    ->label('أماكن الظهور')
                    ->formatStateUsing(fn (mixed $state): string => collect(Arr::wrap($state))
                        ->filter(fn (mixed $placement): bool => $placement instanceof TestimonialPlacement)
                        ->map(fn (TestimonialPlacement $placement): string => $placement->getLabel())
                        ->join(' · '))
                    ->badge(),
                TextColumn::make('author_name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('author_location')
                    ->label('الموقع')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('التقييم')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->beforeReordering(function ($livewire): void {
                $livewire->testimonialOrderBeforeReordering = LandingTestimonial::query()
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->pluck('id')
                    ->all();
            })
            ->afterReordering(function (array $order, $livewire): void {
                self::keepGlobalOrderWhileReordering($order, $livewire->testimonialOrderBeforeReordering);

                $livewire->testimonialOrderBeforeReordering = [];
            })
            ->filters([
                SelectFilter::make('placement')
                    ->label('مكان الظهور')
                    ->options(TestimonialPlacement::class)
                    ->query(fn (Builder $query, mixed $state): Builder => self::whereAnyPlacement($query, $state)),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Matches testimonials placed on any of the selected pages. Filament hands
     * the filter state over both as a list of raw values and as a single enum
     * while it counts the options, hence the normalisation.
     *
     * @return list<string>
     */
    private static function selectedPlacements(mixed $state): array
    {
        return collect(Arr::wrap($state))
            ->map(fn (mixed $placement): mixed => $placement instanceof TestimonialPlacement
                ? $placement->value
                : $placement)
            ->filter(fn (mixed $placement): bool => is_string($placement)
                && TestimonialPlacement::tryFrom($placement) !== null)
            ->values()
            ->all();
    }

    private static function whereAnyPlacement(Builder $query, mixed $state): Builder
    {
        $placements = self::selectedPlacements($state);

        if ($placements === []) {
            return $query;
        }

        return $query->where(
            fn (Builder $query) => collect($placements)
                ->each(fn (string $placement) => $query->orWhereJsonContains('placements', $placement))
        );
    }

    /**
     * Filament renumbers only the rows it was given, starting from 1, so
     * reordering a filtered subset would hand those rows the sort_order values
     * the hidden testimonials already hold and leave both sections with ties.
     *
     * The moved rows keep the slots they held in the full list and take the new
     * order as values, which is what makes "filter to the kids testimonials,
     * then reorder them" give the kids section the requested order while the
     * hidden rows keep their relative positions.
     *
     * @param  array<int, string|int>  $order
     * @param  array<int, int>  $globalOrder
     */
    private static function keepGlobalOrderWhileReordering(array $order, array $globalOrder): void
    {
        if ($globalOrder === []) {
            return;
        }

        $reordered = array_map(intval(...), array_values($order));
        $slots = array_keys(array_intersect($globalOrder, $reordered));
        $merged = $globalOrder;

        foreach ($slots as $index => $position) {
            $merged[$position] = $reordered[$index];
        }

        DB::transaction(function () use ($merged): void {
            foreach ($merged as $index => $id) {
                LandingTestimonial::query()->whereKey($id)->update(['sort_order' => $index + 1]);
            }
        });
    }
}
