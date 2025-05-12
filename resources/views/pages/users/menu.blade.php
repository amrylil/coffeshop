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
                                                <img src="{{ asset($menu->path_img_222297) }}"
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
                                                data-product-id="{{ $menu->kode_menu_222297 }}">
                                                ADD TO CART
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

            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // AJAX for filter and pagination - Uncomment when implementing
            /*
            // Handle AJAX loading for filters
            function loadMenuItems(url) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('menuItems').innerHTML = data.html;
                        document.getElementById('pagination').innerHTML = data.pagination;
                        
                        // Reinitialize animations and event listeners
                        const newProductCards = document.querySelectorAll('.product-card');
                        newProductCards.forEach((card, index) => {
                            card.style.animationDelay = `${index * 0.1}s`;
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                const target = e.target;
                if (target.tagName === 'A' && target.closest('.pagination')) {
                    e.preventDefault();
                    const url = new URL(target.href);
                    url.searchParams.append('ajax', 'true');
                    loadMenuItems(url);
                }
            });
            */
        });

        function isUserLoggedIn() {
            return {{ auth()->check() ? 'true' : 'false' }};
        }
    </script>
@endsection
