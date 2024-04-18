<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected string $table = "posts";
    protected string $primaryKey = "id";
    protected string $keyType = "int";
    public bool $timestamps = true;
    public bool $incrementing = true;
    protected array $fillable = [
        'title',
        'user_id',
        'category_id',
        'image',
        'video',
        'subtitle',
        'content',
    ];

    public function category(): BelongsTo
    {
        return $this -> belongsTo(Category::class);
    }
}
