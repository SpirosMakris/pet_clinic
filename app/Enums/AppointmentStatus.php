<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus: string implements HasLabel, HasColor
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

  public function getcolor(): string | array | null
  {
    return match ($this) {
      self::CREATED => 'warning',
      self::CONFIRMED => 'success',
      self::CANCELLED => 'danger',
    };
  }
}
