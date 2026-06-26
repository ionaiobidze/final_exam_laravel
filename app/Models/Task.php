<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'status', 'deadline', 'attachment'];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function scopeDone($q)
    {
        return $q->where('status', 'done');
    }

    public function scopeOverdue($q)
    {
        return $q->where('status', 'pending')->whereDate('deadline', '<', now());
    }
}
