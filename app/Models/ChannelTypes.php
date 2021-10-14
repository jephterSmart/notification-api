<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelTypes extends Model
{
    use HasFactory;

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
}
