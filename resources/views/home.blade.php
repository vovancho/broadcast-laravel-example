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

            <tasks-component :tasks="{{json_encode($tasks)}}"></tasks-component>
            {{ $tasks->links() }}
        </div>
    </div>
@endsection