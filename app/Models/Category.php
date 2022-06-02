<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'parent_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getChildren(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getRecursiveChildren(): HasMany
    {
        return $this->getChildren()->with('getRecursiveChildren');
    }
}
