@forelse ($empresas as $empresa)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <!-- Logo de la empresa -->
                @if($empresa->user->imagen)
                    <div class="flex-shrink-0 h-10 w-10 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" 
                             src="{{ asset('profile_images/' . $empresa->user->imagen) }}" 
                             alt="Logo de {{ $empresa->user->nombre }}"
                             onerror="this.onerror=null; this.src='{{ asset('img/default-logo.png') }}';">
                    </div>
                @else
                    <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-purple-800 font-medium">{{ substr($empresa->user->nombre, 0, 2) }}</span>
                    </div>
                @endif
                <div>
                    <div class="text-sm font-medium text-gray-900">{{ $empresa->nombre_comercial ?? $empresa->user->nombre }}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-500">{{ $empresa->user->email }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-500">{{ $empresa->cif }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-500">{{ $empresa->user->ciudad ?: 'No especificado' }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-500">{{ $empresa->user->telefono }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $empresa->user->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $empresa->user->activo ? 'Activa' : 'Inactiva' }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
            <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $empresa->id }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>
            <button class="btn-activar {{ $empresa->user->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" 
                    data-id="{{ $empresa->id }}" 
                    data-active="{{ $empresa->user->activo ? '1' : '0' }}">
                @if($empresa->user->activo)
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
            No hay empresas para mostrar
        </td>
    </tr>
@endforelse 