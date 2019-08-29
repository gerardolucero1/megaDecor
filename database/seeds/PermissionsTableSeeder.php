<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    //Usuarios
        Permission::create([
            'name' => 'Navegar Usuarios', 
            'slug' => 'users.index',
            'description' => 'lista y navega todos los usuarios del sistema',
        ]);
        Permission::create([
            'name' => 'Ver Detalle de usuario', 
            'slug' => 'users.show',
            'description' => 'Ver detalle de los usuarios',
        ]);
        Permission::create([
            'name' => 'Edicion de usuarios', 
            'slug' => 'users.edit',
            'description' => 'Editar informacion de los usuarios',
        ]);
        Permission::create([
            'name' => 'Eliminar Usuario', 
            'slug' => 'users.destroy',
            'description' => 'Eliminar usuarios',
        ]);
    
    //Roles
    Permission::create([
        'name' => 'Navegar rol', 
        'slug' => 'roles.index',
        'description' => 'lista y navega todos los rol del sistema',
    ]);
    Permission::create([
        'name' => 'Ver Detalle de rol', 
        'slug' => 'roles.show',
        'description' => 'Ver detalle de los rol',
    ]);
    Permission::create([
        'name' => 'Edicion de rol', 
        'slug' => 'roles.edit',
        'description' => 'Editar información de los rol',
    ]);
    Permission::create([
        'name' => 'Creacion de rol', 
        'slug' => 'roles.create',
        'description' => 'Editar información de los rol',
    ]);
    Permission::create([
        'name' => 'Eliminar rol', 
        'slug' => 'roles.destroy',
        'description' => 'Eliminar rol',
    ]);

    //Clientes
    Permission::create([
        'name' => 'Navegar cliente', 
        'slug' => 'clientes.index',
        'description' => 'lista y navega todos los cliente del sistema',
    ]);
    Permission::create([
        'name' => 'Ver Detalle de cliente', 
        'slug' => 'clientes.show',
        'description' => 'Ver detalle de los cliente',
    ]);
    Permission::create([
        'name' => 'Edicion de cliente', 
        'slug' => 'clientes.edit',
        'description' => 'Editar información de los cliente',
    ]);
    Permission::create([
        'name' => 'Creacion de cliente', 
        'slug' => 'clientes.create',
        'description' => 'Editar información de los cliente',
    ]);
    Permission::create([
        'name' => 'Eliminar cliente', 
        'slug' => 'clientes.destroy',
        'description' => 'Eliminar cliente',
    ]);
       
    }
}
