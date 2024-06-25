<?php

namespace App\Models;

use App\Observers\RegisterCompetisionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterCompetision extends Model
{
    use HasFactory;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'competision_id',
        'number',
        'no_session',
        'name',
        'phone',
        'address',
        'photo',
        'korwil_id'
    ];
    protected $casts = [
        'id' => 'string',
    ];


    public static function boot(): void
    {
        parent::boot();
        self::observe(RegisterCompetisionObserver::class);
    }
}
