@extends('layouts.app')

@section('title', 'Coffee Selection')

@section('content')
    <section class="min-h-screen py-12 ">
        <div class="">
            <!-- Simple Elegant Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-serif italic mb-6  text-[#e6dbd1]">Menu Kami</h2>
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

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <!-- Product 1 - Minimal Elegant Card -->
                <div class="product-card fade-in">
                    <div class="bg-white rounded-xl shadow-md text-left text-[#3e1f1f] relative">
                        <div class="p-4 w-full h-72">
                            <span class="absolute top-2  left-4 bg-[#5e3c3c] text-white px-2 py-1 text-xs rounded">100%
                                Aribika</span>
                            <img src="{{ asset('images/coffe.png') }}" alt="Product 1"
                                class="w-full h-full scale-110 object-cover">
                        </div>
                        <div class="bg-[#eee3d2] p-4">
                            <h3 class="font-semibold text-sm mb-2">Kahwa Coffee</h3>
                            <div class="flex justify-between items-center ">
                                <span class="font-bold text-base">Rp 32.000</span>
                                <button
                                    class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1 rounded transition">ADD
                                    TO
                                    CART</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-card fade-in">
                    <div class="bg-white rounded-xl shadow-md text-left text-[#3e1f1f] relative">
                        <div class="p-4 w-full h-72">
                            <span class="absolute top-2  left-4 bg-[#5e3c3c] text-white px-2 py-1 text-xs rounded">100%
                                Aribika</span>
                            <img src="{{ asset('images/coffe.png') }}" alt="Product 1"
                                class="w-full h-full scale-110 object-cover">
                        </div>
                        <div class="bg-[#eee3d2] p-4">
                            <h3 class="font-semibold text-sm mb-2">Kahwa Coffee</h3>
                            <div class="flex justify-between items-center ">
                                <span class="font-bold text-base">Rp 32.000</span>
                                <button
                                    class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1 rounded transition">ADD
                                    TO
                                    CART</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-card fade-in">
                    <div class="bg-white rounded-xl shadow-md text-left text-[#3e1f1f] relative">
                        <div class="p-4 w-full h-72">
                            <span class="absolute top-2  left-4 bg-[#5e3c3c] text-white px-2 py-1 text-xs rounded">100%
                                Aribika</span>
                            <img src="{{ asset('images/coffe.png') }}" alt="Product 1"
                                class="w-full h-full scale-110 object-cover">
                        </div>
                        <div class="bg-[#eee3d2] p-4">
                            <h3 class="font-semibold text-sm mb-2">Kahwa Coffee</h3>
                            <div class="flex justify-between items-center ">
                                <span class="font-bold text-base">Rp 32.000</span>
                                <button
                                    class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1 rounded transition">ADD
                                    TO
                                    CART</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-card fade-in">
                    <div class="bg-white rounded-xl shadow-md text-left text-[#3e1f1f] relative">
                        <div class="p-4 w-full h-72">
                            <span class="absolute top-2  left-4 bg-[#5e3c3c] text-white px-2 py-1 text-xs rounded">100%
                                Aribika</span>
                            <img src="{{ asset('images/coffe.png') }}" alt="Product 1"
                                class="w-full h-full scale-110 object-cover">
                        </div>
                        <div class="bg-[#eee3d2] p-4">
                            <h3 class="font-semibold text-sm mb-2">Kahwa Coffee</h3>
                            <div class="flex justify-between items-center ">
                                <span class="font-bold text-base">Rp 32.000</span>
                                <button
                                    class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1 rounded transition">ADD
                                    TO
                                    CART</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 - Minimal Elegant Card -->


            </div>
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
        #add-to-cart:active {
            transform: scale(0.95);
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

            // Add to Cart Functionality
            document.querySelectorAll('#add-to-cart').forEach(button => {
                button.addEventListener('click', async function() {
                    if (!isUserLoggedIn()) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }

                    const productId = this.dataset.productId;
                    const qty = 1;

                    try {
                        const response = await fetch(`{{ route('cart.add', ':id') }}`.replace(
                            ':id', productId), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                quantity: qty
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Error adding to cart.');
                        }

                        const data = await response.json();
                        alert('Product added to cart successfully!');

                    } catch (error) {
                        console.error('Error:', error);
                        alert('Failed to add to cart. Please try again.');
                    }
                });
            });

            // Add staggered animation to product cards
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        function isUserLoggedIn() {
            return {{ auth()->check() ? 'true' : 'false' }};
        }
    </script>
@endsection
