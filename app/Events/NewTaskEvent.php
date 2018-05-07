<?php

namespace App\Events;

use App\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewTaskEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    /**
     * Create a new event instance.
     *
     * @param $task Task
     */
    public function __construct($task)
    {
        $this->task = $task;
    }
}
