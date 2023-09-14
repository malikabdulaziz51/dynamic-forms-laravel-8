<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = "tag";

    protected $fillable = ["nama", "slug"];

    public function tag(): BelongsToMany
    {
        return $this->belongsToMany(
            Berita::class,
            "berita_tag",
            "id_berita",
            "id_tag"
        );
    }
}
