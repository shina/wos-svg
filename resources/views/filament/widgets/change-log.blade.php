<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-s-rocket-launch">
        <x-slot:heading>
            Changes and new features
        </x-slot:heading>

        @foreach($changes as $index => $change)
            <div class="@if($index !== 0) mt-5 @endif">
                <div class="flex">
                    <span class="text-xs text-gray-500">{{ $change->date }}</span>
                    @if($change->isNew) <x-filament::badge color="danger" class="flex-none ml-1 w-12 h-4">NEW</x-filament::badge> @endif
                </div>
                <span class="ml-1">{{ $change->title }}</span>
                @if($change->description)
                    <div class="italic text-sm">{{ $change->description }}</div>
                @endif
            </div>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
