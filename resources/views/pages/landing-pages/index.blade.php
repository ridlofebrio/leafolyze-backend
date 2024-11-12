@extends('layouts.root')
@section('head')
    <style>
        html {
            scroll-behavior: smooth;
        }

        .active {
            color: #417777;
        }
    </style>
@endsection
@section('body')
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full">
                @include('pages.landing-pages.partials.header')

                <main>
                    <section class="bg-white py-20" id="home">
                        @include('pages.landing-pages.partials.hero-section')
                    </section>
                    <section class="bg-gray-50 py-20" id="about">
                        @include('pages.landing-pages.partials.about-section')
                    </section>
                    <section class="bg-white py-20" id="features">
                        @include('pages.landing-pages.partials.features-section')
                    </section>
                    <section class="bg-gray-50 py-20" id="faq">
                        @include('pages.landing-pages.partials.faq-section')
                    </section>
                </main>

                @include('pages.landing-pages.partials.footer')
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');
            const navbar = document.getElementById('navbar');
            const navLinks = document.querySelectorAll('.nav-link');

            let lastScrollTop = 0;

            function updateActiveLink() {
                let scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

                navLinks.forEach(link => {
                    const section = document.querySelector(link.getAttribute('href'));
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;

                    if (scrollPosition >= (sectionTop - 180) && scrollPosition < (sectionTop - 180) +
                        sectionHeight) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            mobileMenuButton.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
            });

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop > 0) {
                    navbar.classList.add('shadow-lg');
                } else {
                    navbar.classList.remove('shadow-lg');
                }
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            });

            window.addEventListener('scroll', updateActiveLink);
        });
    </script>
@endpush
