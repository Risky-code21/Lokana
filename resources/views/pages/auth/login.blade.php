@extends('layouts.auth')

@section('main')
    {{-- Header form register --}}
    <h1 class="text-center">Sign In</h1>
    {{-- Paragraph form register --}}
    <p class="text-center font-heading text-base">Hey, Enter your details to get sign in to your account</p>

    {{-- Main form --}}
    <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
        @csrf
        <x-input required name="email" id="email" placeholder="Enter your email" type="email" />
        {{-- Input password --}}
        <x-input required name="password" id="password" placeholder="Enter your password" type="password" />
        {{-- Additional options --}}
        <div class="flex justify-between items-center">
            {{-- Remember me checkbox --}}
            <x-checkbox name="remamber_me" id="remamber_me" label="Remamber me" />
            {{-- Forgot password link --}}
            <a href="" class="text-sm font-normal">Forgot Password?</a>
        </div>
        <button type="submit" class="btn-primary w-full">Sign In</button>
        {{-- Redirect custom ke dalam register page --}}
        <p class="text-base text-center">Don't have an account? <a href="{{ route('register.index') }}">Sign Up</a></p>
    </form>
@endsection
