<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        'log_id',
        'route_original_id',
        'hosts',
        'methods',
        'paths',
        'preserve_host',
        'protocols',
        'regex_priority',
        'service_original_id',
        'strip_path'
    ];

    public function log()
    {
        return $this->belongsTo(Log::class);
    }
}
