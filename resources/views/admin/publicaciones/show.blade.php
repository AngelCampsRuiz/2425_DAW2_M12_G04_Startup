@extends('admin.dashboard')

@section('admin_content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-6">Detalles de la Publicación</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Título</h3>
                <p class="text-base">{{ $publicacion->titulo }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Empresa</h3>
                <p class="text-base">{{ $publicacion->empresa->nombre ?? 'N/A' }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Categoría</h3>
                <p class="text-base">{{ $publicacion->categoria->nombre_categoria ?? 'N/A' }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Subcategoría</h3>
                <p class="text-base">{{ $publicacion->subcategoria->nombre_subcategoria ?? 'N/A' }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Horario</h3>
                <p class="text-base capitalize">{{ $publicacion->horario }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Horas Totales</h3>
                <p class="text-base">{{ $publicacion->horas_totales }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Fecha de Publicación</h3>
                <p class="text-base">{{ date('d/m/Y', strtotime($publicacion->fecha_publicacion)) }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Estado</h3>
                <p class="text-base">
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $publicacion->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $publicacion->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Descripción</h3>
            <div class="p-4 bg-gray-50 rounded-md">
                <p class="text-base whitespace-pre-line">{{ $publicacion->descripcion }}</p>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.publicaciones.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                Volver
            </a>
            <a href="{{ route('admin.publicaciones.edit', $publicacion) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Editar
            </a>
        </div>
    </div>
@endsection 