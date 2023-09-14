<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Berita extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = "master_berita";

    protected $fillable = [
        "judul",
        "konten",
        "slug",
        "thumbnail",
        "category_id",
        "author_id",
    ];

    public function sluggable(): array
    {
        return [
            "post_slug" => [
                "source" => "post_title",
            ],
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function author()
    {
        return $this->belongsTo(User::class, "author_id");
    }

    public function tag()
    {
        return $this->belongsToMany(
            Tag::class,
            "berita_tag",
            "id_berita",
            "id_tag"
        );
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("judul", "like", $term);
        });
    }
}
