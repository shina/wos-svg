<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script>
    function copyText(elementId) {
        let text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert('Text copied to clipboard');
        }).catch(err => {
            console.error('Error in copying text: ', err);
        });
    }

    function onLongPress(elementId, callback) {
        let button = document.getElementById(elementId);
        let hammer = new Hammer(button);

        hammer.get('press').set({ time: 1000 });
        hammer.on('press', callback);
    }
</script>
<style>
    .title {
        text-transform: uppercase;
    }
    details {
        margin-top: 10px;
    }
</style>

<x-layout>
    @foreach($notices as $notice)
        <?php $slug = \Illuminate\Support\Str::slug($notice->title); ?>
        <details id="{{ $slug }}">
            <summary class="title">{{ $notice->title }}</summary>
            <p>
                {!! nl2br($notice->content) !!}
            </p>
        </details>

        <script>
            onLongPress('{{ $slug }}', function() {
                copyText('{{ $slug }}');
            });
        </script>
    @endforeach
</x-layout>
