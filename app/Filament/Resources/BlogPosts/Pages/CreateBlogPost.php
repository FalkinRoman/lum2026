<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Models\BlogPost;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function afterCreate(): void
    {
        BlogPost::moveToPosition($this->record, (int) $this->record->sort_order);
    }
}
