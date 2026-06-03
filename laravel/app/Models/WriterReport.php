<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WriterReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reporter_id',
        'reported_id',
        'reason',
        'details',
        'status',
    ];

    /**
     * Relationship: Get the user who reported the writer.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Relationship: Get the profile flagged by this report.
     */
    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }
}