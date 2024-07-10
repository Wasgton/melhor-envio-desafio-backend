<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_original_id',
        'log_id',
        'name',
        'host',
        'port',
        'protocol',
        'connect_timeout',
        'read_timeout',
        'write_timeout',
        'retries'
    ];
    
    public function log()
    {
        return $this->belongsTo(Log::class);
    }
}
