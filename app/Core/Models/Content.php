<?php

namespace App\Core\Models;

use Database\Factories\ContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'title',
        'category_id',
        'thumbnail',
        'attach',
        'type',
        'user_id'
    ];

    protected $appends = [
        'excerpt'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function newFactory()
    {
        return new ContentFactory();
    }

    public function getExcerptAttribute()
    {
        return substr(strip_tags($this->content), 0, 100) . '...';
    }
}
