{{-- HEADER --}}
    @extends('layouts.app')

{{-- CONTENIDO --}}
    @section('content')
        <section class="py-12 text-center bg-gradient-to-b from-purple-50 to-white">
            <h1 class="text-4xl font-bold text-[#7705B6] mb-4 leading-tight max-w-5xl mx-auto">{{ __('messages.bridge_between_school_and_work') }}</h1>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-12">{{ __('messages.connecting_students_with_best_companies') }}</p>

            <!-- BLOQUE DE ESTUDIANTES -->
                <div class="container mx-auto max-w-5xl flex flex-col md:flex-row items-center justify-center my-16 px-4 bg-white rounded-xl shadow-lg p-8 transform transition-transform hover:scale-[1.02]">
                    <div class="md:w-1/2 mb-8 md:mb-0 flex justify-center">
                        <img src="{{ asset('assets/images/estudiantes.jpg') }}" alt="Estudiantes" class="rounded-lg shadow-xl w-full max-w-md">
                    </div>
                    <div class="md:w-1/2 space-y-6 md:pl-12 flex flex-col justify-center text-left">
                        <div class="text-2xl font-semibold text-[#7705B6]">🎓 {{ $totalAlumnos }} {{ __('messages.students_have_found_practices') }}</div>
                        <div class="text-lg">🧾 {{ $totalConvenios }} {{ __('messages.contracts_managed') }}</div>
                        <div class="text-lg">📍 {{ $totalCentros }} {{ __('messages.students_from_educational_centers') }}</div>
                        <div class="text-lg">📈 {{ $porcentajeExito }}% {{ __('messages.students_find_practices_in_their_area') }}</div>
                    </div>
                </div>

            <!-- BLOQUE DE EMPRESAS -->
                <div class="container mx-auto max-w-5xl flex flex-col md:flex-row-reverse items-center justify-center my-16 px-4 bg-white rounded-xl shadow-lg p-8 transform transition-transform hover:scale-[1.02]">
                    <div class="md:w-1/2 mb-8 md:mb-0 flex justify-center">
                        <img src="{{ asset('assets/images/empresas.jpg') }}" alt="Empresas" class="rounded-lg shadow-xl w-full max-w-md">
                    </div>
                    <div class="md:w-1/2 space-y-6 md:pr-12 flex flex-col justify-center text-right">
                        <div class="text-2xl font-semibold text-[#7705B6]">🏢 {{ $totalEmpresas }} {{ __('messages.companies_trust_us') }}</div>
                        <div class="text-lg">💼 {{ $totalOfertas }} {{ __('messages.offers_published') }}</div>
                        <div class="text-lg">🤝 {{ $porcentajeRepiten }}% {{ __('messages.companies_repeat') }}</div>
                        <div class="text-lg">🌍 {{ __('messages.presence_in_provinces') }} {{ $totalProvincias }} {{ __('messages.general_provinces') }}</div>
                    </div>
                </div>

            <!-- EMPRESAS QUE CONFIAN -->
                <section class="my-16">
                    <h2 class="text-3xl font-bold text-[#7705B6] mb-4 relative inline-block">
                        {{ __('messages.companies_with_most_students_hired') }}
                        <span class="absolute bottom-0 left-0 w-full h-1 bg-[#9B30D9] rounded-full"></span>
                    </h2>
                    <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-10">{{ __('messages.companies_with_most_students_hired_description') }}</p>

                    <div class="container mx-auto max-w-5xl px-4">
                        @if($empresasDestacadas->isNotEmpty())
                            <!-- Slider principal -->
                            <div class="relative">
                                <!-- Contenedor principal del slider con clase personalizada -->
                                <div class="empresas-slider-container mb-6 w-full relative">
                                    <!-- Contenedor del slider -->
                                    <div class="swiper-container empresas-slider w-full overflow-hidden">
                                        <div class="swiper-wrapper">
                                            @foreach($empresasDestacadas->sortByDesc('alumnos_contratados') as $empresa)
                                                <div class="swiper-slide">
                                                    <div class="bg-white p-6 rounded-lg shadow-md text-center transform transition-all hover:shadow-xl hover:-translate-y-1 h-full flex flex-col justify-between">
                                                        <div class="relative">
                                                            @if($empresa->user->imagen)
                                                                <img src="{{ asset('public/profile_images/' . $empresa->user->imagen) }}" alt="{{ $empresa->user->nombre }}" class="h-16 mx-auto mb-4">
                                                            @else
                                                                <div class="h-16 mx-auto mb-4 flex items-center justify-center bg-gray-200 text-gray-500 rounded">
                                                                    {{ substr($empresa->user->nombre, 0, 2) }}
                                                                </div>
                                                            @endif
                                                            <!-- Badge para destacar el ranking -->
                                                            <div class="absolute -top-3 -right-3 bg-[#7705B6] text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg font-bold text-sm">
                                                                #{{ $loop->iteration }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-bold text-lg">{{ $empresa->user->nombre }}</h3>
                                                            <p class="text-gray-600 font-medium">
                                                                <span class="text-[#7705B6] font-bold">{{ $empresa->alumnos_contratados }}</span>
                                                                {{ $empresa->alumnos_contratados == 1 ? __('messages.student_hired') : __('messages.students_hired') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Paginación -->
                                    <div class="swiper-pagination mt-4 text-center"></div>

                                    <!-- Controles de navegación -->
                                    <div class="swiper-button-next text-[#7705B6] absolute top-1/2 -mt-6 right-0 z-10"></div>
                                    <div class="swiper-button-prev text-[#7705B6] absolute top-1/2 -mt-6 left-0 z-10"></div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-gray-500">
                                {{ __('messages.no_companies_highlighted') }}.
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Scripts para el slider -->
                @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Destruir cualquier instancia previa si existe
                        if (window.empresasSwiper) {
                            window.empresasSwiper.destroy(true, true);
                        }

                        // Usar la configuración más simple posible para garantizar funcionamiento
                        window.empresasSwiper = new Swiper('.empresas-slider', {
                            // Configuración básica
                            slidesPerView: 1,
                            spaceBetween: 20,
                            speed: 300,

                            // Navegación
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },

                            // Paginación simple
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                                type: 'bullets'
                            },

                            // Sin bucle infinito
                            loop: false,

                            // Puntos de ruptura para diseño responsive
                            breakpoints: {
                                640: {
                                    slidesPerView: 2,
                                    spaceBetween: 20,
                                },
                                1024: {
                                    slidesPerView: 3,
                                    spaceBetween: 20,
                                }
                            }
                        });
                    });
                </script>
                @endpush

            <!-- CTA FINAL - Solo visible para usuarios no autenticados -->
                @guest
                <section class="mb-0 text-center py-12 bg-gradient-to-r from-purple-100 to-purple-200 rounded-xl">
                    <h2 class="text-3xl font-bold text-[#7705B6] mb-8 relative inline-block">
                        {{ __('messages.take_a_look') }}
                        <span class="absolute bottom-0 left-0 w-full h-1 bg-[#9B30D9] rounded-full"></span>
                    </h2>
                    <p class="text-xl text-gray-700 max-w-3xl mx-auto mb-10">{{ __('messages.join_our_platform') }}</p>
                    <div class="container mx-auto max-w-5xl flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-8">
                        <a href="{{ route('demo.student') }}" class="bg-[#7705B6] text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-[#5E0490] transition mx-auto md:mx-0 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            {{ __('messages.i_am_a_student') }}
                        </a>
                        <a href="{{ route('demo.company') }}" class="bg-[#7705B6] text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-[#5E0490] transition mx-auto md:mx-0 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            {{ __('messages.i_am_a_company') }}
                        </a>
                    </div>
                </section>
                @endguest
        </section>
    @endsection
