<?php

namespace App\Models\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadHistory extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'uploaded_at', 'upload_status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
