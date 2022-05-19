<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public const IS_OPEN = 1;
    public const IS_CLOSED_WO_S = 2;
    public const IS_CLOSED_W_S = 3;

    public function ticket()
    {
        $this->belongsTo(Ticket::class);
    }
}
