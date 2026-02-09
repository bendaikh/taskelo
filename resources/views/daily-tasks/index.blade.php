@extends('layouts.app')

@section('title', __('app.daily_tasks'))
@section('page-title', __('app.daily_tasks'))

@section('content')
<div class="mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ __('app.daily_tasks') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.tasks_to_do_desc') }}</p>
    </div>
</div>

<!-- Daily Tasks Container -->
<div id="daily-tasks-container" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <daily-tasks-list :initial-tasks='@json($tasks)'></daily-tasks-list>
</div>
@endsection
