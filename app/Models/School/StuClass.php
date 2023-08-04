<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StuClass extends Model
{
    use HasFactory;
    protected $fillable=['class_name'];
}
