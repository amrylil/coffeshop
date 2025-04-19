<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Terra Shop</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f8f7f4]">
    <div class="flex min-h-screen w-full">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center"
            style="background-image: url('{{ asset('images/login.jpg') }}')">
            <div
                class="h-full flex flex-col justify-between p-12 bg-gradient-to-t from-black/60 via-black/40 to-transparent">
                <div class="text-white">
                    <h2 class="font-playfair text-3xl font-bold">COFFEE SHOP</h2>
                </div>
                <div class="text-white max-w-md">
                    <h3 class="font-playfair text-4xl font-bold mb-4">Nikmati Kopi Premium Pilihan</h3>
                    <p class="font-montserrat opacity-80">
                        Rasakan cita rasa terbaik dari biji kopi pilihan yang disajikan dengan penuh cinta dan dedikasi.
                    </p>
                </div>

            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Logo for Mobile -->
                <div class="lg:hidden text-center mb-10">
                    <h1 class="font-playfair text-3xl font-bold text-[#1a1a1a]">TERRA</h1>
                </div>

                <!-- Form Container -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="font-playfair text-3xl font-semibold text-[#1a1a1a] mb-2">Welcome Back</h2>
                        <p class="font-montserrat text-gray-500 text-sm">Sign in to your account to continue</p>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-sm">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-5">
                            <div class="relative">
                                <label for="email"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Email
                                    Address</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input id="email"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="email" name="email" placeholder="your@email.com" required />
                                </div>
                            </div>

                            <div class="relative">
                                <div class="flex justify-between items-center mb-1">
                                    <label for="password"
                                        class="font-montserrat text-xs font-medium text-gray-700 ml-1">Password</label>
                                    <a href="#"
                                        class="text-xs text-[#a07942] hover:underline font-montserrat">Forgot
                                        password?</a>
                                </div>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="password" name="password" placeholder="••••••••" required />
                                    <button type="button"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        id="togglePassword">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input id="remember" type="checkbox"
                                    class="w-4 h-4 text-[#a07942] border-gray-300 rounded focus:ring-[#a07942]"
                                    name="remember">
                                <label for="remember" class="ml-2 text-xs text-gray-700 font-montserrat">Remember me for
                                    30 days</label>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#1a1a1a] text-white font-montserrat font-medium py-3 rounded-lg hover:bg-[#333] transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Sign In
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center my-6">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="mx-4 text-xs text-gray-400 font-montserrat">OR CONTINUE WITH</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button
                            class="flex items-center justify-center py-2.5 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                                <path fill="#EA4335"
                                    d="M5.26620003,9.76452941 C6.19878754,6.93863203 8.85444915,4.90909091 12,4.90909091 C13.6909091,4.90909091 15.2181818,5.50909091 16.4181818,6.49090909 L19.9090909,3 C17.7818182,1.14545455 15.0545455,0 12,0 C7.27006974,0 3.1977497,2.69829785 1.23999023,6.65002441 L5.26620003,9.76452941 Z" />
                                <path fill="#34A853"
                                    d="M16.0407269,18.0125889 C14.9509167,18.7163016 13.5660892,19.0909091 12,19.0909091 C8.86648613,19.0909091 6.21911939,17.076871 5.27698177,14.2678769 L1.23746264,17.3349879 C3.19279051,21.2936293 7.26500293,24 12,24 C14.9328362,24 17.7353462,22.9573905 19.834192,20.9995801 L16.0407269,18.0125889 Z" />
                                <path fill="#4A90E2"
                                    d="M19.834192,20.9995801 C22.0291676,18.9520994 23.4545455,15.903663 23.4545455,12 C23.4545455,11.2909091 23.3454545,10.5272727 23.1818182,9.81818182 L12,9.81818182 L12,14.4545455 L18.4363636,14.4545455 C18.1187732,16.013626 17.2662994,17.2212117 16.0407269,18.0125889 L19.834192,20.9995801 Z" />
                                <path fill="#FBBC05"
                                    d="M5.27698177,14.2678769 C5.03832634,13.556323 4.90909091,12.7937589 4.90909091,12 C4.90909091,11.2182781 5.03443647,10.4668121 5.26620003,9.76452941 L1.23999023,6.65002441 C0.43658717,8.26043162 0,10.0753848 0,12 C0,13.9195484 0.444780743,15.7301709 1.23746264,17.3349879 L5.27698177,14.2678769 Z" />
                            </svg>
                            <span class="text-sm font-montserrat text-gray-700">Google</span>
                        </button>
                        <button
                            class="flex items-center justify-center py-2.5 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="#1877F2">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            <span class="text-sm font-montserrat text-gray-700">Facebook</span>
                        </button>
                    </div>

                    <!-- Signup Link -->
                    <div class="text-center font-montserrat text-sm">
                        <span class="text-gray-600">Don't have an account?</span>
                        <a href="{{ route('signup') }}" class="text-[#a07942] font-medium ml-1 hover:underline">Create
                            account</a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500 font-montserrat">
                        &copy; 2025 Terra Shop. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Add animation classes
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('form, .text-center h2, .text-center p');

            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                element.style.transitionDelay = `${index * 0.1}s`;

                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>

</html>
