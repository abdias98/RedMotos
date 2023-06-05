/**
 * Ocultar mensajes automáticamente
 **/
window.livewire.on('cerrar_alert', ()=>{
    setTimeout(function (){
        $('.alert').fadeTo(500,0).slideUp(400, function (){
            $('.alert').alert('close');
        });
    }, 2500);
});
/**
 * Mostrar contraseña en formulario crear usuario
 **/
window.livewire.on('mostrar_contraseña', () => {
    const password = document.getElementById("password");
    const password_confirm = document.getElementById("password_confirm");
    const showPasswordCheckbox = document.getElementById("mostrar_contraseña");

    if (showPasswordCheckbox.checked) {
        password.type = "text";
        password_confirm.type = "text";
    } else {
        password.type = "password";
        password_confirm.type = "password";
    }
});

/**
 * Acciones para cerrar o abrir el collapse para actualizar un usuario
 **/
window.livewire.on('mostrar_collapse_usuario', () => {
    $('#collapse-usuario').collapse('show');
});
window.livewire.on('ocultar_collapse_usuario', () => {
    $('#collapse-usuario').collapse('hide');
});

/**
 * Acciones para cerrar o abrir el collapse para actualizar una persona
 **/
window.livewire.on('mostrar_collapse_persona', () => {
    $('#collapse-persona').collapse('show');
});
window.livewire.on('ocultar_collapse_persona', () => {
    $('#collapse-persona').collapse('hide');
});

/**
 * Acciones para cerrar o abrir el collapse para actualizar un equipo
 **/
window.livewire.on('mostrar_collapse_equipo', () => {
    $('#collapse-equipo').collapse('show');
});
window.livewire.on('ocultar_collapse_equipo', () => {
    $('#collapse-equipo').collapse('hide');
});

/**
 * Acciones para cerrar o abrir el modal para borrar un equipo
 **/
window.livewire.on('mostrar_modal_borrar_equipo', () => {
    $('#modal-confirmacion-borrar-equipo').modal('show');
});
window.livewire.on('ocultar_modal_borrar_equipo', () => {
    $('#modal-confirmacion-borrar-equipo').modal('hide');
});

/**
 * Acciones para cerrar o abrir el modal para actualizar un equipo
 **/
window.livewire.on('mostrar_modal_asignar_miembro', () => {
    $('#modal-asignar-miembro').modal('show');
});
window.livewire.on('ocultar_modal_asignar_miembro', () => {
    $('#modal-asignar-miembro').modal('hide');
});

/**
 * Acciones para cerrar o abrir el collapse para actualizar un proyecto
 **/
window.livewire.on('mostrar_collapse_proyecto', () => {
    $('#collapse-proyecto').collapse('show');
});
window.livewire.on('ocultar_collapse_proyecto', () => {
    $('#collapse-proyecto').collapse('hide');
});

/**
 * Acciones para cerrar o abrir la confirmación de eliminación de un proyecto con tareas creadas
 **/
window.livewire.on('mostrar_modal_eliminar_proyecto', () => {
    $('#modal-confirmacion-borrar-proyecto').modal('show');
});
window.livewire.on('ocultar_modal_eliminar_proyecto', () => {
    $('#modal-confirmacion-borrar-proyecto').modal('hide');
});

/**
 * Acciones para cerrar o abrir el collapse para actualizar una tarea
 **/
window.livewire.on('mostrar_collapse_tarea', () => {
    $('#collapse-tareas').collapse('show');
});
window.livewire.on('ocultar_collapse_tarea', () => {
    $('#collapse-tareas').collapse('hide');
});
/**
 * Acciones para cerrar o abrir el modal para borrar una tarea
 **/
window.livewire.on('mostrar_modal_borrar_tarea', () => {
    $('#modal-confirmacion-borrar-tarea').modal('show');
});
window.livewire.on('ocultar_modal_borrar_tarea', () => {
    $('#modal-confirmacion-borrar-tarea').modal('hide');
});
/**
 * Acciones para cerrar o abrir el modal para mostrar los comentario
 **/
window.livewire.on('mostrar_modal_comentarios', () => {
    $('#modal-comentarios-tarea').modal('show');
});
window.livewire.on('ocultar_modal_comentarios', () => {
    $('#modal-comentarios-tarea').modal('hide');
});
/**
 * Acciones para cerrar o abrir el modal para borrar las personas
 **/
window.livewire.on('mostrar_modal_borrar_persona', () => {
    $('#modal-confirmacion-borrar-persona').modal('show');
});
window.livewire.on('ocultar_modal_borrar_persona', () => {
    $('#modal-confirmacion-borrar-persona').modal('hide');
});

/**
 * dar click a input de archivos en los comentarios
 * **/
document.getElementById('btn-subir-archivo').addEventListener('click', function () {
  document.getElementById('subir-archivo').click()
});
