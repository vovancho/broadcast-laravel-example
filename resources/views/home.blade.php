@extends('layouts.app')

@section('content')
    <div class="card">
        <h4 class="card-header">Broadcast Laravel Example</h4>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary new_task" href="{{ route('new.task') }}">Новая задача</a>
                </div>
            </div>

            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>№</th>
                    <th class="d-none">id</th>
                    <th>Задача</th>
                    <th>Статус</th>
                    <th>Процент выполнения</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="tasks-body">
                @foreach($tasks as $task)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td class="id d-none" id="{{ $task->id }}">
                            {{ $task->id }}
                        </td>
                        <td>
                            {{ $task->name }}
                        </td>
                        <td class="status">
                            {!! $task->status_with_badge !!}
                        </td>
                        <td class="percent">
                            {{ $task->percent }}
                        </td>
                        <td class="buttons">
                            @if(in_array($task->status, [\App\Task::IN_QUEUE, \App\Task::EXECUTE]))
                                <button type="button" class="btn btn-outline-danger btn-sm">Отменить</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $tasks->links() }}
        </div>
    </div>

@endsection