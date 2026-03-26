@extends('layout.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-6">
        Create Task
    </h2>

    <form id="note-create-form" action="{{route('note.store')}}" method="POST" class="space-y-4" novalidate>
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">
                Title
            </label>

            <input type="text" name="title"
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
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
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
                <option value="">-- Select user --</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('assigned_user_id')==$user->id)>{{ $user->name }}
                    ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('assigned_user_id')
            <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">
                Status
            </label>
            <select name="status"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @foreach (\App\Models\Note::allowedStatuses() as $status)
                    <option value="{{ $status }}" @selected(old('status') === $status)>
                        {{ \App\Models\Note::statusLabel($status) }}
                    </option>
                @endforeach
            </select>
            @error('status')
            <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <button class="bg-primary text-white px-5 py-2 rounded-lg hover:opacity-90 transition">
            Save Task
        </button>

    </form>

</div>
@endsection