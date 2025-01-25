<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(int[] $array, array $array1)
 * @method static where(string $string, string $key)
 */
class BotSetting extends Model
{
    protected $fillable = ['key', 'value'];
}
