<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadModule extends Model
{
    use HasFactory;
    public $fillable = [
        'test_name',
        'subject',
        'title',
        'amount',
        'image',
    ];
}
