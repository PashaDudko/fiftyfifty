<?php

namespace App\Models;

use App\Enums\Order as OrderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'status'
    ];

    protected $casts = [
        'status' => OrderEnum::class,
    ];

    public function getLogoImgAttribute(): string
    {
        if (!$this->logo) {
            return asset('storage/shops/default.jpeg');
        }

        return Storage::disk('public')->url($this->logo);
    }
}
