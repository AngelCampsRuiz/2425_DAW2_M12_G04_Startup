<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenio de Prácticas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 10px;
        }
        .title {
            color: #6366f1;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin-top: 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            color: #6366f1;
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .info-group {
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
        }
        .info-value {
            margin-left: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #e5e7eb;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            color: #4b5563;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            font-size: 12px;
            color: #6b7280;
        }
        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            width: 45%;
            margin-top: 50px;
            border-top: 1px solid #000;
            padding-top: 10px;
            text-align: center;
        }
        .qr-code {
            text-align: center;
            margin-top: 30px;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
        }
        .status.active {
            background-color: #dcfce7;
            color: #166534;
        }
        .status.pending {
            background-color: #fff7ed;
            color: #c2410c;
        }
        .status.finished {
            background-color: #f1f5f9;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">CONVENIO DE PRÁCTICAS</h1>
        <p class="subtitle">Documento oficial para registro de prácticas formativas en empresa</p>
    </div>

    <div class="section">
        <h2 class="section-title">INFORMACIÓN GENERAL</h2>
        <div class="info-group">
            <span class="info-label">Número de Convenio:</span>
            <span class="info-value">{{ $convenio->id }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Fecha de Creación:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($convenio->fecha_creacion)->format('d/m/Y') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Estado:</span>
            <span class="status {{ $convenio->estado == 'activo' ? 'active' : ($convenio->estado == 'pendiente' ? 'pending' : 'finished') }}">
                {{ ucfirst($convenio->estado) }}
            </span>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">DATOS DE LA EMPRESA</h2>
        <div class="info-group">
            <span class="info-label">Nombre de la Empresa:</span>
            <span class="info-value">{{ $convenio->oferta->empresa->nombre ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">CIF/NIF:</span>
            <span class="info-value">{{ $convenio->oferta->empresa->cif ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Dirección:</span>
            <span class="info-value">{{ $convenio->oferta->empresa->direccion ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Tutor de Empresa:</span>
            <span class="info-value">{{ $convenio->tutor_empresa }}</span>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">DATOS DEL ESTUDIANTE</h2>
        <div class="info-group">
            <span class="info-label">Nombre Completo:</span>
            <span class="info-value">{{ $convenio->estudiante->nombre }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">DNI/NIE:</span>
            <span class="info-value">{{ $convenio->estudiante->dni ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Correo Electrónico:</span>
            <span class="info-value">{{ $convenio->estudiante->email }}</span>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">DETALLES DE LA OFERTA</h2>
        <div class="info-group">
            <span class="info-label">Título de la Oferta:</span>
            <span class="info-value">{{ $convenio->oferta->titulo }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Categoría:</span>
            <span class="info-value">{{ $convenio->oferta->categoria->nombre_categoria ?? 'Sin categoría' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Horas Totales:</span>
            <span class="info-value">{{ $convenio->oferta->horas_totales }} horas</span>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">PERIODO DE PRÁCTICAS</h2>
        <div class="info-group">
            <span class="info-label">Fecha de Inicio:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Fecha de Finalización:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Horario:</span>
            <span class="info-value">{{ $convenio->horario_practica }}</span>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">TAREAS Y OBJETIVOS</h2>
        <div class="info-group">
            <span class="info-label">Descripción de Tareas:</span>
            <p class="info-value">{{ $convenio->tareas }}</p>
        </div>
        <div class="info-group">
            <span class="info-label">Objetivos Formativos:</span>
            <p class="info-value">{{ $convenio->objetivos }}</p>
        </div>
    </div>

    <div class="signatures">
        <div class="signature">
            <p>Firma del Tutor de Empresa</p>
            <p>{{ $convenio->tutor_empresa }}</p>
        </div>
        <div class="signature">
            <p>Firma del Estudiante</p>
            <p>{{ $convenio->estudiante->nombre }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Este documento es un convenio oficial de prácticas formativas en empresa. Generado automáticamente el {{ date('d/m/Y') }}.</p>
        <p>Documento verificable mediante código QR. La manipulación de este documento está sujeta a responsabilidades legales.</p>
    </div>
</body>
</html> 