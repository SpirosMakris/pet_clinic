<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    use HasFactory;

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function clinic(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    public $fillable = [
        'pet_id',
        'date',
        'start',
        'end',
        'description',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'status' => AppointmentStatus::class,
    ];
}
