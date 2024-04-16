<x-app-layout>
    <div class="note-container">
        <a class="new-note-btn" href="{{ route('notes.create') }}">
            <h4>
                new Note
            </h4>
        </a>
        <div class="notes">
            @foreach ($notes as $note )
            
            
            <div class="note">
                <div class="note-body">
                    {{ Str::words( $note->note,30) }}
                </div>
                <div class="note-buttons">
                    <a  class="note-edit-button" href=" {{ route('notes.edit',$note) }} "> edit</a>
                    <a  class="note-view-button" href=" {{ route('notes.show',$note) }} "> view</a>
                <form action=" {{ route("notes.destroy",$note) }} " method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="note-delete-button">Delete</button>
                </form>
                </div>
            </div>
                
            
            @endforeach
        </div>
       
    </div>
</x-app-layout>