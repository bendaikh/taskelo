@extends('layouts.app')

@section('title', 'Daily Tasks')
@section('page-title', 'Daily Tasks')

@section('content')
<div class="mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Daily Tasks</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Manage and track your daily tasks</p>
    </div>
</div>

<!-- Daily Tasks Container -->
<div id="daily-tasks-container" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <daily-tasks-list :initial-tasks='@json($tasks)'></daily-tasks-list>
</div>
@endsection
