<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scan extends Model
{
    use HasFactory;

    protected $table = "ticket_user";

    public function isCheckedIn(): bool
    {
        return Str::of($this->action)->lower()->exactly('checked in');
    }
}
