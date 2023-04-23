<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    // リレーション定義　カテゴリー(1)：プロダクツ(多)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
