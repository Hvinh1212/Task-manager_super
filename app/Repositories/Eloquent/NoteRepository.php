<?php

namespace App\Repositories\Eloquent;

use App\Models\Note;
use App\Models\User;
use App\Repositories\Contracts\NoteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NoteRepository implements NoteRepositoryInterface
{
    public function paginateForViewer(User $viewer, ?string $status, int $perPage): LengthAwarePaginator
    {
        $query = Note::query()
            ->with('assignedUser')
            ->latest();

        if ($viewer->role === 'user') {
            $query->where('assigned_user_id', $viewer->id);
        }

        if ($status !== null && $status !== '' && in_array($status, Note::allowedStatuses(), true)) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): Note
    {
        return Note::create($data);
    }

    public function update(Note $note, array $data): Note
    {
        $note->update($data);

        return $note->fresh();
    }

    public function delete(Note $note): void
    {
        $note->delete();
    }
}

