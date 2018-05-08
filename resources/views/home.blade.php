@extends('layouts.app')

@section('content')
    <div class="card">
        <h4 class="card-header">Broadcast Laravel Example</h4>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('task.new') }}">
                        @csrf
                        <button class="btn btn-primary new_task">Новая задача</button>
                    </form>
                </div>
            </div>

            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>№</th>
                    <th class="d-none">id</th>
                    <th>Дата</th>
                    <th>Задача</th>
                    <th>Статус</th>
                    <th>Процент выполнения</th>
                    <th style="width: 100px"></th>
                </tr>
                </thead>
                <tbody class="tasks-body">
                @foreach($tasks as $task)
                    <tr>
                        <td>
                            {{ $loop->iteration + (($tasks->currentPage() - 1) * $tasks->perPage()) }}
                        </td>
                        <td class="id d-none" id="{{ $task->id }}">
                            {{ $task->id }}
                        </td>
                        <td>
                            {{ $task->created_at->format('d.m.Y H:m:s') }}
                        </td>
                        <td>
                            {{ $task->name }}
                        </td>
                        <td class="status">
                            {!! $task->status_with_badge !!}
                        </td>
                        <td class="percent">
                            <div class="progress" style="height: 20px;">
                                <div class="{{ $task->status_progressbar_class }}"
                                     role="progressbar"
                                     style="width: {{ $task->percent }}%"
                                     aria-valuenow="{{ $task->percent }}" aria-valuemin="0"
                                     aria-valuemax="100">{{ $task->percent }}%
                                </div>
                            </div>
                        </td>
                        <td style="width: 100px" class="buttons">
                            <button type="button"
                                    task-id="{{ $task->id }}"
                                    class="btn btn-outline-danger btn-sm cancel {{in_array($task->status, [\App\Task::IN_QUEUE, \App\Task::EXECUTE]) ? '' : 'd-none'}}">
                                Отменить
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $tasks->links() }}
        </div>
    </div>
@endsection