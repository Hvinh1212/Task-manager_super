@extends('layout.app')

@section('content')
@php
$qParam = $search ?? request('q');
$allParams = ['status' => ''];
if ($qParam) { $allParams['q'] = $qParam; }
$todoParams = ['status' => 'chua_lam'];
if ($qParam) { $todoParams['q'] = $qParam; }

$doingParams = ['status' => 'dang_lam'];
if ($qParam) { $doingParams['q'] = $qParam; }

$doneParams = ['status' => 'hoan_thanh'];
if ($qParam) { $doneParams['q'] = $qParam; }
@endphp
<div class="flex flex-col gap-4 mb-6">
    <form method="GET" action="{{ route('note.index') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
        @if ($activeStatus)
        <input type="hidden" name="status" value="{{ $activeStatus }}">
        @endif
        <label class="sr-only" for="search-note-q">Search tasks</label>
        <input id="search-note-q" type="search" name="q" value="{{ old('q', $qParam) }}"
            placeholder="Search by title or content..."
            class="w-full sm:max-w-md border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        <div class="flex gap-2">
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-sm hover:opacity-90">
                Search
            </button>
            @if ($qParam)
            <a href="{{ route('note.index', $activeStatus ? ['status' => $activeStatus] : []) }}"
                class="px-4 py-2 rounded-lg border border-gray-300 text-sm hover:bg-gray-50">
                Clear
            </a>
            @endif
        </div>
    </form>
    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
        <h2 class="text-2xl font-bold">
            {{ auth()->user()->role === 'admin' ? 'All Tasks' : 'My Tasks' }}
        </h2>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('note.index', $allParams) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ empty($activeStatus) ? 'bg-primary text-white' : 'bg-white' }}">
                All statuses
            </a>

            <a href="{{ route('note.index', $todoParams) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ $activeStatus === 'chua_lam' ? 'bg-primary text-white' : 'bg-white' }}">
                Not Started
            </a>

            <a href="{{ route('note.index', $doingParams) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ $activeStatus === 'dang_lam' ? 'bg-primary text-white' : 'bg-white' }}">
                In Progress
            </a>

            <a href="{{ route('note.index', $doneParams) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ $activeStatus === 'hoan_thanh' ? 'bg-primary text-white' : 'bg-white' }}">
                Completed
            </a>
        </div>
    </div>
</div>
@if ($notes->isEmpty())
<div class="bg-white rounded-xl p-5 shadow text-gray-600">No tasks found.</div>
@else
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($notes as $note)
    <div class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition">
        <h3 class="font-semibold text-lg mb-2">
            {{ $note->title }}
        </h3>
        <p class="text-gray-600 text-sm mb-3">
            {{ $note->content }}
        </p>
        <div class="text-sm text-gray-700 mb-1">
            <span class="font-medium">Assigned to:</span>
            {{ $note->assignedUser?->name ?? 'Unassigned' }}
        </div>
        <div class="text-sm text-gray-700 mb-4">
            <span class="font-medium">Status:</span>
            {{ \App\Models\Note::statusLabel($note->status) }}
        </div>
        <div class="flex justify-between items-center">
            <a href="{{ route('note.edit', $note) }}" class="text-primary text-sm font-medium hover:underline">
                {{ auth()->user()->role === 'admin' ? 'Edit' : 'Update status' }}
            </a>
            @if (auth()->user()->role === 'admin')
            <form action="{{ route('note.delete', $note) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="text-red-500 text-sm hover:underline">
                    Delete
                </button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
<div class="mt-6">
    {{ $notes->appends(request()->query())->links() }}
</div>
@endif
@endsection