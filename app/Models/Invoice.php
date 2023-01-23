<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $dates = [
        'sent_at',
        'due_at',
    ];

    public function lines()
    {
        return $this->hasMany(Line::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function total()
    {
        $total = 0.0;

        foreach ($this->lines as $line) {
            $total += $line->total();
        } 

        return $total;
    }
}
