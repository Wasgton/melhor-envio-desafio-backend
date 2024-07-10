<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'method',
        'uri',
        'url',
        'size',
        'querystring',
        'headers',
        'log_id'
    ];
    
    public function log()
    {
        return $this->belongsTo(Log::class);
    }
    
    
}
