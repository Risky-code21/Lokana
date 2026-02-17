<aside id="sidebar" class="bg-gray-900 text-white w-64 min-h-screen p-4 lg:block lg:translate-x-0 transform -translate-x-full transition-transform duration-300 fixed lg:relative z-40">
    
    <!-- Logo Section -->
    <div class="mb-8 px-2">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                <h2 class="text-xl font-bold">Lokana</h2>
            </div>
            <span class="text-xs bg-blue-600 px-2 py-1 rounded">ADMIN</span>
        </div>
        <p class="text-gray-400 text-xs mt-2 ml-1">Dashboard Management</p>
    </div>

    <!-- Menu Items -->
    <nav class="space-y-1">
        
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->is('admin/dashboard') ? 'bg-blue-900 text-white' : '' }}">
            <i class="fas fa-home w-5"></i>
            <span>Dashboard</span>
        </a>

        <!-- UMKM MANAGEMENT -->
        <div class="pt-2">
            <h3 class="text-xs uppercase text-gray-400 tracking-wider px-3 py-2">UMKM MANAGEMENT</h3>
            
            <!-- MSME Profile -->
            <div class="space-y-1 dropdown-parent">
                <a href="javascript:void(0)" class="dropdown-toggle flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.msme-profile.*') ? 'bg-blue-900' : '' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-store w-5"></i>
                        <span>MSME Profile</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </a>
                <div class="dropdown-content ml-8 space-y-1 hidden">
                    <a href="#" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.msme-profile.index') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-list w-4"></i>
                        <span class="text-sm">List</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.msme-profile.create') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-plus w-4"></i>
                        <span class="text-sm">Create</span>
                    </a>
                </div>
            </div>

            <!-- MSME Artisan -->
            <div class="space-y-1 dropdown-parent">
                <a href="javascript:void(0)" class="dropdown-toggle flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.pelaku-umkm.*') ? 'bg-blue-900' : '' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-hands-helping w-5"></i>
                        <span>MSME Artisan</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </a>
                <div class="dropdown-content ml-8 space-y-1 hidden {{ request()->routeIs('admin.pelaku-umkm.*') ? '' : 'hidden' }}">
                    <a href="{{ route('admin.pelaku-umkm.index') }}" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.pelaku-umkm.index') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-list w-4"></i>
                        <span class="text-sm">List</span>
                    </a>
                    <a href="{{ route('admin.pelaku-umkm.create') }}" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.pelaku-umkm.create') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-plus w-4"></i>
                        <span class="text-sm">Create</span>
                    </a>
                </div>
            </div>
            
            <!-- Category MSME -->
            <div class="space-y-1 dropdown-parent">
                <a href="{{ route('admin.category-umkm.index') }}" class="dropdown-toggle flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.category-umkm.*') ? 'bg-blue-900' : '' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-tags w-5"></i>
                        <span>Category MSME</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </a>
                <div class="dropdown-content ml-8 space-y-1 hidden">
                    <a href="{{ route('admin.category-umkm.index') }}" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.category-umkm.index') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-list w-4"></i>
                        <span class="text-sm">List</span>
                    </a>
                    <a href="{{ route('admin.category-umkm.create') }}" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.category-umkm.create') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-plus w-4"></i>
                        <span class="text-sm">Create</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- PRODUCTS -->
        <div class="pt-2">
            <h3 class="text-xs uppercase text-gray-400 tracking-wider px-3 py-2">PRODUCTS</h3>
            
            <!-- MSME Product -->
            <div class="space-y-1 dropdown-parent">
                <a href="javascript:void(0)" class="dropdown-toggle flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.msme-product.*') ? 'bg-blue-900' : '' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-box w-5"></i>
                        <span>MSME Product</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </a>
                <div class="dropdown-content ml-8 space-y-1 hidden">
                    <a href="#" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.msme-product.index') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-list w-4"></i>
                        <span class="text-sm">List</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.msme-product.create') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-plus w-4"></i>
                        <span class="text-sm">Create</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="pt-2">
            <h3 class="text-xs uppercase text-gray-400 tracking-wider px-3 py-2">CONTENT</h3>
            
            <!-- Article -->
            <div class="space-y-1 dropdown-parent">
                <a href="javascript:void(0)" class="dropdown-toggle flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.article.*') ? 'bg-blue-900' : '' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-newspaper w-5"></i>
                        <span>Article</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </a>
                <div class="dropdown-content ml-8 space-y-1 hidden">
                    <a href="#" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.article.index') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-list w-4"></i>
                        <span class="text-sm">List</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.article.create') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-plus w-4"></i>
                        <span class="text-sm">Create</span>
                    </a>
                </div>
            </div>

            <!-- Article Category -->
            <div class="space-y-1 dropdown-parent">
                <a href="javascript:void(0)" class="dropdown-toggle flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.article-categories.*') ? 'bg-blue-900' : '' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-folder w-5"></i>
                        <span>Article Category</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </a>
                <div class="dropdown-content ml-8 space-y-1 hidden">
                    <a href="{{ route('admin.article-categories.index') }}" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.article-categories.index') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-list w-4"></i>
                        <span class="text-sm">List</span>
                    </a>
                    <a href="{{ route('admin.article-categories.create') }}" class="flex items-center space-x-3 p-2 rounded hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.article-categories.create') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-plus w-4"></i>
                        <span class="text-sm">Create</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- REPORT -->
        <div class="pt-2">
            <h3 class="text-xs uppercase text-gray-400 tracking-wider px-3 py-2">REPORT</h3>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.report') ? 'bg-blue-900' : '' }}">
                <i class="fas fa-chart-pie w-5"></i>
                <span>MSME Suggestion</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.report') ? 'bg-blue-900' : '' }}">
                <i class="fas fa-chart-pie w-5"></i>
                <span>Report</span>
            </a>
        </div>

        <!-- SETTINGS -->
        <div class="pt-2">
            <h3 class="text-xs uppercase text-gray-400 tracking-wider px-3 py-2">SETTINGS</h3>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-blue-900' : '' }}">
                <i class="fas fa-cog w-5"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-900' : '' }}">
                <i class="fas fa-users w-5"></i>
                <span>Users Management</span>
            </a>
        </div>

    </nav>

    <!-- Bottom Section -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800 bg-gray-900">
        <!-- Current User -->
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white"></i>
            </div>
            <div>
                <p class="font-medium">{{ Auth::user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>
        </div>

        <!-- Log Out -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-900 transition-colors w-full text-left bg-gray-800">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden" onclick="toggleSidebar()"></div>

<style>
    .rotate-180 {
        transform: rotate(180deg);
    }
    
    .active-dropdown {
        display: block !important;
    }
</style>

<script>
    // Toggle sidebar function
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // Initialize sidebar toggle button
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('sidebarToggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', toggleSidebar);
        }

        // 1. Auto open dropdown yang memiliki item aktif
        document.querySelectorAll('.dropdown-content').forEach(dropdown => {
            const hasActiveItem = dropdown.querySelector('.bg-blue-800');
            if (hasActiveItem) {
                dropdown.classList.remove('hidden');
                // Juga buka icon chevron
                const toggleBtn = dropdown.previousElementSibling;
                const icon = toggleBtn.querySelector('.fa-chevron-down');
                if (icon) {
                    icon.classList.add('rotate-180');
                }
            }
        });

        // 2. Dropdown toggle untuk menu utama
        document.querySelectorAll('.dropdown-toggle').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const dropdown = this.nextElementSibling;
                const icon = this.querySelector('.fa-chevron-down');
                
                // Cek apakah dropdown ini sedang terbuka
                const isCurrentlyOpen = !dropdown.classList.contains('hidden');
                
                // Tutup SEMUA dropdown lainnya (kecuali yang punya item aktif)
                document.querySelectorAll('.dropdown-content').forEach(otherDropdown => {
                    if (otherDropdown !== dropdown) {
                        const hasActiveItem = otherDropdown.querySelector('.bg-blue-800');
                        if (!hasActiveItem) {
                            otherDropdown.classList.add('hidden');
                            // Reset icon untuk dropdown yang ditutup
                            const otherToggle = otherDropdown.previousElementSibling;
                            const otherIcon = otherToggle.querySelector('.fa-chevron-down');
                            if (otherIcon) {
                                otherIcon.classList.remove('rotate-180');
                            }
                        }
                    }
                });
                
                // Toggle dropdown yang diklik
                if (!isCurrentlyOpen) {
                    dropdown.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                } else {
                    dropdown.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            });
        });

        // 3. Handler untuk link di dalam dropdown - TIDAK menutup dropdown
        document.querySelectorAll('.dropdown-content a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Tidak perlu stopPropagation, biarkan navigasi bekerja
                // Dropdown tetap terbuka karena kita tidak menutupnya di event listener lain
            });
        });

        // 4. Close dropdowns hanya ketika klik di luar sidebar COMPLETELY
        document.addEventListener('click', function(e) {
            // Cek jika klik di luar sidebar sama sekali
            const clickedInsideSidebar = e.target.closest('#sidebar');
            
            if (!clickedInsideSidebar) {
                // Hanya tutup dropdown yang TIDAK memiliki item aktif
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    const hasActiveItem = dropdown.querySelector('.bg-blue-800');
                    if (!hasActiveItem) {
                        dropdown.classList.add('hidden');
                        // Reset icon
                        const toggleBtn = dropdown.previousElementSibling;
                        const icon = toggleBtn.querySelector('.fa-chevron-down');
                        if (icon) {
                            icon.classList.remove('rotate-180');
                        }
                    }
                });
            }
        });
    });
</script>