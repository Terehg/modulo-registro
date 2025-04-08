@extends('layouts.app')

@section('content')
<div class="fade-in">
    <div class="page-header">
        <h2><i class="fas fa-clipboard-list me-2"></i>Gestión de Registros de Producción</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRegistroModal">
            <i class="fas fa-plus me-1"></i> Nuevo Registro
        </button>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-2"></i>Filtros
        </div>
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4">
                    <label for="filter_turno" class="form-label">Filtrar por Turno</label>
                    <select class="form-select" id="filter_turno">
                        <option value="">Todos los turnos</option>
                        <!-- Las opciones se cargarán dinámicamente -->
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="button" id="applyFilterBtn" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i> Filtrar
                    </button>
                    <button type="button" id="clearFilterBtn" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Limpiar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="registrosTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Máquina</th>
                            <th>Proyecto</th>
                            <th>Turno</th>
                            <th>Fecha Creación</th>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargarán dinámicamente con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear Registro -->
<div class="modal fade" id="createRegistroModal" tabindex="-1" aria-labelledby="createRegistroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRegistroModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Registro
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createRegistroForm">
                    <div class="mb-3">
                        <label for="maquina" class="form-label">Máquina</label>
                        <input type="text" class="form-control" id="maquina" name="maquina" placeholder="Ej: Máquina 001" required>
                        <div class="invalid-feedback" id="maquinaError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="proyecto" class="form-label">Proyecto</label>
                        <input type="text" class="form-control" id="proyecto" name="proyecto" placeholder="Ej: Proyecto A" required>
                        <div class="invalid-feedback" id="proyectoError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="turno_id" class="form-label">Turno</label>
                        <select class="form-select" id="turno_id" name="turno_id" required>
                            <option value="">Seleccione un turno</option>
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                        <div class="invalid-feedback" id="turnoError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="saveRegistroBtn">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@vite(['resources/js/registros.js'])
@endsection