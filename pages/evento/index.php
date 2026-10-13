<?php
// Obtener el ID del evento desde el parámetro GET
$evento_id = isset($_GET['evento_id']) ? $_GET['evento_id'] : null;

// Ejemplo de arrays (reemplázalos con tu consulta a base de datos)
$ejemplares = [
    ['id' => 1, 'chip_codigo' => 'CH123', 'nombre' => 'Relámpago'],
    ['id' => 2, 'chip_codigo' => 'CH456', 'nombre' => 'Tormenta'],
];

$departamentos = [
    ['Departamento' => 'Antioquia'],
    ['Departamento' => 'Cundinamarca'],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción a Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h4>Formulario de Inscripción al Evento #<?= $evento_id ?></h4>

    <div class="row mb-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Ejemplar</label>
            <select class="form-control" id="id_ejemplar" style="width: 100% !important">
                <option selected>Seleccione</option>
                <?php foreach ($ejemplares as $value) {
                    echo "<option value='".$value['id']."' >".strtoupper($value['chip_codigo'].' - '.$value['nombre'])."</option>";
                } ?>
            </select>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Procedencia</label>
            <select class="form-control" id="procedencia" style="width: 100% !important">
                <option selected>Seleccione</option>
                <option>Criadero</option>
                <option>Pesebrera</option>
                <option>Finca</option>
                <option>Otro</option>
            </select>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Departamento</label>
            <select class="form-control" id="departamento" onchange="buscarMunicipios(this.value)" style="width: 100% !important">
                <option selected>Seleccione</option>
                <?php foreach ($departamentos as $value) {
                    echo "<option>".$value['Departamento']."</option>";
                } ?>
            </select>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Municipio</label>
            <select class="form-control" id="municipio" style="width: 100% !important"></select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Montador</label>
            <select class="form-control" id="montador">
                <option>Chalan</option>
                <option>Amazona</option>
            </select>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Nombre Montador</label>
            <input type="text" class="form-control" id="nombre_montador">
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Correo Electrónico Montador</label>
            <input type="email" class="form-control" id="correo_montador">
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <label style="float:left !important;">Celular Montador</label>
            <input type="tel" class="form-control" id="celular_montador">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-sm-6 col-lg-4">
            <label style="float:left !important;">Nombre Palafrenero</label>
            <input type="text" class="form-control" id="nombre_palafrenero">
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <label style="float:left !important;">Celular Palafrenero</label>
            <input type="number" class="form-control" id="celular_palafrenero">
        </div>

        <div class="col-12 col-lg-2 d-flex align-items-end">
            <button type="button" class="btn btn-primary w-100" onclick="guardarDetalle(<?= $evento_id ?>)">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function buscarMunicipios(departamento) {
    // Simular carga de municipios
    let municipioSelect = document.getElementById('municipio');
    municipioSelect.innerHTML = '<option>Municipio 1</option><option>Municipio 2</option>';
}

function guardarDetalle(eventoId) {
    const ejemplar = document.getElementById('id_ejemplar').value;
    const procedencia = document.getElementById('procedencia').value;
    const montador = document.getElementById('montador').value;

    alert("Guardando inscripción para evento ID: " + eventoId + "\nEjemplar: " + ejemplar + "\nProcedencia: " + procedencia + "\nMontador: " + montador);
    // Aquí harías el envío por AJAX o submit
}
</script>

</body>
</html>
