@extends('layouts.app')

@section('content')
<div class="fade-in">
    <div class="page-header">
        <h2><i class="fas fa-clock me-2"></i>Gestión de Turnos</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTurnoModal">
            <i class="fas fa-plus me-1"></i> Nuevo Turno
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="turnosTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
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

<!-- Modal para Crear Turno -->
<div class="modal fade" id="createTurnoModal" tabindex="-1" aria-labelledby="createTurnoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTurnoModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Turno
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createTurnoForm">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Turno</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Turno Mañana" required>
                        <div class="invalid-feedback" id="nombreError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="saveTurnoBtn">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Turno -->
<div class="modal fade" id="editTurnoModal" tabindex="-1" aria-labelledby="editTurnoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTurnoModalLabel">
                    <i class="fas fa-edit me-2"></i>Editar Turno
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTurnoForm">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre del Turno</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        <div class="invalid-feedback" id="editNombreError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="updateTurnoBtn">
                    <i class="fas fa-save me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@vite(['resources/js/turnos.js'])
@endsection