
@extends('layout.app')

@section('content')
    <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between sm:items-center">
        <h2 class="text-2xl font-bold">
            {{ auth()->user()->role === 'admin' ? 'All Tasks' : 'My Tasks' }}
        </h2>
        <form method="GET" action="{{ route('note.index') }}" class="flex items-center gap-2">
            <select name="status" class="border rounded-lg px-3 py-2 text-sm">
                <option value="" @selected(empty($activeStatus))>All statuses</option>
                <option value="chua_lam" @selected(($activeStatus ?? '') === 'chua_lam')>Not Started</option>
                <option value="dang_lam" @selected(($activeStatus ?? '') === 'dang_lam')>In Progress</option>
                <option value="hoan_thanh" @selected(($activeStatus ?? '') === 'hoan_thanh')>Completed</option>
            </select>
            <button class="bg-primary text-white px-3 py-2 rounded-lg text-sm">Apply</button>
        </form>
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
                        {{ str($note->status)->replace('_', ' ')->title() }}
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
    @endif
@endsection
