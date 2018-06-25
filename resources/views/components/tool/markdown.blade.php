@push('stylesheets')
<link href="{{ asset('bower_components/simplemde/dist/simplemde.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('bower_components/simplemde/dist/simplemde.min.js') }}"></script>
<script>
    var simplemde = new SimpleMDE({
        element: $(".simplemde")[0],
        spellChecker: false
    });
</script>
@endpush
