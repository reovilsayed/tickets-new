<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scan extends Model
{
    use HasFactory;

    protected $table = "ticket_user";

    public function isCheckedIn(): bool
    {
        return Str::of($this->action)->lower()->exactly('checked in');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
