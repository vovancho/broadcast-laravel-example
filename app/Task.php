<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @property int $id
 * @property string $name
 * @property int $percent
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $status_with_badge
 * @property string $status_progressbar_class
 */
class Task extends Model
{
    const IN_QUEUE = 'in queue';
    const EXECUTE  = 'execute';
    const COMPLETE = 'complete';
    const CANCEL   = 'cancel';
    const ERROR    = 'error';

    protected $fillable = ['name', 'percent', 'status', 'status_with_badge', 'status_progressbar_class'];
    protected $appends  = ['status_with_badge', 'status_progressbar_class'];

    public function getStatusWithBadgeAttribute()
    {
        switch ($this->status) {
            case Task::IN_QUEUE:
                return sprintf('<span class="badge badge-info">%s</span>', $this->status);
            case Task::EXECUTE:
                return sprintf('<span class="badge badge-success">%s</span>', $this->status);
            case Task::COMPLETE:
                return sprintf('<span class="badge badge-primary">%s</span>', $this->status);
            case Task::CANCEL:
                return sprintf('<span class="badge badge-dark">%s</span>', $this->status);
            case Task::ERROR:
                return sprintf('<span class="badge badge-danger">%s</span>', $this->status);
            default:
                return sprintf('<span class="badge badge-secondary">%s</span>', $this->status);
        }
    }

    public function getStatusProgressbarClassAttribute()
    {
        if ($this->status === self::CANCEL) {
            return "progress-bar bg-dark";
        } elseif ($this->percent < 100) {
            return "progress-bar progress-bar-striped progress-bar-animated bg-success";
        }

        return "progress-bar";
    }
}
