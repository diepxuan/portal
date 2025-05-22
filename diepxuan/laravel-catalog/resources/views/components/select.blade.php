@props(['name' => null, 'options' => [], 'selected' => null, 'placeholder' => null, 'id' => null, 'class' => ''])

<select {{ $name ?? "name='$name'" }} {{ $id ?? "id='$id'" }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
]) !!}>
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" @selected($value == $selected)>
            {{ $label }}
        </option>
    @endforeach
</select>
