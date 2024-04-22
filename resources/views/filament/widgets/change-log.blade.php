<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-s-rocket-launch">
        <x-slot:heading>
            Changes and new features
        </x-slot:heading>

        @foreach($changes as $index => $change)
            <div class="@if($index !== 0) mt-5 @endif">
                <span class="text-xs text-gray-500">{{ $change->date }}</span>
                <div class="flex">
                    @if($change->isNew) <x-filament::badge color="danger" class="flex-none w-12 h-7">NEW</x-filament::badge> @endif
                    <span class="ml-1 flex-grow">{{ $change->title }}</span>
                </div>
                @if($change->description)
                    <div class="italic text-sm">{{ $change->description }}</div>
                @endif
            </div>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
