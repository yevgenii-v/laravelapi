<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public const IS_ADMIN = 1;
    public const IS_SUPPORT = 2;
    public const IS_USER = 3;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
