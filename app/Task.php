<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const IN_QUEUE = 'in queue';
    const EXECUTE  = 'execute';
    const COMPLETE = 'complete';
    const CANCEL   = 'cancel';
    const ERROR    = 'error';

    protected $fillable = ['name', 'percent', 'status', 'status_with_badge'];
    protected $appends  = ['status_with_badge'];

    public function getStatusWithBadgeAttribute()
    {
        switch ($this->status) {
            case Task::IN_QUEUE:
                return sprintf('<span class="badge badge-info">%s</span>', $this->status);
            case Task::EXECUTE:
                return sprintf('<span class="badge badge-primary">%s</span>', $this->status);
            case Task::COMPLETE:
                return sprintf('<span class="badge badge-success">%s</span>', $this->status);
            case Task::CANCEL:
                return sprintf('<span class="badge badge-dark">%s</span>', $this->status);
            case Task::ERROR:
                return sprintf('<span class="badge badge-danger">%s</span>', $this->status);
            default:
                return sprintf('<span class="badge badge-secondary">%s</span>', $this->status);
        }
    }
}
