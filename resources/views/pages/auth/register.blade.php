<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar | Terra Shop</title>
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
                    <h3 class="font-playfair text-4xl font-bold mb-4">Bergabunglah dengan Komunitas Kami</h3>
                    <p class="font-montserrat opacity-80">
                        Mulai perjalanan kopi Anda bersama kami dan dapatkan pengalaman baru dalam menikmati kopi
                        premium.
                    </p>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan - Form Register -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Logo untuk Mobile -->
                <div class="lg:hidden text-center mb-10">
                    <h1 class="font-playfair text-3xl font-bold text-[#1a1a1a]">TERRA</h1>
                </div>

                <!-- Kontainer Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="font-playfair text-3xl font-semibold text-[#1a1a1a] mb-2">Buat Akun Baru</h2>
                        <p class="font-montserrat text-gray-500 text-sm">Daftar untuk menikmati layanan kami</p>
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
                    <form action="{{ route('register') }}" method="POST" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-5" id="basic-info">
                            <!-- Name Input -->
                            <div class="relative">
                                <label for="name"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Nama
                                    Lengkap <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <input id="name"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="text" name="name" placeholder="Nama Lengkap"
                                        value="{{ old('name') }}" required />
                                </div>
                            </div>

                            <!-- Email Input -->
                            <div class="relative">
                                <label for="email"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Alamat
                                    Email <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input id="email"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="email" name="email" placeholder="email@anda.com"
                                        value="{{ old('email') }}" required />
                                </div>
                            </div>

                            <!-- Role Selection -->
                            <div class="relative">
                                <label class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Daftar
                                    Sebagai
                                    <span class="text-red-500">*</span></label>
                                <div class="flex space-x-4">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="role" value="customer"
                                            class="form-radio text-[#a07942] focus:ring-[#a07942]"
                                            {{ old('role', 'customer') == 'customer' ? 'checked' : '' }} required>
                                        <span class="font-montserrat text-sm text-gray-700">Customer</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="role" value="admin"
                                            class="form-radio text-[#a07942] focus:ring-[#a07942]"
                                            {{ old('role') == 'admin' ? 'checked' : '' }} required>
                                        <span class="font-montserrat text-sm text-gray-700">Admin</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="relative">
                                <label for="password"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Kata
                                    Sandi <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="password" name="password" placeholder="Minimal 8 karakter" required />
                                    <button type="button"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        id="togglePassword">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="relative">
                                <label for="password_confirmation"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Konfirmasi
                                    Kata Sandi <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password_confirmation"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="password" name="password_confirmation"
                                        placeholder="Konfirmasi kata sandi" required />
                                    <button type="button"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        id="togglePasswordConfirm">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol untuk memunculkan data tambahan -->
                        <div class="text-center">
                            <button type="button" id="showAdditionalInfo"
                                class="text-[#a07942] font-montserrat text-sm font-medium hover:underline flex items-center mx-auto">
                                <span>Tambahkan informasi lainnya</span>
                                <i class="fas fa-chevron-down ml-2" id="additionalInfoIcon"></i>
                            </button>
                        </div>

                        <!-- Data tambahan (hidden by default) -->
                        <div class="space-y-5 hidden" id="additional-info">
                            <!-- Gender Input -->
                            <div class="relative">
                                <label for="gender"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Jenis
                                    Kelamin</label>
                                <div class="flex space-x-4">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="gender" value="male"
                                            class="form-radio text-[#a07942] focus:ring-[#a07942]"
                                            {{ old('gender') == 'male' ? 'checked' : '' }}>
                                        <span class="font-montserrat text-sm text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="gender" value="female"
                                            class="form-radio text-[#a07942] focus:ring-[#a07942]"
                                            {{ old('gender') == 'female' ? 'checked' : '' }}>
                                        <span class="font-montserrat text-sm text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Phone Input -->
                            <div class="relative">
                                <label for="phone"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Nomor
                                    Telepon</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input id="phone"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="text" name="phone" placeholder="Contoh: 081234567890"
                                        value="{{ old('phone') }}" />
                                </div>
                            </div>

                            <!-- Address Input -->
                            <div class="relative">
                                <label for="address"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Alamat</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-4 transform text-gray-400">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <textarea id="address"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        name="address" placeholder="Alamat lengkap" rows="3">{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <!-- Birth Date Input -->
                            <div class="relative">
                                <label for="birth_date"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Tanggal
                                    Lahir</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <input id="birth_date"
                                        class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                                        type="date" name="birth_date" value="{{ old('birth_date') }}" />
                                </div>
                            </div>

                            <!-- Profile Photo Upload -->
                            <div class="relative">
                                <label for="profile_photo"
                                    class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Foto
                                    Profil</label>
                                <div class="mt-1 flex items-center">
                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                        <img id="preview" class="h-full w-full object-cover"
                                            src="{{ asset('images/default-avatar.png') }}" alt="Preview">
                                    </span>
                                    <label for="profile_photo"
                                        class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#a07942] cursor-pointer">
                                        <span>Unggah</span>
                                        <input id="profile_photo" name="profile_photo" type="file"
                                            class="sr-only" accept="image/*" onchange="previewImage()">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#1a1a1a] text-white font-montserrat font-medium py-3 rounded-lg hover:bg-[#333] transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Daftar
                        </button>
                    </form>

                    <!-- Tautan Login -->
                    <div class="text-center font-montserrat text-sm mt-6">
                        <span class="text-gray-600">Sudah memiliki akun?</span>
                        <a href="{{ route('login') }}"
                            class="text-[#a07942] font-medium ml-1 hover:underline">Masuk</a>
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

        // Toggle visibilitas konfirmasi kata sandi
        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
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

        // Preview gambar yang diunggah
        function previewImage() {
            const input = document.getElementById('profile_photo');
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle informasi tambahan
        document.getElementById('showAdditionalInfo').addEventListener('click', function() {
            const additionalInfo = document.getElementById('additional-info');
            const icon = document.getElementById('additionalInfoIcon');

            additionalInfo.classList.toggle('hidden');

            if (additionalInfo.classList.contains('hidden')) {
                this.querySelector('span').textContent = 'Tambahkan informasi lainnya';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                this.querySelector('span').textContent = 'Sembunyikan informasi lainnya';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
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
