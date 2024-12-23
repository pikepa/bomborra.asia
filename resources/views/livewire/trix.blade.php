<div wire:ignore>
    <input id="{{ $trixId }}" type="hidden" name="content" value="{{ $value }}">
    <trix-editor input="{{ $trixId }}"></trix-editor>
</div>

<script>
    var trixEditor = document.getElementById("{{ $trixId }}")

    addEventListener("trix-blur", function(event) {
        @this.set('value', trixEditor.getAttribute('value'))
    })
</script>
