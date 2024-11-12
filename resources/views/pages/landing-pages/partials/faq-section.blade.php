<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="mb-16 text-center">
        <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl">
            Frequently Asked Questions
        </h2>
        <p class="text-lg text-gray-600">
            Temukan jawaban untuk pertanyaan yang sering diajukan tentang aplikasi kami
        </p>
    </div>

    <!-- FAQ Accordion -->
    <div class="space-y-4">
        <!-- FAQ Item 1 -->
        <div x-data="{ open: false }" class="rounded-lg border border-gray-200 bg-white">
            <button @click="open = !open" class="flex w-full items-center justify-between px-4 py-5 text-left sm:p-6">
                <span class="text-lg font-semibold text-gray-900">
                    Bagaimana cara menggunakan fitur deteksi penyakit?
                </span>
                <span class="ml-6 flex-shrink-0">
                    <svg class="h-6 w-6 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>
            <div x-show="open" x-collapse class="px-4 pb-5 sm:px-6 sm:pb-6">
                <p class="text-gray-600">
                    Untuk menggunakan fitur deteksi penyakit, cukup buka aplikasi dan pilih menu
                    "Deteksi". Kemudian, ambil foto daun tomat yang ingin Anda periksa atau pilih
                    foto dari galeri. Sistem kami akan secara otomatis menganalisis gambar dan
                    memberikan hasil diagnosis dalam hitungan detik.
                </p>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div x-data="{ open: false }" class="rounded-lg border border-gray-200 bg-white">
            <button @click="open = !open" class="flex w-full items-center justify-between px-4 py-5 text-left sm:p-6">
                <span class="text-lg font-semibold text-gray-900">
                    Apakah hasil deteksi penyakit akurat?
                </span>
                <span class="ml-6 flex-shrink-0">
                    <svg class="h-6 w-6 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>
            <div x-show="open" x-collapse class="px-4 pb-5 sm:px-6 sm:pb-6">
                <p class="text-gray-600">
                    Ya, sistem kami menggunakan teknologi YOLOv7 yang telah dilatih dengan ribuan
                    gambar penyakit daun tomat. Tingkat akurasi deteksi kami mencapai lebih dari
                    90%. Namun, untuk hasil terbaik, pastikan foto yang Anda ambil memiliki
                    pencahayaan yang baik dan fokus pada area daun yang terinfeksi.
                </p>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div x-data="{ open: false }" class="rounded-lg border border-gray-200 bg-white">
            <button @click="open = !open" class="flex w-full items-center justify-between px-4 py-5 text-left sm:p-6">
                <span class="text-lg font-semibold text-gray-900">
                    Bagaimana cara membeli obat di marketplace?
                </span>
                <span class="ml-6 flex-shrink-0">
                    <svg class="h-6 w-6 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>
            <div x-show="open" x-collapse class="px-4 pb-5 sm:px-6 sm:pb-6">
                <p class="text-gray-600">
                    Setelah mendapatkan hasil diagnosis, Anda akan melihat rekomendasi obat yang
                    sesuai. Klik pada obat yang ingin dibeli, pilih penjual yang Anda inginkan,
                    masukkan jumlah yang dibutuhkan, dan lakukan pembayaran melalui metode yang
                    tersedia. Obat akan dikirim langsung ke alamat Anda.
                </p>
            </div>
        </div>

        <!-- FAQ Item 4 -->
        <div x-data="{ open: false }" class="rounded-lg border border-gray-200 bg-white">
            <button @click="open = !open" class="flex w-full items-center justify-between px-4 py-5 text-left sm:p-6">
                <span class="text-lg font-semibold text-gray-900">
                    Apakah riwayat diagnosis tersimpan secara permanen?
                </span>
                <span class="ml-6 flex-shrink-0">
                    <svg class="h-6 w-6 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>
            <div x-show="open" x-collapse class="px-4 pb-5 sm:px-6 sm:pb-6">
                <p class="text-gray-600">
                    Ya, semua riwayat diagnosis akan tersimpan di akun Anda selama Anda tidak
                    menghapusnya. Anda dapat mengakses riwayat ini kapan saja untuk melacak
                    perkembangan kesehatan tanaman Anda atau membandingkan hasil diagnosis dari
                    waktu ke waktu.
                </p>
            </div>
        </div>
    </div>
</div>
