<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus: string implements HasLabel
{
  case CREATED = 'created';
  case CONFIRMED = 'confirmed';
  case CANCELLED = 'cancelled';


  public function getLabel(): string
  {
    return match ($this) {
      self::CREATED => 'Created',
      self::CONFIRMED => 'Confirmed',
      self::CANCELLED => 'Cancelled',
    };
  }
}
