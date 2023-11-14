<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PetType: string implements HasLabel
{
  case Dog = 'dog';
  case Cat = 'cat';
  case Bird = 'bird';
  case Lizard = 'lizard';
  case Fish = 'fish';
  case Other = 'other';

  public function getLabel(): string
  {
    return match ($this) {
      self::Dog => 'Dog',
      self::Cat => 'Cat',
      self::Bird => 'Bird',
      self::Lizard => 'Lizard',
      self::Fish => 'Fish',
      self::Other => 'Other',
    };
  }
}
