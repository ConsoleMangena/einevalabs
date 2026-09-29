<?php

namespace App\Filament\Resources\ContactSubmissionResource\Pages;

use App\Filament\Resources\ContactSubmissionResource;
use Filament\Resources\Pages\ListRecords;

class ListContactSubmissions extends ListRecords
{
    protected static string $resource = ContactSubmissionResource::class;

    /*
     * No getHeaderActions() override: the base returns an empty array, and
     * adding a CreateAction here would contradict
     * ContactSubmissionPolicy::create() and Surface a button that 403s.
     */
}
