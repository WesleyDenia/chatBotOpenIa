<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(\Closure $param)
 */
class Context extends Model
{

    use HasFactory;
    protected $fillable = [
        'keyword',
        'context',
        'completion'
    ];
}
