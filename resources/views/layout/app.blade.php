<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notes App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#6366f1"
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    @auth
        <nav class="bg-white border-b">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-xl font-bold text-primary">
                        Notes App
                    </h1>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-700">
                            {{ auth()->user()->name }} ({{ auth()->user()->role }})
                        </span>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('note.create') }}"
                                class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                                New Task
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="px-3 py-2 rounded-lg border border-gray-300 text-sm hover:bg-gray-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <main class="max-w-6xl mx-auto px-4 py-8">

        @if (session('success'))
            <div class="max-w-6xl mx-auto py-4">
                <div
                    class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center">
                    <span>
                        {{ session('success') }}
                    </span>
                    <button onclick="this.parentElement.remove()" class="text-green-600 font-bold">
                        ✕
                    </button>
                </div>
            </div>
        @endif
        @yield('content')
    </main>
</body>

</html>