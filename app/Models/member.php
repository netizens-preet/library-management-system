<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Member extends Model
{
    // 1. Always define your fillable fields
    protected $fillable = ['name', 'email', 'phone', 'membership_date', 'is_active'];

    // 2. Cast attributes to the correct types
    protected $casts = [
        'is_active' => 'boolean',
        'membership_date' => 'date',
    ];

    // 3. Set default values
    protected $attributes = [
        'is_active' => true,
    ];

    public function borrowRecords(): HasMany
    {
        return $this->hasMany(BorrowRecord::class);
    }

    public function borrowedBooks(): HasManyThrough
    {
        return $this->hasManyThrough(Book::class, BorrowRecord::class, 'member_id', 'id', 'id', 'book_id');
    }

    public function deactivate(): void
    {
        $this->is_active = false;
        $this->save();
    }
}