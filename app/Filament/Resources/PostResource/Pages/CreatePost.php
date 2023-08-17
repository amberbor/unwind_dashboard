<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Post Created';
    }
public function createAnother(): void
{
    $this->create(another: true);
}
  protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
  {
    $post = Post::create($data);

    // Add logic to attach the post to the user
    $user = auth()->user(); // Assuming you have authentication
    $user->posts()->attach($post);

    return $post;
}

}
