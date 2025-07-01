@extends('layouts.app')

@section('title', 'Coffee Selection')

@section('content')
    <section class="min-h-screen py-12">
        <div class="">
            <!-- Simple Elegant Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-serif italic mb-6 text-[#e6dbd1]">Menu Kami</h2>
                <div class="flex justify-center items-center">
                    <div class="h-px w-16 bg-[#e6dbd1]"></div>
                    <span class="mx-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#e6dbd1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path>
                            <line x1="6" y1="2" x2="6" y2="4"></line>
                            <line x1="10" y1="2" x2="10" y2="4"></line>
                            <line x1="14" y1="2" x2="14" y2="4"></line>
                        </svg>
                    </span>
                    <div class="h-px w-16 bg-[#e6dbd1]"></div>
                </div>
                <p class="text-xl font-light text-slate-50 max-w-3xl mx-auto mt-8">
                    Selamat datang di <span class="font-serif italic text-[#e6dbd1]">Coffee Shop</span>, tempat di mana
                    kopi berkualitas, cerita inspiratif, dan kehangatan berpadu dalam setiap cangkir yang kami sajikan.
                </p>
            </div>



            <!-- Search and Filter Section -->
            <div class="max-w-7xl mx-auto px-4 mb-12">
                <div class="flex flex-col lg:flex-row justify-between gap-6">
                    <!-- Search Bar -->
                    <div class="lg:w-1/2">
                        <form action="{{ route('menu.search') }}" method="GET"
                            class="flex border border-slate-50 rounded-lg">
                            <input type="text" name="query" placeholder="Search for menu items..."
                                class="w-full text-slate-50 px-4 py-2 rounded-l-lg border-0 focus:ring-2 focus:ring-[#3e1f1f] text-[#3e1f1f]"
                                value="{{ request('query') }}">
                            <button type="submit"
                                class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white px-4 py-2 rounded-r-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Category Filter -->
                    <div class="lg:w-1/2 flex flex-wrap gap-2 justify-end">
                        <a href="{{ route('menu.index') }}"
                            class="px-4 py-2 rounded-full text-sm font-medium {{ request()->category == null ? 'bg-[#3e1f1f] text-white' : 'bg-[#eee3d2] text-[#3e1f1f]' }}">
                            All
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('menu.category', $category->kode_kategori_222297) }}"
                                class="px-4 py-2 rounded-full text-sm font-medium {{ request()->route('categoryId') == $category->kode_kategori_222297 ? 'bg-[#3e1f1f] text-white' : 'bg-[#eee3d2] text-[#3e1f1f]' }}">
                                {{ $category->nama_222297 }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            @if ($menus->isEmpty())
                <div class="text-center py-12">
                    <p class="text-xl text-[#e6dbd1]">No menu items found matching your criteria.</p>
                </div>
            @else
                <div class="max-w-7xl mx-auto px-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="menuItems">
                        @foreach ($menus as $menu)
                            <div class="product-card fade-in">
                                <div class="bg-white rounded-xl shadow-md text-left text-[#3e1f1f] relative">
                                    <a href="{{ route('menu.show', $menu->kode_menu_222297) }}">
                                        <div class="p-4 w-full h-72">
                                            <span
                                                class="absolute top-2 left-4 bg-[#5e3c3c] text-white px-2 py-1 text-xs rounded">
                                                {{ $menu->kategori->nama_kategori_222297 }}
                                            </span>
                                            @if ($menu->path_img_222297)
                                                <img src="{{ asset('images/' . $menu->path_img_222297) }}"
                                                    alt="{{ $menu->nama_222297 }}"
                                                    class="w-full h-full scale-110 object-cover">
                                            @else
                                                <img src="{{ asset('images/coffe.png') }}" alt="{{ $menu->nama_222297 }}"
                                                    class="w-full h-full scale-110 object-cover">
                                            @endif
                                        </div>
                                    </a>
                                    <div class="bg-[#eee3d2] p-4">
                                        <h3 class="font-semibold text-sm mb-2">{{ $menu->nama_222297 }}</h3>
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold text-base">Rp
                                                {{ number_format($menu->harga_222297, 0, ',', '.') }}</span>
                                            <button
                                                class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1 rounded transition add-to-cart-btn"
                                                data-menu-id="{{ $menu->kode_menu_222297 }}"
                                                data-menu-name="{{ $menu->nama_222297 }}"
                                                data-menu-price="{{ $menu->harga_222297 }}">
                                                <span class="btn-text p-2 rounded-2xl">ADD TO CART</span>
                                                <span class="btn-loading hidden">
                                                    <svg class="animate-spin h-4 w-4 text-white"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center" id="pagination">
                        {{ $menus->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Scroll to top button -->
        <button id="scrollToTopButton"
            class="fixed bottom-6 right-6 bg-[#3e1f1f] text-white p-3 rounded-full shadow-lg opacity-0 transition-all duration-300 hover:bg-[#5a2d2d]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </section>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden transition-all duration-300">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toast-message">Item added to cart!</span>
        </div>
    </div>

    <!-- Login Modal (if user is not authenticated) -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
                <h3 class="text-xl font-semibold mb-4 text-[#3e1f1f]">Login Required</h3>
                <p class="text-gray-600 mb-6">You need to login to add items to your cart.</p>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}"
                        class="bg-[#3e1f1f] text-white px-4 py-2 rounded hover:bg-[#5a2d2d] transition">Login</a>
                    <button onclick="closeLoginModal()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        /* Base Styles */
        body {
            font-family: 'Nunito', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* Product Card Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scroll to Top Button Animation */
        #scrollToTopButton {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }

        #scrollToTopButton.visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Add to Cart Button Animation */
        .add-to-cart-btn:active {
            transform: scale(0.95);
        }

        .add-to-cart-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Toast Animation */
        #toast.show {
            display: block;
            animation: slideInDown 0.3s ease-out;
        }

        @keyframes slideInDown {
            from {
                transform: translate(-50%, -100%);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            justify-content: center;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #eee3d2;
            color: #3e1f1f;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination li.active span {
            background-color: #3e1f1f;
            color: white;
        }

        .pagination li a:hover {
            background-color: #d4c7b6;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

            // CSRF Token for AJAX requests
            let csrfToken;
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfMeta) {
                csrfToken = csrfMeta.getAttribute('content');
            } else {
                csrfToken = '{{ csrf_token() }}';
            }

            console.log('Page loaded, isLoggedIn:', isLoggedIn);

            // Scroll to Top Button
            const scrollToTopButton = document.getElementById('scrollToTopButton');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    scrollToTopButton.classList.add('visible');
                } else {
                    scrollToTopButton.classList.remove('visible');
                }
            });

            scrollToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Product card animations
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Load cart count on page load
            if (isLoggedIn) {
                loadCartCount();
            }

            // Add to Cart functionality
            document.addEventListener('click', function(e) {
                console.log('Click detected on:', e.target);

                if (e.target.closest('.add-to-cart-btn')) {
                    e.preventDefault();
                    console.log('Add to cart button clicked');

                    if (!isLoggedIn) {
                        console.log('User not logged in, showing modal');
                        showLoginModal();
                        return;
                    }

                    const button = e.target.closest('.add-to-cart-btn');
                    const menuId = button.getAttribute('data-menu-id');
                    const menuName = button.getAttribute('data-menu-name');

                    console.log('Menu ID:', menuId, 'Menu Name:', menuName);
                    addToCart(menuId, menuName, button);
                }
            });

            // Cart button click
            document.getElementById('cartButton').addEventListener('click', function() {
                if (isLoggedIn) {
                    window.location.href = "{{ route('keranjang.index') }}";
                } else {
                    showLoginModal();
                }
            });

            // Functions
            function addToCart(menuId, menuName, button) {
                console.log('addToCart function called with:', menuId, menuName);

                // Disable button and show loading
                button.disabled = true;
                const btnText = button.querySelector('.btn-text');
                const btnLoading = button.querySelector('.btn-loading');

                if (btnText) btnText.classList.add('hidden');
                if (btnLoading) btnLoading.classList.remove('hidden');

                const requestData = {
                    kode_menu_222297: menuId,
                    quantity_222297: 1
                };

                console.log('Sending request to:', "{{ route('keranjang.add') }}");
                console.log('Request data:', requestData);
                console.log('CSRF Token:', csrfToken);

                fetch("{{ route('keranjang.add') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(requestData)
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            showToast(`${menuName} added to cart!`, 'success');
                            loadCartCount(); // Update cart count
                        } else {
                            showToast(data.message || 'Failed to add item to cart', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        // Re-enable button and hide loading
                        button.disabled = false;
                        if (btnText) btnText.classList.remove('hidden');
                        if (btnLoading) btnLoading.classList.add('hidden');
                    });
            }

            function loadCartCount() {
                fetch("{{ route('keranjang.count') }}", {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartCount(data.count);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading cart count:', error);
                    });
            }

            function updateCartCount(count) {
                const cartCountElement = document.getElementById('cartCount');
                if (count > 0) {
                    cartCountElement.textContent = count;
                    cartCountElement.classList.remove('hidden');
                } else {
                    cartCountElement.classList.add('hidden');
                }
            }

            function showToast(message, type = 'success') {
                const toast = document.getElementById('toast');
                const toastMessage = document.getElementById('toast-message');

                toastMessage.textContent = message;

                // Change color based on type
                if (type === 'error') {
                    toast.className = toast.className.replace('bg-green-500', 'bg-red-500');
                } else {
                    toast.className = toast.className.replace('bg-red-500', 'bg-green-500');
                }

                toast.classList.remove('hidden');
                toast.classList.add('show');

                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 300);
                }, 3000);
            }

            function showLoginModal() {
                document.getElementById('loginModal').classList.remove('hidden');
            }

            // Make closeLoginModal available globally
            window.closeLoginModal = function() {
                document.getElementById('loginModal').classList.add('hidden');
            }

            // Alternative simple function for onclick
            window.handleAddToCart = function(button) {
                console.log('handleAddToCart called directly');

                if (!isLoggedIn) {
                    console.log('User not logged in');
                    showLoginModal();
                    return;
                }

                const menuId = button.getAttribute('data-menu-id');
                const menuName = button.getAttribute('data-menu-name');

                console.log('Direct call - Menu ID:', menuId, 'Menu Name:', menuName);
                addToCart(menuId, menuName, button);
            }
        });
    </script>
@endsection
