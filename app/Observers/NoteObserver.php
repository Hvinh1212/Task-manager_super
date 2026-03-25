<?php

namespace App\Observers;

use App\Models\Note;

class NoteObserver
{
    public function creating(Note $note): void
    {
        if (empty($note->status)) {
            $note->status = Note::STATUS_CHUA_LAM;
        }
    }

    public function updating(Note $note): void
    {
        if (empty($note->status)) {
            $note->status = Note::STATUS_CHUA_LAM;
            return;
        }

        if (! in_array($note->status, Note::allowedStatuses(), true)) {
            // Prevent invalid status from being persisted.
            $note->status = Note::STATUS_CHUA_LAM;
        }
    }
}

