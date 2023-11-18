<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use CloudinaryLabs\CloudinaryLaravel\CloudinaryEngine;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

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
      $filename = $data['photo'];
      $pathInfo = pathinfo($filename);

      $cloudinaryEngine = new CloudinaryEngine();
      $filenameWithoutExtension = $pathInfo['filename'];


      $cloudinaryUrl = $cloudinaryEngine->getUrl($filenameWithoutExtension);
      $data['photo'] = $cloudinaryUrl;

      $post = Post::create($data);
      $user = auth()->user();
      $user->posts()->attach($post);

      return $post;
}

}
