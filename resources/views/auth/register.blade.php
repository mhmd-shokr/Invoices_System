@extends('layouts.master2')

@section('title')
إنشاء حساب - محمد شكر للإدارة القانونية
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    .bg-gradient-side {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }
    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="container mx-auto flex flex-col lg:flex-row shadow-2xl rounded-2xl overflow-hidden max-w-5xl">
        <!-- Form Side -->
        <div class="w-full lg:w-1/2 bg-white p-8 lg:p-12 flex items-center justify-center">
            <div class="w-full max-w-md fade-in">
                <div class="flex items-center mb-8">
                    <a href="{{ url('/' . $page='Home') }}">
                        <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="h-12 w-12" alt="logo">
                    </a>
                    <h1 class="text-3xl font-bold text-blue-900 ml-2">مكتب <span class="text-blue-600">محمد شكر</span></h1>
                </div>
                <div class="bg-white p-6 rounded-lg">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">مرحباً بك</h2>
                    <h5 class="text-gray-600 mb-6">إنشاء حساب جديد</h5>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                            <input id="password" type="password" name="password" required
                                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('password_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg btn-hover transition duration-300">
                            {{ __('إنشاء الحساب') }}
                        </button>

                        <div class="mt-4 text-sm text-gray-600 text-center">
                            لديك حساب بالفعل؟ 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">تسجيل الدخول</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Image Side -->
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        form.addEventListener('submit', (e) => {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            if (!name || !email || !password || !confirm) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول');
            }
        });
    });
</script>
@endsection
