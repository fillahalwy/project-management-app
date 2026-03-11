@props(['type' => 'default', 'text'])

@php
$colors = [
    'active'      => 'bg-green-100 text-green-800',
    'on_hold'     => 'bg-yellow-100 text-yellow-800',
    'completed'   => 'bg-blue-100 text-blue-800',
    'todo'        => 'bg-gray-100 text-gray-800',
    'in_progress' => 'bg-purple-100 text-purple-800',
    'done'        => 'bg-green-100 text-green-800',
    'low'         => 'bg-gray-100 text-gray-600',
    'medium'      => 'bg-yellow-100 text-yellow-800',
    'high'        => 'bg-red-100 text-red-800',
    'default'     => 'bg-gray-100 text-gray-800',
];
$class = $colors[$type] ?? $colors['default'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $class"]) }}>
    {{ $text }}
</span>