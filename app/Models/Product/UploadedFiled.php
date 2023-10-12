<?php

namespace App\Models\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadedFiled extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_hash',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
