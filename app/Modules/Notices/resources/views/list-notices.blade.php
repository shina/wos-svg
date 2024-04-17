<style>
    .title {
        text-transform: uppercase;
        cursor: default;
    }
    details {
        margin-top: 10px;
    }
</style>

<x-layout>
    @foreach($notices as $notice)
        <details id="{{ $notice['slug'] }}">
            <summary class="title">{{ $notice['title'] }}</summary>
            <p>
                {!! $notice['content'] !!}
            </p>
        </details>
    @endforeach
</x-layout>
