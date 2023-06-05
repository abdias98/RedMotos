<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
        $rol_admin = Role::create(['name' => 'Administrador']);
        $rol_editor = Role::create(['name' => 'Editor']);

        //Permisos
        $permiso_usuario = Permission::create(['name' => 'usuarios']);
        $permiso_roles = Permission::create(['name' => 'roles']);
        $permiso_inicio = Permission::create(['name' => 'inicio']);
        $permiso_personas = Permission::create(['name' => 'personas']);
        $permiso_equipos = Permission::create(['name' => 'equipos']);
        $permiso_proyectos = Permission::create(['name' => 'proyectos']);
        $permiso_tareas = Permission::create(['name' => 'tareas']);
        $permiso_reportes = Permission::create(['name' => 'reportes']);

        $rol_editor->givePermissionTo($permiso_inicio);
        $rol_editor->givePermissionTo($permiso_tareas);

        $rol_admin->givePermissionTo($permiso_usuario);
        $rol_admin->givePermissionTo($permiso_inicio);
        $rol_admin->givePermissionTo($permiso_roles);
        $rol_admin->givePermissionTo($permiso_personas);
        $rol_admin->givePermissionTo($permiso_equipos);
        $rol_admin->givePermissionTo($permiso_tareas);
        $rol_admin->givePermissionTo($permiso_proyectos);
        $rol_admin->givePermissionTo($permiso_reportes);
    }
}
