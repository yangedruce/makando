@props(['messages'])

@if ($messages && count($messages) > 0)
    <ul class="space-y-1 text-sm text-red-600 dark:text-red-400">
        @foreach ($messages as $message)
            @if (is_array($message))
                @foreach ($message as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            @else
                <li>{{ $message }}</li>
            @endif
        @endforeach
    </ul>
@endif