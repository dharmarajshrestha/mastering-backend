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
        'description',
        'status',
        'user_id',
        'type',
        'due_at'
    ];

    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
            'approved_at' => 'datetime'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function complete()
    {
        if (!$this->name) {
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

    public function rename(string $name)
    {
        if ($this->status === 'completed') {
            throw new \Exception(
                "Task {$this->id} already completed. Cannot rename"
            );
        }

        $this->name = $name;
    }

    public function isApproved(): bool
    {
        return !!$this->approved_at;
    }

    public function isDueDatePassed(): bool
    {
        return !!($this->due_at && now() > $this->due_at);
    }
}
