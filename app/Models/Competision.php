<?php

namespace App\Models;

use App\Observers\CompetisionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competision extends Model
{
    use HasFactory;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'name',
        'count_session',
        'count_korwil',
        'count_gantangan',
        'count_korwil_per_session',
        'count_more_per_session',
        'status',
        'tgl'
    ];
    protected $casts = [
        'id' => 'string',
    ];


    public static function boot(): void
    {
        parent::boot();
        self::observe(CompetisionObserver::class);
    }
}
