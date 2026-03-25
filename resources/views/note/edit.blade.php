@extends('layout.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-6">
        {{ auth()->user()->role === 'admin' ? 'Edit Task' : 'Update Task Status' }}
    </h2>
    <form action="{{route('note.update', $note)}}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        @if (auth()->user()->role === 'admin')
        <div>
            <label class="block text-sm font-medium mb-1">
                Title
            </label>
            <input type="text" name="title" value="{{ old('title', $note->title)}}"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            @error('title')
            <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">
                Content
            </label>
            <textarea name="content" rows="5"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">{{ old('content', $note->content) }}</textarea>
            @error('content')
            <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">
                Assign To User
            </label>
            <select name="assigned_user_id"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('assigned_user_id', $note->assigned_user_id) == $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                </option>
                @endforeach
            </select>
            @error('assigned_user_id')
            <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        @else
        <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
            <div class="font-semibold">{{ $note->title }}</div>
            <div class="text-sm text-gray-600 mt-1">{{ $note->content }}</div>
        </div>
        @endif
        <div>
            <label class="block text-sm font-medium mb-1">
                Status
            </label>
            <select name="status"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @foreach (\App\Models\Note::allowedStatuses() as $status)
                    <option value="{{ $status }}" @selected(old('status', $note->status) === $status)>
                        {{ \App\Models\Note::statusLabel($status) }}
                    </option>
                @endforeach
            </select>
            @error('status')
            <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <button class="bg-primary text-white px-5 py-2 rounded-lg hover:opacity-90 transition">
            Update Task
        </button>
    </form>
</div>
@endsection