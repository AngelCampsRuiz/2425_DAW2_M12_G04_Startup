@extends('layouts.app')

@section('content')
    {{-- SECCIÓN PRINCIPAL --}}
        <section class="py-16 text-center">
            <h1 class="text-4xl font-bold text-[#7705B6] mb-6">Tu puente entre el aula y el mundo laboral</h1>
            
            {{-- BLOQUE DE ESTUDIANTES --}}
                <div class="container mx-auto flex flex-col md:flex-row items-center my-12 px-4">
                    <div class="md:w-1/2 mb-8 md:mb-0">
                        {{-- IMAGEN ESTUDIANTES --}}
                            <img src="{{ asset('images/estudiantes.jpg') }}" alt="Estudiantes" class="rounded-lg shadow-xl w-full max-w-md mx-auto">
                    </div>
                    <div class="md:w-1/2 space-y-6 text-left md:pl-12">
                        <div class="text-2xl font-semibold text-[#7705B6]">🎓 +1.200 alumnos ya han encontrado prácticas</div>
                        <div class="text-lg">🧾 +800 convenios gestionados automáticamente</div>
                        <div class="text-lg">📍 Estudiantes de +50 centros educativos</div>
                        <div class="text-lg">📈 89% encuentran prácticas en su área</div>
                    </div>
                </div>
            
            {{-- BLOQUE DE EMPRESAS --}}
                <div class="container mx-auto flex flex-col md:flex-row-reverse items-center my-12 px-4">
                    <div class="md:w-1/2 mb-8 md:mb-0">
                        {{-- IMAGEN EMPRESAS --}}
                            <img src="{{ asset('images/empresas.jpg') }}" alt="Empresas" class="rounded-lg shadow-xl w-full max-w-md mx-auto">
                    </div>
                    <div class="md:w-1/2 space-y-6 text-left md:pr-12">
                        <div class="text-2xl font-semibold text-[#7705B6]">🏢 +300 empresas confían en nosotros</div>
                        <div class="text-lg">💼 +1.500 ofertas publicadas</div>
                        <div class="text-lg">🤝 75% de empresas repiten</div>
                        <div class="text-lg">🌍 Presencia en +20 provincias</div>
                    </div>
                </div>
            
            {{-- EMPRESAS QUE CONFÍAN EN NOSOTROS --}}
                <section class="my-16">
                    <h2 class="text-3xl font-bold text-[#7705B6] mb-8">Empresas que confían en nosotros</h2>
                    
                    {{-- SLIDER DE EMPRESAS --}}
                        <div class="container mx-auto px-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @for($i = 0; $i < 6; $i++)
                                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                                        <img src="{{ asset('images/empresa'.($i+1).'.jpg') }}" alt="Empresa" class="h-16 mx-auto mb-4">
                                        <h3 class="font-bold text-lg">Empresa {{ $i+1 }}</h3>
                                        <p class="text-gray-600">{{ rand(5, 50) }} alumnos contratados</p>
                                    </div>
                                @endfor
                            </div>
                        </div>
                </section>
            
            {{-- FINAL --}}
                <section class="my-16 text-center">
                    <h2 class="text-3xl font-bold text-[#7705B6] mb-8">Échale un vistazo</h2>
                    <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-8">
                        {{-- BOTON ALUMNO --}}
                            <a href="#" class="bg-[#7705B6] text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-[#5E0490] transition mx-auto md:mx-0">
                                SOY ALUMNO
                            </a>
                        {{-- BOTON EMPRESA --}}
                            <a href="#" class="bg-[#7705B6] text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-[#5E0490] transition mx-auto md:mx-0">
                                SOY EMPRESA
                            </a>
                    </div>
                </section>
        </section>
@endsection