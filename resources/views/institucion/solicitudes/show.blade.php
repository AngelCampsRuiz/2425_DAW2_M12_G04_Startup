@extends('layouts.institucion')

@section('title', 'Detalle de Solicitud')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detalle de Solicitud</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('institucion.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('institucion.solicitudes.index') }}">Solicitudes</a></li>
        <li class="breadcrumb-item active">Detalle</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Estado de la solicitud y acciones -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-info-circle me-1"></i> Estado de la Solicitud</span>
                    <div>
                        @if($solicitud->estado == 'pendiente')
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @elseif($solicitud->estado == 'aprobada')
                            <span class="badge bg-success">Aprobada</span>
                        @elseif($solicitud->estado == 'rechazada')
                            <span class="badge bg-danger">Rechazada</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-0"><strong>Fecha de solicitud:</strong></p>
                            <p>{{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0"><strong>Fecha de respuesta:</strong></p>
                            <p>{{ $solicitud->fecha_respuesta ? $solicitud->fecha_respuesta->format('d/m/Y H:i') : 'Pendiente' }}</p>
                        </div>
                    </div>

                    @if($solicitud->clase)
                    <div class="alert alert-info">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Clase asignada</h5>
                                <p class="mb-0">El estudiante ha sido asignado a la clase <strong>{{ $solicitud->clase->nombre }}</strong></p>
                            </div>
                        </div>
                    </div>
                    @elseif($solicitud->estado == 'aprobada')
                    <div class="alert alert-warning">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Pendiente de asignación</h5>
                                <p class="mb-0">Esta solicitud ha sido aprobada pero aún no se ha asignado una clase al estudiante.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($solicitud->mensaje_rechazo && $solicitud->estado == 'rechazada')
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Motivo del rechazo</h5>
                                <p class="mb-0">{{ $solicitud->mensaje_rechazo }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex mt-4">
                        @if($solicitud->estado == 'pendiente')
                            <form action="{{ route('institucion.solicitudes.aprobar', $solicitud->id) }}" method="POST" class="me-2">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-1"></i> Aprobar Solicitud
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rechazarModal">
                                <i class="fas fa-times me-1"></i> Rechazar Solicitud
                            </button>
                        @elseif($solicitud->estado == 'aprobada' && !$solicitud->clase_asignada)
                            <a href="{{ route('institucion.solicitudes.asignar-clase', $solicitud->id) }}" class="btn btn-primary">
                                <i class="fas fa-user-graduate me-1"></i> Asignar a Clase
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-1"></i> Resumen
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($solicitud->estudiante->user->nombre) }}&background=7705B6&color=fff" class="rounded-circle img-fluid" style="width: 100px;" alt="{{ $solicitud->estudiante->user->nombre }}">
                        <h5 class="mt-3 mb-0">{{ $solicitud->estudiante->user->nombre }}</h5>
                        <p class="text-muted">{{ $solicitud->estudiante->user->email }}</p>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-id-card me-2"></i> ID de Solicitud</span>
                            <span class="badge bg-primary rounded-pill">{{ $solicitud->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-phone me-2"></i> Teléfono</span>
                            <span>{{ $solicitud->estudiante->telefono ?: 'No proporcionado' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-birthday-cake me-2"></i> Edad</span>
                            <span>{{ $solicitud->estudiante->edad ?: 'No proporcionada' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i> Detalles de la Solicitud
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Información Personal</h5>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre completo</label>
                                <p>{{ $solicitud->estudiante->user->nombre }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <p>{{ $solicitud->estudiante->user->email }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Teléfono</label>
                                <p>{{ $solicitud->estudiante->telefono ?: 'No proporcionado' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Edad</label>
                                <p>{{ $solicitud->estudiante->edad ?: 'No proporcionada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Detalles Adicionales</h5>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mensaje del estudiante</label>
                                <p class="p-3 bg-light rounded">{{ $solicitud->mensaje ?: 'El estudiante no ha dejado ningún mensaje.' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Conocimientos previos</label>
                                <p>{{ $solicitud->estudiante->conocimientos_previos ?: 'No especificados' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intereses</label>
                                <p>{{ $solicitud->estudiante->intereses ?: 'No especificados' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para rechazar solicitud -->
<div class="modal fade" id="rechazarModal" tabindex="-1" aria-labelledby="rechazarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rechazarModalLabel">Rechazar Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('institucion.solicitudes.rechazar', $solicitud->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mensaje_rechazo" class="form-label">Motivo del rechazo</label>
                        <textarea class="form-control" id="mensaje_rechazo" name="mensaje_rechazo" rows="3" placeholder="Explique el motivo por el que se rechaza esta solicitud..." required></textarea>
                        <div class="form-text">Este mensaje será visible para el estudiante.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Rechazar Solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 