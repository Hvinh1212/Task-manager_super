
@extends('layout.app')

@section('content')
    <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between sm:items-center">
        <h2 class="text-2xl font-bold">
            {{ auth()->user()->role === 'admin' ? 'All Tasks' : 'My Tasks' }}
        </h2>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('note.index', ['status' => '']) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ empty($activeStatus) ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                All statuses
            </a>
            <a href="{{ route('note.index', ['status' => 'chua_lam']) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ ($activeStatus ?? '') === 'chua_lam' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                Not Started
            </a>
            <a href="{{ route('note.index', ['status' => 'dang_lam']) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ ($activeStatus ?? '') === 'dang_lam' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                In Progress
            </a>
            <a href="{{ route('note.index', ['status' => 'hoan_thanh']) }}"
                class="px-3 py-1 rounded-lg border text-sm {{ ($activeStatus ?? '') === 'hoan_thanh' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                Completed
            </a>
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
