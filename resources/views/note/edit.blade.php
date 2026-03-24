@extends('layout.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-6">
            Create Note
        </h2>
        <form action="{{route('note.update', $note)}}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">
                    Title
                </label>
                <input type="text" name="title" value="{{ $note->title}}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">
                    Content
                </label>
                <textarea name="content" rows="5"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">{{ $note->content }}</textarea>
            </div>
            <button class="bg-primary text-white px-5 py-2 rounded-lg hover:opacity-90 transition">
                Update Note
            </button>
        </form>
    </div>
@endsection