@extends('layouts.root')

@section('body')
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 text-gray-900 sm:justify-center sm:pt-0">
        <div>
            <a href="/">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-32 w-auto">
            </a>
        </div>

        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
@endsection
