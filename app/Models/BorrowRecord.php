<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowRecord extends Model
{
    protected $fillable = ['member_id', 'book_id', 'borrowed_at', 'due_date', 'returned_at'];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date'    => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id')->withTrashed();
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(member::class, 'member_id');
    }
}