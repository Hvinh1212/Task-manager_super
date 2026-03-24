@extends('layout.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-6">Login</h2>

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button class="bg-primary text-white px-5 py-2 rounded-lg hover:opacity-90 transition w-full">
                Sign In
            </button>
        </form>
    </div>
@endsection
