@extends('layouts.guest')

@section('title', 'Registration Disabled')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 text-center">
	<h2 class="text-2xl font-semibold text-gray-900">Registration Disabled</h2>
	<p class="mt-2 text-gray-600">Please contact an administrator for access.</p>
	<a href="{{ route('login') }}" class="mt-6 inline-block text-indigo-600 hover:text-indigo-700">Return to login</a>
</div>
@endsection

