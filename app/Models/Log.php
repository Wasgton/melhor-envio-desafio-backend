<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Log extends Model
{
    use HasFactory;   
    protected $fillable = [
        'id',
        'upstream_uri',
        'client_ip',
        'consumer_id',
        'started_at',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::orderedUuid();
            }
        });
    }
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
