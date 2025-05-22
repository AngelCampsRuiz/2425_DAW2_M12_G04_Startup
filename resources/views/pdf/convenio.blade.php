<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenio de Prácticas</title>
    @php
        use App\Models\User;
    @endphp
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body {
            font-family: 'Nunito', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #6366f1;
            position: relative;
        }
        
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            max-width: 100px;
            height: auto;
        }
        
        .document-type {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 12px;
            color: #6366f1;
            border: 1px solid #6366f1;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            background-color: rgba(99, 102, 241, 0.05);
        }
        
        .title {
            color: #6366f1;
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-top: 0;
        }
        
        .section {
            margin-bottom: 25px;
            padding: 15px 20px;
            border-radius: 6px;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
        }
        
        .section-title {
            color: #6366f1;
            font-size: 16px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
            font-weight: bold;
        }
        
        .info-group {
            margin-bottom: 12px;
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
        }
        
        .info-label {
            font-weight: bold;
            color: #4b5563;
            min-width: 180px;
            margin-right: 10px;
        }
        
        .info-value {
            color: #111827;
            flex: 1;
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
        
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .signature {
            width: 45%;
            margin-top: 30px;
            border-top: 1px solid #000;
            padding-top: 10px;
            text-align: center;
            font-size: 12px;
        }
        
        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }
        
        .signature-role {
            color: #6b7280;
            font-size: 10px;
        }
        
        .signature-date {
            font-size: 10px;
            color: #6b7280;
            margin-top: 5px;
        }
        
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
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
        
        .document-info {
            font-size: 10px;
            text-align: right;
            color: #6b7280;
            margin-bottom: 20px;
        }
        
        .section-description {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 15px;
            padding-left: 10px;
            border-left: 3px solid #6366f1;
        }
        
        .clause {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 4px;
        }
        
        .clause-title {
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .page-number {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 10px;
            color: #9ca3af;
        }
        
        .important-note {
            background-color: #f9fafb;
            border-left: 3px solid #6366f1;
            padding: 10px;
            font-size: 12px;
            color: #4b5563;
            margin: 15px 0;
        }
        
        ol {
            padding-left: 20px;
        }
        
        ol li {
            margin-bottom: 8px;
            font-size: 12px;
        }
        
        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .table-info, .table-info th, .table-info td {
            border: 1px solid #e5e7eb;
        }
        
        .table-info th {
            background-color: #6366f1;
            color: white;
            font-weight: normal;
            font-size: 12px;
            text-align: left;
            padding: 8px;
        }
        
        .table-info td {
            padding: 8px;
            font-size: 12px;
        }
        
        .table-info tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .signature-section {
            width: 100%;
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="document-info">
        Ref: CONV-{{ $convenio->id }}<br>
        Fecha: {{ date('d/m/Y') }}
    </div>

    <div class="header">
        <div class="document-type">CONVENIO</div>
        <h1 class="title">Convenio de Prácticas</h1>
        <p class="subtitle">Acuerdo de colaboración para la realización de prácticas formativas</p>
    </div>

    <div class="section">
        <h2 class="section-title">1. INFORMACIÓN GENERAL</h2>
        <p class="section-description">
            Datos generales del convenio de prácticas
        </p>
        <div class="info-group">
            <span class="info-label">Número de Convenio:</span>
            <span class="info-value">{{ $convenio->id }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Fecha de Formalización:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($convenio->fecha_creacion)->format('d/m/Y') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Estado Actual:</span>
            <span class="status {{ $convenio->estado == 'activo' ? 'active' : ($convenio->estado == 'pendiente' ? 'pending' : 'finished') }}">
                {{ ucfirst($convenio->estado) }}
            </span>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">2. DATOS DE LA EMPRESA</h2>
        <p class="section-description">
            Información de la empresa colaboradora
        </p>
        <div class="info-group">
            <span class="info-label">Nombre de la Empresa:</span>
            <span class="info-value">{{ $convenio->oferta->empresa->nombre ?? ($convenio->empresa_id ? User::find($convenio->empresa_id)->nombre : 'N/A') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">CIF/NIF:</span>
            <span class="info-value">{{ $convenio->oferta->empresa->cif ?? ($convenio->empresa_id ? User::find($convenio->empresa_id)->cif : 'N/A') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Dirección:</span>
            <span class="info-value">{{ $convenio->oferta->empresa->direccion ?? ($convenio->empresa_id ? User::find($convenio->empresa_id)->direccion : 'N/A') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Categoría:</span>
            <span class="info-value">{{ $convenio->oferta->categoria->nombre_categoria ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Tutor de Empresa:</span>
            <span class="info-value">{{ $convenio->tutor_empresa }}</span>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">3. DATOS DEL ESTUDIANTE</h2>
        <p class="section-description">
            Información del estudiante en prácticas
        </p>
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
        <div class="info-group">
            <span class="info-label">Teléfono:</span>
            <span class="info-value">{{ $convenio->estudiante->telefono ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Domicilio:</span>
            <span class="info-value">{{ $convenio->estudiante->direccion ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">4. DETALLES DE LA OFERTA</h2>
        <p class="section-description">
            Características de la oferta formativa
        </p>
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
        <div class="info-group">
            <span class="info-label">Descripción:</span>
            <span class="info-value">{{ $convenio->oferta->descripcion ?? 'No especificada' }}</span>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">5. PERIODO DE PRÁCTICAS</h2>
        <p class="section-description">
            Duración y horarios de las prácticas
        </p>
        <table class="table-info">
            <tr>
                <th>Concepto</th>
                <th>Detalle</th>
            </tr>
            <tr>
                <td>Fecha de Inicio</td>
                <td>{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Fecha de Finalización</td>
                <td>{{ \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Duración</td>
                <td>{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->diffInDays(\Carbon\Carbon::parse($convenio->fecha_fin)) + 1 }} días</td>
            </tr>
            <tr>
                <td>Horario</td>
                <td>{{ ucfirst($convenio->horario_practica) }}</td>
            </tr>
            <tr>
                <td>Días</td>
                <td>De lunes a viernes</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">6. PROGRAMA FORMATIVO</h2>
        <p class="section-description">
            Actividades a realizar durante las prácticas
        </p>
        
        <div class="clause">
            <div class="clause-title">Descripción de Tareas:</div>
            <p>{{ $convenio->tareas }}</p>
        </div>
        
        <div class="clause">
            <div class="clause-title">Objetivos Formativos:</div>
            <p>{{ $convenio->objetivos }}</p>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">7. CLÁUSULAS DEL CONVENIO</h2>
        <p class="section-description">
            Condiciones que regulan las prácticas
        </p>
        <ol>
            <li>Las prácticas no implican relación laboral entre la empresa y el estudiante.</li>
            <li>La empresa designará un tutor responsable del seguimiento de las prácticas.</li>
            <li>El estudiante debe cumplir con las normas de funcionamiento y seguridad de la empresa.</li>
            <li>Las prácticas podrán interrumpirse por motivo justificado por cualquiera de las partes.</li>
            <li>El estudiante se compromete a mantener la confidencialidad sobre la información a la que acceda.</li>
            <li>Este convenio se rige por la normativa vigente en materia de prácticas formativas.</li>
        </ol>
        
        <div class="important-note">
            IMPORTANTE: La empresa se compromete a proporcionar al estudiante los medios y recursos necesarios para el desarrollo adecuado de las prácticas formativas.
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">8. FIRMAS</h2>
        <p class="section-description">
            Conformidad de las partes
        </p>
        
        <div class="signature-section">
            <!-- Firmas de estudiante y empresa -->
            <div class="signature">
                <div class="signature-role">Firma del Estudiante</div>
                <div class="signature-name">{{ $convenio->estudiante->nombre }}</div>
                <div class="signature-date">Fecha: {{ $convenio->fecha_creacion ? $convenio->fecha_creacion->format('d/m/Y') : '' }}</div>
            </div>
            
            <div class="signature">
                <div class="signature-role">Firma de la Empresa</div>
                <div class="signature-name">{{ $convenio->oferta->empresa->nombre ?? ($convenio->empresa_id ? User::find($convenio->empresa_id)->nombre : 'Empresa') }}</div>
                <div class="signature-date">Fecha: {{ $convenio->fecha_creacion ? $convenio->fecha_creacion->format('d/m/Y') : '' }}</div>
            </div>
        </div>

        <div class="signature-section">
            <!-- Firma de la institución -->
            @if($convenio->firmado_institucion && $convenio->firmado_por_institucion)
                @php
                    $institucion = User::find($convenio->firmado_por_institucion);
                @endphp
                <div class="signature">
                    <div class="signature-role">Firma de la Institución</div>
                    <div class="signature-name">{{ $institucion ? $institucion->nombre : 'Institución' }}</div>
                    <div class="signature-date">Fecha de firma: {{ $convenio->fecha_firma_institucion ? $convenio->fecha_firma_institucion->format('d/m/Y') : '' }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <p>Este documento constituye un convenio oficial de prácticas formativas en empresa.</p>
        <p>Generado automáticamente el {{ date('d/m/Y') }} | © {{ date('Y') }}</p>
    </div>
    
    <div class="page-number">Página 1</div>
</body>
</html> 