{{-- HEADER --}}
    @extends('layouts.app')

{{-- CONTENIDO --}}
    @section('content')
        <section class="py-16 text-center">
            <h1 class="text-4xl font-bold text-[#7705B6] mb-6">Tu puente entre el aula y el mundo laboral</h1>
            
            <!-- BLOQUE DE ESTUDIANTES -->
                <div class="container mx-auto flex flex-col md:flex-row items-center my-12 px-4">
                    <div class="md:w-1/2 mb-8 md:mb-0">
                        <img src="{{ asset('images/estudiantes.jpg') }}" alt="Estudiantes" class="rounded-lg shadow-xl w-full max-w-md mx-auto">
                    </div>
                    <div class="md:w-1/2 space-y-6 text-left md:pl-12">
                        <div class="text-2xl font-semibold text-[#7705B6]">🎓 {{ $totalAlumnos }} alumnos ya han encontrado prácticas</div>
                        <div class="text-lg">🧾 {{ $totalConvenios }} convenios gestionados</div>
                        <div class="text-lg">📍 Estudiantes de {{ $totalCentros }} centros educativos</div>
                        <div class="text-lg">📈 {{ $porcentajeExito }}% encuentran prácticas en su área</div>
                    </div>
                </div>
            
            <!-- BLOQUE DE EMPRESAS -->
                <div class="container mx-auto flex flex-col md:flex-row-reverse items-center my-12 px-4">
                    <div class="md:w-1/2 mb-8 md:mb-0">
                        <img src="{{ asset('images/empresas.jpg') }}" alt="Empresas" class="rounded-lg shadow-xl w-full max-w-md mx-auto">
                    </div>
                    <div class="md:w-1/2 space-y-6 text-left md:pr-12">
                        <div class="text-2xl font-semibold text-[#7705B6]">🏢 {{ $totalEmpresas }} empresas confían en nosotros</div>
                        <div class="text-lg">💼 {{ $totalOfertas }} ofertas publicadas</div>
                        <div class="text-lg">🤝 {{ $porcentajeRepiten }}% de empresas repiten</div>
                        <div class="text-lg">🌍 Presencia en {{ $totalProvincias }} provincias</div>
                    </div>
                </div>
            
            <!-- EMPRESAS QUE CONFIAN -->
                <section class="my-16">
                    <h2 class="text-3xl font-bold text-[#7705B6] mb-8">Empresas que confían en nosotros</h2>
                    
                    <div class="container mx-auto px-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($empresasDestacadas as $empresa)
                                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                                    @if($empresa->logo)
                                        <img src="{{ asset('storage/'.$empresa->logo) }}" alt="{{ $empresa->nombre }}" class="h-16 mx-auto mb-4">
                                    @else
                                        <div class="h-16 mx-auto mb-4 flex items-center justify-center bg-gray-200 text-gray-500 rounded">
                                            {{ substr($empresa->nombre, 0, 2) }}
                                        </div>
                                    @endif
                                    <h3 class="font-bold text-lg">{{ $empresa->nombre }}</h3>
                                    <p class="text-gray-600">{{ $empresa->alumnos_contratados }} alumnos contratados</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            
            <!-- CTA FINAL -->
                <section class="my-16 text-center">
                    <h2 class="text-3xl font-bold text-[#7705B6] mb-8">Échale un vistazo</h2>
                    <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-8">
                        <a href="{{ route('register.alumno') }}" class="bg-[#7705B6] text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-[#5E0490] transition mx-auto md:mx-0">
                            SOY ALUMNO
                        </a>
                        <a href="{{ route('register.empresa') }}" class="bg-[#7705B6] text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-[#5E0490] transition mx-auto md:mx-0">
                            SOY EMPRESA
                        </a>
                    </div>
                </section>
        </section>
    @endsection