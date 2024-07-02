<?php

namespace App\Models;

use App\Observers\RequestRegisterCompetisionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestRegisterCompetision extends Model
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
        'name',
        'phone',
        'address',
        'korwil_id',
    ];
    protected $casts = [
        'id' => 'string',
    ];


    public static function boot(): void
    {
        parent::boot();
        self::observe(RequestRegisterCompetisionObserver::class);
    }

    public function korwil(): BelongsTo
    {
        return $this->belongsTo(Korwil::class, 'korwil_id', 'id');
    }
}
