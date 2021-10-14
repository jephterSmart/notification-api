<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelProvider extends Model
{
    use HasFactory;

    public function channel()
    {
        return $this->belongsTo(ChannelType::class);
    }
}
