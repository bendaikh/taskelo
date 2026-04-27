@extends('client.layouts.app')

@section('title', 'Projects - Client Portal')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Your Projects</h2>
    </div>

    @if($projects->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
            </svg>
            <p class="text-lg text-gray-500">No projects yet</p>
            <p class="text-sm text-gray-400 mt-2">Your projects will appear here once they are created</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($projects as $project)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $project->title }}</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($project->status === 'completed') bg-green-100 text-green-800
                                        @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                    </span>
                                </div>
                                
                                @if($project->description)
                                    <p class="text-gray-600 mb-4">{{ $project->description }}</p>
                                @endif

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Start Date</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">End Date</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $project->end_date ? $project->end_date->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Tasks</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $project->tasks->count() }} total</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Progress</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $project->progress }}%</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex items-center justify-between text-sm mb-2">
                                        <span class="text-gray-600">Task Completion</span>
                                        <span class="font-medium text-gray-900">{{ $project->tasks->where('status', 'done')->count() }} / {{ $project->tasks->count() }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-center justify-between text-sm mb-2">
                                        <span class="text-gray-600">Payment Progress</span>
                                        <span class="font-medium text-gray-900">{{ $currency }}{{ number_format($project->amount_paid, 2) }} / {{ $currency }}{{ number_format($project->budget ?? $project->tasks->sum('price'), 2) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $project->payment_progress }}%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('client.project', $project->id) }}" class="ml-6 inline-flex items-center px-4 py-2 border border-blue-600 rounded-lg text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 transition">
                                View Details
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ml-2">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $projects->links() }}
        </div>
    @endif
</div>
@endsection
