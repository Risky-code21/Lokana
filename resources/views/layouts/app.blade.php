<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lokana Admin')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
        .rotate-180 {
            transform: rotate(180deg);
        }
        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    
    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar-admin')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile Menu Button -->
                            <button id="sidebarToggle" class="lg:hidden mr-3 text-gray-600 hover:text-gray-900">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <!-- Page Title -->
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
                                    @yield('page-title', 'Dashboard')
                                </h1>
                                @hasSection('breadcrumb')
                                <div class="text-sm text-gray-600 mt-1">
                                    @yield('breadcrumb')
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Right Side -->
                        <div class="flex items-center space-x-4">
                            
                            <!-- User Avatar -->
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Page Content -->
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t px-4 sm:px-6 py-3">
                <div class="text-center sm:text-left text-sm text-gray-600">
                    &copy; {{ date('D-M-Y') }} Lokana Admin Dashboard. All rights reserved.
                </div>
            </footer>
        </div>
    </div>
    @else
    <!-- If not logged in or not admin -->
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Access Denied</h1>
            <p class="text-gray-600 mb-6">You need to be logged in as admin to access this page.</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Go to Login
            </a>
        </div>
    </div>
    @endif
    
    @stack('scripts')
</body>
</html>
