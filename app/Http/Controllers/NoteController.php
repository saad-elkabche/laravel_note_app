<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $notes = Note::query()->where('user_id',request()->user()->id)->orderBy("created_at","desc")->paginate();
        return view('note.index',['notes'=> $notes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('note.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validData=$request->validate(
                [
                    'note'=>['required','string']
                ]
            );
        $validData['user_id']=request()->user()->id;
        $note = Note::create($validData);
        return to_route('notes.show',$note)->with('msg','note is created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if($note->user_id!==request()->user()->id){
            return abort(403);
        }
        return view('note.show',compact('note') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if($note->user_id!==request()->user()->id){
            return abort(403);
        }
        return view('note.edit',compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if($note->user_id!==request()->user()->id){
            return abort(403);
        }
        $validData=$request->validate(['note'=>['required','string']]);
        $note->update($validData);
        return to_route('notes.show',$note)->with('msg','note is updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if($note->user_id!==request()->user()->id){
            return abort(403);
        }
        $note->delete();
        return to_route('notes.index')->with('msg','success deletion');
    }
}
