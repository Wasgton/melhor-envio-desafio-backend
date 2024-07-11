<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latency extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'id',
        'log_id',
        'proxy',
        'gateway',
        'request'
    ];
    public function log()
    {
        return $this->belongsTo(Log::class);
    }
}
