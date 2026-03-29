<?php

namespace App\Repositories\Contracts;

use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NoteRepositoryInterface
{
    public function paginateForViewer(User $viewer, ?string $status, ?string $search, int $perPage): LengthAwarePaginator;

    public function create(array $data): Note;

    public function update(Note $note, array $data): Note;

    public function delete(Note $note): void;
}

