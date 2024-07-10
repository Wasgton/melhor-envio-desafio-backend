<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $fillable = [
        'log_id',
        'status',
        'ize',
        'headers'
    ];
    
    public function log()
    {
        return $this->belongsTo(Log::class);
    }
}
