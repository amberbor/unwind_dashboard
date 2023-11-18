<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;


class Post extends Model
{
    use HasFactory;

    protected $fillable =[
        'photo',
        'description',
        'location',
        'event_time',
    ];

     public function users()
    {
        return $this->belongsToMany(User::class, 'users_posts');
    }

       protected static function booted()
    {
        static::addGlobalScope(new RoleBasedScope());
    }
}

class RoleBasedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user(); // Get the logged-in user
        if (!$user || !$user->hasRole('admin')) {
            $builder->whereHas('users', function (Builder $query) use ($user) {
                $query->where('users.id', $user->id);
            });
        }
    }
}
//use Cloudinary\Configuration\Configuration;
//
//Configuration::instance([
//  'cloud' => [
//    'cloud_name' => 'dqmjatfqz',
//    'api_key' => '719444776498496',
//    'api_secret' => 'x6y_LAtPUsixeVIwW5K_s2NLhiQ'],
//  'url' => [
//    'secure' => true]]);
