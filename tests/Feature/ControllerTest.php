<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Role;
use App\Models\Usuario;
use App\Models\Taxista;
use App\Models\EstatusDocumento;

class ControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para PaginaController::sobreNosotros
     * Verifica que la vista 'sobre' se retorna correctamente
     */
    public function test_pagina_controller_sobre_nosotros()
    {
        $response = $this->get('/sobre-nosotros');

        $response->assertStatus(200)
                 ->assertViewIs('sobre');
    }

    /**
     * Test para HomeController::index
     * Verifica que solo usuarios autenticados pueden acceder al dashboard
     */
    /* public function test_home_controller_index_authenticated()
    {
        // Crear usuario y autenticarse
        $role = Role::create(['id' => Str::uuid()->toString(), 'nombre' => 'user']);
        
        $usuario = Usuario::create([
            'id' => Str::uuid()->toString(),
            'nombre' => 'John',
            'apellido' => 'Doe',
            'telefono' => '1234567890',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'id_rol' => $role->id,
        ]);

        $response = $this->actingAs($usuario, 'web')->get('/home');

        $response->assertStatus(200)
                 ->assertViewIs('home');
    } */

    /**
     * Test para HomeController::index sin autenticación
     * Verifica que redirige a login si no está autenticado
     */
    public function test_home_controller_index_unauthenticated()
    {
        $response = $this->get('/home');

        $response->assertStatus(302)
                 ->assertRedirect('/login');
    }

    /**
     * Test para TaxistaController::index
     * Verifica que la vista de taxistas se retorna correctamente con taxistas aprobados
     */
    public function test_taxista_controller_index()
    {
        // Crear roles y estatus necesarios
        $role = Role::create(['id' => Str::uuid()->toString(), 'nombre' => 'taxista']);
        $estatusAprobado = EstatusDocumento::create([
            'id' => Str::uuid()->toString(),
            'nombre' => 'Aprobado'
        ]);

        // Crear usuario taxista
        $usuario = Usuario::create([
            'id' => Str::uuid()->toString(),
            'nombre' => 'Carlos',
            'apellido' => 'Moreno',
            'telefono' => '9876543210',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password'),
            'id_rol' => $role->id,
        ]);

        // Crear taxista con documentos aprobados (simulado)
        $taxista = Taxista::create([
            'id' => Str::uuid()->toString(),
            'id_usuario' => $usuario->id,
        ]);

        $response = $this->get('/taxistas');

        $response->assertStatus(200)
                 ->assertViewIs('taxistas.index')
                 ->assertViewHas('taxistas');
    }
}
