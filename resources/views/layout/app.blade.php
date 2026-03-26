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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(function() {
            $.validator.addMethod("strictEmail", function(value, element) {
                if (this.optional(element)) return true;
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            }, "Please enter a valid email.");

            $.validator.addMethod("statusInList", function(value, element) {
                const allowed = ["chua_lam", "dang_lam", "hoan_thanh"];
                return allowed.includes(value);
            }, "Invalid status.");

            $.validator.addMethod("contentSafe", function(value, element) {
                if (this.optional(element)) return true;
                return /^[\p{L}\p{N}\s\r\n\.\,\-\_\(\)\!\?\:\;'"@#\$%&\*\+\=\/\\]*$/u.test(value);
            }, "Content contains invalid characters.");

            const commonErrorPlacement = function(error, element) {
                error.addClass("text-red-500 text-sm mt-1");
                error.insertAfter(element);
            };

            const $loginForm = $("#login-form");
            if ($loginForm.length) {
                $loginForm.validate({
                    errorPlacement: commonErrorPlacement,
                    rules: {
                        email: {
                            required: true,
                            email: true,
                            strictEmail: true,
                            maxlength: 255
                        },
                        password: {
                            required: true,
                            minlength: 1
                        }
                    },
                    messages: {
                        email: {
                            required: "Email is required.",
                            maxlength: "Email must be at most 255 characters."
                        },
                        password: {
                            required: "Password is required."
                        }
                    }
                });
            }

            const $createForm = $("#note-create-form");
            if ($createForm.length) {
                $createForm.validate({
                    errorPlacement: commonErrorPlacement,
                    rules: {
                        title: {
                            required: true,
                            maxlength: 255
                        },
                        content: {
                            maxlength: 10000,
                            contentSafe: true
                        },
                        assigned_user_id: {
                            required: true,
                            digits: true
                        },
                        status: {
                            required: true,
                            statusInList: true
                        }
                    },
                    messages: {
                        title: {
                            required: "Title is required.",
                            maxlength: "Title must be at most 255 characters."
                        },
                        assigned_user_id: {
                            required: "Please select a user.",
                            digits: "Invalid user id."
                        },
                        status: {
                            required: "Please select a status."
                        }
                    }
                });
            }

            const $editForm = $("#note-edit-form");
            if ($editForm.length) {
                const rules = {
                    status: {
                        required: true,
                        statusInList: true
                    }
                };

                if ($editForm.find('input[name="title"]').length) {
                    rules.title = {
                        required: true,
                        maxlength: 255
                    };
                }
                if ($editForm.find('textarea[name="content"]').length) {
                    rules.content = {
                        maxlength: 10000,
                        contentSafe: true
                    };
                }
                if ($editForm.find('select[name="assigned_user_id"]').length) {
                    rules.assigned_user_id = {
                        required: true,
                        digits: true
                    };
                }

                $editForm.validate({
                    errorPlacement: commonErrorPlacement,
                    rules: rules,
                    messages: {
                        title: {
                            required: "Title is required.",
                            maxlength: "Title must be at most 255 characters."
                        },
                        assigned_user_id: {
                            required: "Please select a user.",
                            digits: "Invalid user id."
                        },
                        status: {
                            required: "Please select a status."
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>