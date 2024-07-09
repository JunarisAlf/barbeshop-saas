<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbershop extends Model
{
    use HasFactory;
    protected function coordinate(): Attribute{
        return Attribute::make(
            get: function(): string {
                    if ($this->latitude == null || $this->longtitude == null){
                        return '-';
                    }
                    return "$this->latitude, $this->longtitude";
                }   
        );
    }
    protected function countDown(): Attribute{
        return Attribute::make(
            get: fn() => Carbon::parse($this->expired_date)->diffForHumans() 
        );
    }
}