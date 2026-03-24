
@extends('layout.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6">
        Your Notes
    </h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($notes as $note)
            <div class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-lg mb-2">
                    {{ $note->title }}
                </h3>
                <p class="text-gray-600 text-sm mb-4">
                    {{ $note->content }}
                </p>
                <div class="flex justify-between items-center">
                    <a href="{{ route('note.edit', $note) }}" class="text-primary text-sm font-medium hover:underline">
                        Edit
                    </a> 
                    <form action="{{ route('note.delete', $note) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 text-sm hover:underline">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
