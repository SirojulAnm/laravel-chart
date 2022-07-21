<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActualVsBbc extends Model
{
    use HasFactory;

    protected $table = 'actual_vs_bbc';
    protected $fillable   = [
        'code_ba','actual_vs_bbc'
    ];
}
