<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">

    <!-- Header -->
    <div class="w-full bg-[#33E4DB] py-10 flex justify-center">
        <h1 class="text-white text-4xl font-bold">Akun Baru</h1>
    </div>

    <div class="max-w-md mx-auto mt-10 px-5">

        <!-- FORM REGISTER -->
        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            {{-- Name --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Nama Lengkap</span>
                <input type="text" name="name"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700"
                    placeholder="Nama Lengkap" value="{{ old('name') }}">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Email --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Email</span>
                <input type="email" name="email"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700"
                    placeholder="email@gmail.com" value="{{ old('email') }}">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Password --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Kata Sandi</span>
                <input type="password" name="password"
                    class="w-full p-4 bg-[#EAF7FF] rounded-xl"
                    placeholder="*************">
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Confirm Password --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Konfirmasi Kata Sandi</span>
                <input type="password" name="password_confirmation"
                    class="w-full p-4 bg-[#EAF7FF] rounded-xl"
                    placeholder="*************">
                @error('password_confirmation')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Phone --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Nomor Telepon</span>
                <input type="text" name="phone"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700"
                    placeholder="08123456789" value="{{ old('phone') }}">
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Date of Birth --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Tanggal Lahir</span>
                <input type="date" name="dob"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700"
                    value="{{ old('dob') }}">
                @error('dob')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Terms --}}
            <p class="text-center text-gray-600 text-sm mt-1 mb-5">
                Dengan melanjutkan, Anda menyetujui<br>
                <button type="button" onclick="openModal('termsModal')" class="text-[#33E4DB] font-semibold underline">
                    Syarat Penggunaan
                </button>
                dan
                <button type="button" onclick="openModal('privacyModal')" class="text-[#33E4DB] font-semibold underline">
                    Kebijakan Privasi
                </button>.
            </p>

            {{-- Submit Button --}}
            <button type="submit"
                class="w-full mt-2 py-3 rounded-full bg-[#33E4DB] text-white text-lg font-semibold">
                Daftar
            </button>

        </form>

        {{-- Login Link --}}
        <p class="text-center text-gray-600 mt-6 mb-10">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="text-[#33E4DB] font-semibold">Masuk</a>
        </p>

    </div>

    <!-- ============================= -->
    <!-- MODAL: Terms of Use -->
    <!-- ============================= -->
    <div id="termsModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50">
        <div class="bg-white rounded-2xl p-6 w-11/12 max-w-2xl max-h-[85vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4 text-[#33E4DB]">Syarat Penggunaan</h2>

            <div class="text-gray-700 space-y-4">

                <p>
                    Syarat Penggunaan ini mengatur akses dan penggunaan aplikasi serta layanan kami. Dengan membuat akun atau 
                    terus menggunakan platform ini, Anda menyetujui semua ketentuan yang tercantum di sini.
                </p>

                <h3 class="text-xl font-semibold">1. Penerimaan Syarat</h3>
                <p>
                    Dengan mendaftar, Anda mengakui bahwa telah membaca dan memahami syarat ini. Perubahan di masa depan 
                    dapat dilakukan tanpa pemberitahuan sebelumnya, dan penggunaan berkelanjutan menandakan persetujuan Anda.
                </p>

                <h3 class="text-xl font-semibold">2. Tanggung Jawab Pengguna</h3>
                <ul class="list-disc ml-6">
                    <li>Memberikan informasi yang akurat dan benar.</li>
                    <li>Menjaga keamanan akun Anda.</li>
                    <li>Tidak menyalahgunakan atau mencoba mengganggu layanan.</li>
                </ul>

                <h3 class="text-xl font-semibold">3. Aktivitas yang Dilarang</h3>
                <ul class="list-disc ml-6">
                    <li>Meretas atau mencoba melewati fitur keamanan.</li>
                    <li>Unggah konten yang mengandung perangkat lunak berbahaya.</li>
                    <li>Meniru pengguna lain atau memberikan identitas palsu.</li>
                    <li>Menggunakan platform untuk tujuan ilegal atau merugikan.</li>
                </ul>

                <h3 class="text-xl font-semibold">4. Penghentian Akun</h3>
                <p>
                    Kami berhak menangguhkan atau menghapus akun yang melanggar syarat ini, dengan atau tanpa pemberitahuan.
                </p>

                <h3 class="text-xl font-semibold">5. Perubahan Syarat</h3>
                <p>
                    Platform dapat memperbarui syarat ini secara berkala. Penggunaan terus-menerus berarti Anda menyetujui 
                    perubahan tersebut.
                </p>

            </div>

            <button onclick="closeModal('termsModal')"
                class="mt-6 w-full bg-[#33E4DB] text-white py-2 rounded-xl font-semibold">
                Tutup
            </button>
        </div>
    </div>

    <!-- ============================= -->
    <!-- MODAL: Privacy Policy -->
    <!-- ============================= -->
    <div id="privacyModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50">
        <div class="bg-white rounded-2xl p-6 w-11/12 max-w-2xl max-h-[85vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4 text-[#33E4DB]">Kebijakan Privasi</h2>

            <div class="text-gray-700 space-y-4">

                <p>
                    Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda. 
                    Menggunakan layanan kami berarti Anda setuju dengan praktik data yang dijelaskan di sini.
                </p>

                <h3 class="text-xl font-semibold">1. Informasi yang Kami Kumpulkan</h3>
                <ul class="list-disc ml-6">
                    <li>Nama, email, nomor telepon, tanggal lahir.</li>
                    <li>Data login seperti alamat IP dan informasi perangkat.</li>
                    <li>Data penggunaan untuk analitik dan peningkatan layanan.</li>
                </ul>

                <h3 class="text-xl font-semibold">2. Penggunaan Data</h3>
                <ul class="list-disc ml-6">
                    <li>Membuat dan mengelola akun Anda.</li>
                    <li>Meningkatkan fungsionalitas dan performa aplikasi.</li>
                    <li>Menyempurnakan pengalaman pengguna dan dukungan.</li>
                </ul>

                <h3 class="text-xl font-semibold">3. Perlindungan Data</h3>
                <p>
                    Kami menggunakan sistem keamanan standar industri, namun tidak ada platform digital yang 100% aman. 
                    Pengguna dianjurkan menjaga kerahasiaan akun mereka.
                </p>

                <h3 class="text-xl font-semibold">4. Berbagi Informasi</h3>
                <p>
                    Kami tidak menjual atau menyewakan data Anda. Informasi hanya dibagikan dengan pihak ketiga terpercaya 
                    yang diperlukan untuk operasional aplikasi.
                </p>

                <h3 class="text-xl font-semibold">5. Hak Anda</h3>
                <ul class="list-disc ml-6">
                    <li>Meminta penghapusan data pribadi Anda.</li>
                    <li>Memperbarui atau mengoreksi informasi Anda.</li>
                    <li>Menarik persetujuan untuk pemrosesan data.</li>
                </ul>

                <h3 class="text-xl font-semibold">6. Pembaruan Kebijakan</h3>
                <p>
                    Kebijakan ini dapat diperbarui secara berkala. Penggunaan terus-menerus menandakan persetujuan terhadap kebijakan terbaru.
                </p>

            </div>

            <button onclick="closeModal('privacyModal')"
                class="mt-6 w-full bg-[#33E4DB] text-white py-2 rounded-xl font-semibold">
                Tutup
            </button>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

</body>

</html>
