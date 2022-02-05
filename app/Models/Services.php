<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $fillable=['title', 'descriptions', 'category'];

    public function images(){
        return $this->morphMany('App\Models\Images', 'imageable');
    }
}
