<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public $fillable = [
        'pet_id',
        'date',
        'start',
        'end',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'status' => AppointmentStatus::class,
    ];
}
