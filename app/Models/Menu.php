<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * Метод формує коректне посилання щалежно від налаштування route
     * @return string
     */
    public function href():string
    {
        if ((bool)$this->route) {
            return route($this->href);
        } else {
            return $this->href;
        }
    }
}
