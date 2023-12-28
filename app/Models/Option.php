<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //an option belongs to a poll
    public function poll() : BelongsTo {
        return $this->belongsTo(Poll::class);
    }

    //an option has many votes
    public function votes() : HasMany {
        return $this->hasMany(Vote::class);
    }
}
