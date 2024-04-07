<script src="{{ url('/assets/notices/hammer.min.js') }}"></script>
<script src="{{ url('/assets/notices/clipboard.min.js') }}"></script>

<script>
    function copyText(elementId) {
        const button = document.createElement('button');

        clipboard = new ClipboardJS(button, {
            text: () => document.getElementById(elementId).innerText
        });
        clipboard.on('success', function() {
            alert('Copied!');
        });
        clipboard.on('error', function() {
            alert('Cannot copy text on this device :(');
        });

        button.click();
        clipboard.destroy();
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
