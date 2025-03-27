@php
    $id = $id ?? $name;
    $error = $errors->has($id);
@endphp

<input {{ $attributes->class([
    'block rounded-md bg-white py-1.5 text-base outline outline-1 -outline-offset-1 focus:outline focus:outline-2 focus:-outline-offset-2 sm:text-sm/6 disabled:opacity-50',
    'text-red-900 outline-red-300 placeholder:text-red-300 focus:outline-red-600' => $error,
    'text-gray-900 outline-gray-300 placeholder:text-gray-400 focus:outline-indigo-600' => !$error,
]) }}>
