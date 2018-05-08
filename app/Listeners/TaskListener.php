<?php

namespace App\Listeners;

use App\Events\NewTaskEvent;
use App\Events\TaskCancelBroadcast;
use App\Events\TaskIterateBroadcast;
use App\Task;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskListener implements ShouldQueue
{
    public $queue = 'listeners';

    /**
     * Handle the event.
     *
     * @param  NewTaskEvent $event
     * @return void
     */
    public function handle(NewTaskEvent $event)
    {
        $this->startExecute($event->task);

        for ($i = 1; $i <= 10; $i++) {
            if ($this->isCancel($event->task)) {
                break;
            }

            $i === 10 ? $this->doComplete($event->task) : $this->addPercent($event->task);
            broadcast(new TaskIterateBroadcast($event->task));
        }
    }

    protected function startExecute(Task $task)
    {
        if ($task->status === Task::IN_QUEUE) {
            $task->status = Task::EXECUTE;
            $task->save();
        }
    }

    protected function addPercent(Task $task)
    {
        if ($task->status === Task::EXECUTE) {
            sleep(rand(1, 5));
            $task->percent = $task->percent + rand(1, round((100 - $task->percent) / 2));
            $task->save();
        }
    }

    protected function doComplete(Task $task)
    {
        if ($task->status === Task::EXECUTE) {
            $task->percent = 100;
            $task->status = Task::COMPLETE;
            $task->save();
        }
    }

    protected function isCancel(Task $task)
    {
        $nowTask = Task::find($task->id);

        if ($isCancel = $nowTask->status === Task::CANCEL) {
            broadcast(new TaskCancelBroadcast($nowTask));
        }

        return $isCancel;
    }
}
