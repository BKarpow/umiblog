<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSection extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasMany('App\Models\ProductCategory', 'section_id', 'id');
    }

    public function dateCreate():string
    {
        if (!empty($this->created_at)) {
            return $this->created_at->format('d-m-Y H:i');
        } else {
            return '';
        }
    }

    public function dateUpdate():string
    {
        if (!empty($this->updated_at)) {
            return $this->updated_at->format('d-m-Y H:i');
        } else {
            return '';
        }
    }
}
