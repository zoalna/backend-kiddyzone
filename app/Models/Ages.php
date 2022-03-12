<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ages extends Model
{
    use HasFactory;

    protected $table = 'ages';

    protected $fillable = ['from_age','to_age','image_url'];
    
}
