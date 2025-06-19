@extends('layouts.master2')

@section('title')
تسجيل الدخول - محمد شكر للإدارة القانونية
@stop

@section('css')
<!-- Tailwind CSS CDN for styling -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    /* Custom animations for fade-in effect */
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    /* Gradient background for the image side */
    .bg-gradient-side {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }
    /* Hover effect for button */
    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="container mx-auto flex flex-col lg:flex-row shadow-2xl rounded-2xl overflow-hidden max-w-5xl">
        <!-- Content Half -->
        <div class="w-full lg:w-1/2 bg-white p-8 lg:p-12 flex items-center justify-center">
            <div class="w-full max-w-md fade-in">
                <!-- Logo and Title -->
                <div class="flex items-center mb-8">
                    <a href="{{ url('/' . $page='Home') }}">
                        <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="h-12 w-12" alt="logo">
                    </a>
                    <h1 class="text-3xl font-bold text-blue-900 ml-2">مكتب <span class="text-blue-600">محمد شكر</span></h1>
                </div>
                <!-- Form -->
                <div class="bg-white p-6 rounded-lg">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">مرحباً بك</h2>
                    <h5 class="text-gray-600 mb-6">تسجيل الدخول إلى حسابك</h5>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                            <input id="email" type="email" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                            <input id="password" type="password" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center mb-6">
                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 text-sm text-gray-600">تذكرني</label>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg btn-hover transition duration-300">
                            {{ __('تسجيل الدخول') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Image Half -->
        <div class="hidden lg:block w-1/2 bg-gradient-side p-12 text-center">
            <div class="flex flex-col items-center justify-center h-full text-white">
                <img src="{{ URL::asset('assets/img/media/login.png') }}" class="h-64 w-auto mb-6 fade-in" alt="legal management illustration">
                <h3 class="text-2xl font-bold">محمد شكر للإدارة القانونية</h3>
                <p class="mt-2 text-lg">حلول قانونية موثوقة ومبتكرة لدعم نجاحك</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Add any JavaScript if needed (e.g., for additional interactivity) -->
<script>
    // Optional: Add simple form validation or animations
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        form.addEventListener('submit', (e) => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            if (!email || !password) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول');
            }
        });
    });
</script>
@endsection