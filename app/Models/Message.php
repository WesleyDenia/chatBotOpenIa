<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $from)
 */
class Message extends Model
{
    use HasFactory;

    // Permitir atribuição em massa dos seguintes campos
    protected $fillable = [
        'whatsapp_id',
        'from',
        'to',
        'content',
        'response',
        'profile_name',
    ];
}
