<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'upstream_uri',
        'client_ip',
        'consumer_id',
        'started_at',
    ];

    public function request()
    {
        return $this->hasOne(Request::class);
    }

    public function response()
    {
        return $this->hasOne(Response::class);
    }

    public function latency()
    {
        return $this->hasOne(Latency::class);
    }
}
