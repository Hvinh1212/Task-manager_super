<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Repositories\Contracts\NoteRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NoteController extends Controller
{
    public function __construct(
        private readonly NoteRepositoryInterface $notesRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($request->has('status')) {
            $status = $request->string('status')->toString();

            if ($status === '') {
                $request->session()->forget('task_filter_status');
            } elseif (in_array($status, Note::allowedStatuses(), true)) {
                $request->session()->put('task_filter_status', $status);
            }
        }

        $activeStatus = $request->session()->get('task_filter_status');

        $notes = $this->notesRepository->paginateForViewer($user, $activeStatus, 9);

        return view('note.index', compact('notes', 'activeStatus'));
    }

    public function create()
    {
        $users = $this->userRepository->getAssignableUsers();

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
            'status' => ['required', Rule::in(Note::allowedStatuses())],
        ]);

        $this->notesRepository->create($data);

        return redirect()->route('note.index')->with('success', 'Task created successfully.');
    }

    public function edit(Note $note)
    {
        /** @var User $user */
        $user = Auth::user();

        abort_if($user->role === 'user' && $note->assigned_user_id !== $user->id, 403);

        $users = $this->userRepository->getAssignableUsers();

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
                'status' => ['required', Rule::in(Note::allowedStatuses())],
            ]);

            $this->notesRepository->update($note, $data);

            return redirect()->route('note.index')->with('success', 'Task updated successfully.');
        }

        abort_if($note->assigned_user_id !== $user->id, 403);

        $data = $request->validate([
            'status' => ['required', Rule::in(Note::allowedStatuses())],
        ]);

        $this->notesRepository->update($note, $data);

        return redirect()->route('note.index')->with('success', 'Task status updated successfully.');
    }

    public function destroy(Note $note)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403);

        $this->notesRepository->delete($note);

        return redirect()->route('note.index')->with('success', 'Task deleted successfully.');
    }
}
