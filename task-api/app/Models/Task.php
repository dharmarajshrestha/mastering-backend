<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(TaskFactory::class)]
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'description',
        'status',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function complete()
    {
        if (!$this->title) {

            throw new \Exception(
                "Task {$this->id} has no title"
            );
        }

        if ($this->status === 'completed') {

            throw new \Exception(
                "Task {$this->id} already completed"
            );
        }

        $this->status = 'completed';
    }

    public function rename(string $title)
    {
        if ($this->status === 'completed') {
            throw new \Exception(
                "Task {$this->id} already completed. Cannot rename"
            );
        }

        $this->title = $title;
    }
}
