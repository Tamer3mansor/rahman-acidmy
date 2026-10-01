<?php

namespace App\Filament\Resources\LandingTestimonials\Pages;

use App\Filament\Resources\LandingTestimonials\LandingTestimonialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLandingTestimonials extends ListRecords
{
    protected static string $resource = LandingTestimonialResource::class;

    /**
     * Every testimonial id in the order the table showed them, captured before a
     * reorder is written. Filament renumbers the rows it was handed from 1, so
     * reordering a filtered subset needs the full list to hand the moved rows
     * their old slots instead of colliding with the hidden ones.
     *
     * @var array<int, int>
     */
    public array $testimonialOrderBeforeReordering = [];

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
