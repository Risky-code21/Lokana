@extends('layouts.auth')

@section('main')
    {{-- Header form register --}}
    <h1 class="text-center">Sign Up</h1>
    {{-- Paragraph form register --}}
    <p class="text-center font-heading text-base">Hey, Enter your details to get sign in to your account</p>

    {{-- Main form --}}
    <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
        @csrf
        {{-- Input username --}}
        <x-input required name="name" id="name" placeholder="Enter your name" type="text" />
        {{-- Input email --}}
        <x-input required name="email" id="email" placeholder="Enter your email" type="email" />
        {{-- Input password --}}
        <x-input required name="password" id="password" placeholder="Enter your password" type="password" />
        {{-- Input confirm password --}}
        <x-input required name="password_confirmation" id="password_confirmation" placeholder="Confirm your password"
            type="password" />
        <x-checkbox required name="terms" id="terms" label="I agree to the Privacy & Policy" />
        <button type="submit" class="btn-primary w-full">Sign Up</button>
        <p class="text-base text-center">Have an account? <a href="{{ route('login.index') }}">Sign In</a></p>
    </form>
@endsection
