<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    private const ALLOWED_STATUSES = ['chua_lam', 'dang_lam', 'hoan_thanh'];

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($request->has('status')) {
            $status = $request->string('status')->toString();

            if ($status === '') {
                $request->session()->forget('task_filter_status');
            } elseif (in_array($status, self::ALLOWED_STATUSES, true)) {
                $request->session()->put('task_filter_status', $status);
            }
        }

        $activeStatus = $request->session()->get('task_filter_status');

        $notes = Note::query()
            ->with('assignedUser')
            ->when($user->role === 'user', fn ($query) => $query->where('assigned_user_id', $user->id))
            ->when(in_array($activeStatus, self::ALLOWED_STATUSES, true), fn ($query) => $query->where('status', $activeStatus))
            ->latest()
            ->get();

        return view('note.index', compact('notes', 'activeStatus'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('note.create', compact('users'));
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'assigned_user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:chua_lam,dang_lam,hoan_thanh'],
        ]);

        Note::create($data);

        return redirect()->route('note.index')->with('success', 'Task created successfully.');
    }

    public function edit(Note $note)
    {
        /** @var User $user */
        $user = Auth::user();

        abort_if($user->role === 'user' && $note->assigned_user_id !== $user->id, 403);

        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('note.edit', compact('note', 'users'));
    }

    public function update(Request $request, Note $note)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role === 'admin') {
            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'content' => ['nullable', 'string'],
                'assigned_user_id' => ['required', 'exists:users,id'],
                'status' => ['required', 'in:chua_lam,dang_lam,hoan_thanh'],
            ]);

            $note->update($data);

            return redirect()->route('note.index')->with('success', 'Task updated successfully.');
        }

        abort_if($note->assigned_user_id !== $user->id, 403);

        $data = $request->validate([
            'status' => ['required', 'in:chua_lam,dang_lam,hoan_thanh'],
        ]);

        $note->update($data);

        return redirect()->route('note.index')->with('success', 'Task status updated successfully.');
    }

    public function destroy(Note $note)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403);

        $note->delete();

        return redirect()->route('note.index')->with('success', 'Task deleted successfully.');
    }
}
