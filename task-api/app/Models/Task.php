<?php

namespace App\Models;

use App\Enums\TaskState;
use Database\Factories\TaskFactory;
use Exception;
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
        'due_at',
        'approved_at'
    ];

    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
            'approved_at' => 'datetime',
            'status' => TaskState::class
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function complete()
    {
        if ($this->isLocked()) {
            throw new Exception('Task must be unlocked to be completed');
        }

        if ($this->isCompleted()) {
            throw new \Exception(
                "Task {$this->id} already completed"
            );
        }

        $this->status = TaskState::COMPLETED;
    }

    public function lock()
    {
        if ($this->isCompleted()) {
            throw new \Exception('Completed task cannot be locked');
        }

        if ($this->isLocked()) {
            throw new \Exception('Task already locked');
        }

        $this->status = TaskState::LOCKED;
    }

    public function unlock()
    {
        if (!$this->isLocked()) {
            throw new \Exception('Task already unlocked');
        }

        $this->status = TaskState::PENDING;
    }

    public function rename(string $name)
    {

        if ($this->isCompleted()) {
            throw new \Exception(
                "Task {$this->id} already completed. Cannot rename"
            );
        }

        $this->name = $name;
    }

    public function isCompleted(): bool
    {
        return $this->status === TaskState::COMPLETED;
    }

    public function isLocked(): bool
    {
        return $this->status === TaskState::LOCKED;
    }
}
