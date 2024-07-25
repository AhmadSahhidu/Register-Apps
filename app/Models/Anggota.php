<?php

namespace App\Models;

use App\Observers\AnggotaObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggota extends Model
{
    use HasFactory;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'korda_id',
        'korwil_id',
        'number',
        'name',
        'phone',
        'address',
        'photo'
    ];
    protected $casts = [
        'id' => 'string',
    ];


    public static function boot(): void
    {
        parent::boot();
        self::observe(AnggotaObserver::class);
    }

    public function korwil(): BelongsTo
    {
        return $this->belongsTo(Korwil::class, 'korwil_id', 'id');
    }

    public function korda(): BelongsTo
    {
        return $this->belongsTo(Korda::class, 'korda_id', 'id');
    }
}
