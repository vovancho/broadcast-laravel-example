<?php

namespace App\Listeners;

use App\Events\NewTaskEvent;
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
            $i === 10 ? $this->doComplete($event->task) : $this->addPercent($event->task);
            broadcast(new TaskIterateBroadcast($event->task));
        }
    }

    protected function startExecute(Task $task)
    {
        $task['status'] = Task::EXECUTE;
        $task->save();
    }

    protected function addPercent(Task $task)
    {
        $task['percent'] = $task['percent'] + rand(1, round((100 - $task['percent']) / 2));
        $task->save();
        sleep(rand(1, 5));
    }

    protected function doComplete(Task $task)
    {
        $task['percent'] = 100;
        $task['status'] = Task::COMPLETE;
        $task->save();
    }
}
