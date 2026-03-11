@props(['field' => null, 'messages' => null])

@if($field)
    @error($field)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
@elseif($messages)
    @foreach((array) $messages as $message)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @endforeach
@endif