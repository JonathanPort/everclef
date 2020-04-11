<div class="lyrics-editor panel">

    <div data-quill-editor
         placeholder="Paste your lyrics or use the search above to automatically fill"
         autofocus>@isset ($cover){!! $cover->lyrics !!}@endisset</div>

    <input type="hidden" name="lyrics" data-quill-hidden-input>

</div>