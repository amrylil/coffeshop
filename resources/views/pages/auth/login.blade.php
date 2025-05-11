<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Terra Shop</title>
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
        <!-- Sisi Kiri - Gambar -->
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center"
            style="background-image: url('{{ asset('images/login.jpg') }}')">
            <div
                class="h-full flex flex-col justify-between p-12 bg-gradient-to-t from-black/60 via-black/40 to-transparent">
                <div class="text-white">
                    <h2 class="font-playfair text-3xl font-bold">COFFE SHOP</h2>
                </div>
                <div class="text-white max-w-md">
                    <h3 class="font-playfair text-4xl font-bold mb-4">Nikmati Kopi Premium Pilihan</h3>
                    <p class="font-montserrat opacity-80">
                        Rasakan cita rasa terbaik dari biji kopi pilihan yang disajikan dengan penuh cinta dan dedikasi.
                    </p>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan - Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Logo untuk Mobile -->
                <div class="lg:hidden text-center mb-10">
                    <h1 class="font-playfair text-3xl font-bold text-[#1a1a1a]">TERRA</h1>
                </div>

                <!-- Kontainer Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="font-playfair text-3xl font-semibold text-[#1a1a1a] mb-2">Selamat Datang Kembali</h2>
                        <p class="font-montserrat text-gray-500 text-sm">Masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    <!-- Pesan Kesalahan -->
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
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Alamat
                                    Email</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input id="email"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="email" name="email" placeholder="email@anda.com" required />
                                </div>
                            </div>

                            <div class="relative">
                                <div class="flex justify-between items-center mb-1">
                                    <label for="password"
                                        class="font-montserrat text-xs font-medium text-gray-700 ml-1">Kata
                                        Sandi</label>
                                    <a href="#"
                                        class="text-xs text-[#a07942] hover:underline font-montserrat">Lupa
                                        kata sandi?</a>
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


                        </div>

                        <button type="submit"
                            class="w-full bg-[#1a1a1a] text-white font-montserrat font-medium py-3 rounded-lg hover:bg-[#333] transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Masuk
                        </button>
                    </form>

                    <!-- Tautan Pendaftaran -->
                    <div class="text-center font-montserrat text-sm mt-6">
                        <span class="text-gray-600">Belum memiliki akun?</span>
                        <a href="{{ route('register') }}" class="text-[#a07942] font-medium ml-1 hover:underline">Buat
                            akun</a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500 font-montserrat">
                        &copy; 2025 Coffe Shop. Seluruh hak cipta dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle visibilitas kata sandi
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

        // Menambahkan kelas animasi
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
