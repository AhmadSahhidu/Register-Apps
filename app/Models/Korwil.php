<?php

namespace App\Models;

use App\Observers\KorwilObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korwil extends Model
{
    use HasFactory;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
    protected $casts = [
        'id' => 'string',
    ];


    public static function boot(): void
    {
        parent::boot();
        self::observe(KorwilObserver::class);
    }
}
