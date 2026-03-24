<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all();
        return view('note.index', compact('notes'));
    }

    public function create()
    {
        return view('note.create');
    }

    public function store(StoreNoteRequest $request)
    {
        Note::create($request->only('title', 'content'));

        return redirect()->route('note.index')->with('success', 'Note created successfully');
    }

    public function edit(Note $note)
    {
        return view('note.edit', compact('note'));
    }

    public function update(StoreNoteRequest $request, Note $note)
    {
        $note->update($request->only('title', 'content'));

        return redirect()->route('note.index')->with('success', 'Note updated successfully');;
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('note.index')->with('success', 'Note deleted successfully');;
    }
}