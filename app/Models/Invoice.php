<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'invoice_number',
        'date',
        'status', // pending, accepted, rejected
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
