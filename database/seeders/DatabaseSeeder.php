<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    // 1. LIMPIEZA DE TABLAS Y RESETEO DE SECUENCIAS EN POSTGRES
    Schema::disableForeignKeyConstraints();

    DB::table('purchase_order__histories')->truncate();
    DB::table('product__purchase_orders')->truncate();
    DB::table('user__roles')->truncate();
    DB::table('user__cashflows')->truncate();
    DB::table('images')->truncate();
    DB::table('purchase_orders')->truncate();
    DB::table('cashflows')->truncate();
    DB::table('products')->truncate();
    DB::table('categories')->truncate();
    DB::table('roles')->truncate();
    DB::table('store_schedules')->truncate();
    DB::table('users')->truncate();

    Schema::enableForeignKeyConstraints();

    $now = now();

    // 2. ROLES
    DB::table('roles')->insert([
      ['name' => 'Administrador', 'created_at' => $now, 'updated_at' => $now], // ID 1
      ['name' => 'Cliente',       'created_at' => $now, 'updated_at' => $now], // ID 2
      ['name' => 'Cajero',        'created_at' => $now, 'updated_at' => $now], // ID 3
      ['name' => 'Cocina',        'created_at' => $now, 'updated_at' => $now], // ID 4
      ['name' => 'Cafeteria',     'created_at' => $now, 'updated_at' => $now], // ID 5
    ]);

    // 3. USUARIOS
    DB::table('users')->insert([
      [
        'name' => 'Gonzalo Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'is_active' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 1
      [
        'name' => 'Sofía Barista',
        'email' => 'sofia@example.com',
        'password' => Hash::make('password'),
        'is_active' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 2
      [
        'name' => 'Tomás Cajero',
        'email' => 'tomas@example.com',
        'password' => Hash::make('password'),
        'is_active' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 3
      [
        'name' => 'Martín Palermo',
        'email' => 'martin@example.com',
        'password' => Hash::make('password'),
        'is_active' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 4
      [
        'name' => 'Clara Rossi',
        'email' => 'clara@example.com',
        'password' => Hash::make('password'),
        'is_active' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 5
    ]);

    // 4. ROLES DE USUARIO
    DB::table('user__roles')->insert([
      ['user_id' => 1, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now], // Admin
      ['user_id' => 2, 'role_id' => 5, 'created_at' => $now, 'updated_at' => $now], // Cafeteria
      ['user_id' => 3, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now], // Cajero
      ['user_id' => 4, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now], // Cliente
      ['user_id' => 5, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now], // Cliente
    ]);

    // 5. CATEGORIAS
    DB::table('categories')->insert([
      ['name' => 'Cafetería',  'description' => 'Especialidades calientes y frías',     'created_at' => $now, 'updated_at' => $now], // ID 1
      ['name' => 'Pastelería', 'description' => 'Tortas, budines y cosas dulces',       'created_at' => $now, 'updated_at' => $now], // ID 2
      ['name' => 'Salado',     'description' => 'Tostados y opciones para el almuerzo', 'created_at' => $now, 'updated_at' => $now], // ID 3
      ['name' => 'Bebidas',    'description' => 'Jugos naturales y gaseosas',           'created_at' => $now, 'updated_at' => $now], // ID 4
    ]);

    // 6. PRODUCTOS
    DB::table('products')->insert([
      [
        'category_id' => 1,
        'name' => 'Café Latte',
        'description' => 'Doble shot de espresso con leche emulsionada',
        'price' => 3200.00,
        'stock' => 150,
        'is_featured' => true,
        'is_published' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 1
      [
        'category_id' => 1,
        'name' => 'Espresso Italiano',
        'description' => 'Shot simple concentrado con granos de especialidad',
        'price' => 2100.00,
        'stock' => 200,
        'is_featured' => false,
        'is_published' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 2
      [
        'category_id' => 2,
        'name' => 'Croissant de Almendras',
        'description' => 'Medialuna de manteca rellena de crema de almendras tostadas',
        'price' => 2800.00,
        'stock' => 35,
        'is_featured' => true,
        'is_published' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 3
      [
        'category_id' => 2,
        'name' => 'Roll de Canela',
        'description' => 'Masa suave especiada con canela y glaseado clásico',
        'price' => 2500.00,
        'stock' => 20,
        'is_featured' => false,
        'is_published' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 4
      [
        'category_id' => 3,
        'name' => 'Tostado de Jamón y Queso',
        'description' => 'En pan de masa madre con abundante queso tybo',
        'price' => 5200.00,
        'stock' => 40,
        'is_featured' => true,
        'is_published' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 5
      [
        'category_id' => 4,
        'name' => 'Exprimido de Naranja',
        'description' => '100% natural, exprimido al momento (500ml)',
        'price' => 3000.00,
        'stock' => 80,
        'is_featured' => false,
        'is_published' => true,
        'created_at' => $now,
        'updated_at' => $now,
      ], // ID 6
    ]);

    // 7. ORDENES DE COMPRA
    // IMPORTANTE: Carbon muta el objeto, clonar para evitar efectos secundarios
    DB::table('purchase_orders')->insert([
      [
        'pickup_code' => 'LATT82',
        'total_price' => 9200.00,
        'user_id' => 4,
        'created_at' => $now->copy()->subMinutes(15),
        'updated_at' => $now->copy()->subMinutes(15),
      ], // ID 1
      [
        'pickup_code' => 'CROI15',
        'total_price' => 11000.00,
        'user_id' => 5,
        'created_at' => $now->copy()->subMinutes(30),
        'updated_at' => $now->copy()->subMinutes(10),
      ], // ID 2
      [
        'pickup_code' => 'TOST99',
        'total_price' => 10400.00,
        'user_id' => 4,
        'created_at' => $now->copy()->subHours(2),
        'updated_at' => $now->copy()->subHour(),
      ], // ID 3
    ]);

    // 8. DETALLE DE PRODUCTOS POR ORDEN
    DB::table('product__purchase_orders')->insert([
      // Orden 1
      ['product_id' => 1, 'purchase_order_id' => 1, 'price' => 3200.00, 'quantity' => 2, 'created_at' => $now->copy()->subMinutes(15), 'updated_at' => $now->copy()->subMinutes(15)],
      ['product_id' => 3, 'purchase_order_id' => 1, 'price' => 2800.00, 'quantity' => 1, 'created_at' => $now->copy()->subMinutes(15), 'updated_at' => $now->copy()->subMinutes(15)],
      // Orden 2
      ['product_id' => 1, 'purchase_order_id' => 2, 'price' => 3200.00, 'quantity' => 1, 'created_at' => $now->copy()->subMinutes(30), 'updated_at' => $now->copy()->subMinutes(30)],
      ['product_id' => 3, 'purchase_order_id' => 2, 'price' => 2800.00, 'quantity' => 1, 'created_at' => $now->copy()->subMinutes(30), 'updated_at' => $now->copy()->subMinutes(30)],
      ['product_id' => 5, 'purchase_order_id' => 2, 'price' => 5000.00, 'quantity' => 1, 'created_at' => $now->copy()->subMinutes(30), 'updated_at' => $now->copy()->subMinutes(30)],
      // Orden 3
      ['product_id' => 5, 'purchase_order_id' => 3, 'price' => 5200.00, 'quantity' => 2, 'created_at' => $now->copy()->subHours(2),   'updated_at' => $now->copy()->subHours(2)],
    ]);

    // 9. HISTORIAL DE LAS ORDENES DE COMPRA
    DB::table('purchase_order__histories')->insert([
      ['order_status' => 'Pendiente',      'notes' => 'Orden realizada desde la aplicación móvil',          'purchase_order_id' => 1, 'user_id' => 4, 'created_at' => $now->copy()->subMinutes(15),  'updated_at' => $now->copy()->subMinutes(15)],
      ['order_status' => 'Pendiente',      'notes' => 'Orden recibida en el sistema',                       'purchase_order_id' => 2, 'user_id' => 5, 'created_at' => $now->copy()->subMinutes(30),  'updated_at' => $now->copy()->subMinutes(30)],
      ['order_status' => 'En preparación', 'notes' => 'Sofía comenzó a marchar el espresso y tostar el pan','purchase_order_id' => 2, 'user_id' => 2, 'created_at' => $now->copy()->subMinutes(10),  'updated_at' => $now->copy()->subMinutes(10)],
      ['order_status' => 'Pendiente',      'notes' => 'Orden ingresada',                                    'purchase_order_id' => 3, 'user_id' => 4, 'created_at' => $now->copy()->subHours(2),     'updated_at' => $now->copy()->subHours(2)],
      ['order_status' => 'En preparación', 'notes' => 'Marchando tostados dobles',                          'purchase_order_id' => 3, 'user_id' => 2, 'created_at' => $now->copy()->subMinutes(100), 'updated_at' => $now->copy()->subMinutes(100)],
      ['order_status' => 'Disponible',     'notes' => 'Listo en barra para retirar',                        'purchase_order_id' => 3, 'user_id' => 2, 'created_at' => $now->copy()->subMinutes(80),  'updated_at' => $now->copy()->subMinutes(80)],
      ['order_status' => 'Entregado',      'notes' => 'Entregado en mano por Tomás',                        'purchase_order_id' => 3, 'user_id' => 3, 'created_at' => $now->copy()->subHour(),       'updated_at' => $now->copy()->subHour()],
    ]);

    // 10. CASHFLOWS
    DB::table('cashflows')->insert([
      [
        'in_out' => true,
        'amount' => 10400.00,
        'description' => 'Cobro Orden #TOST99',
        'transaction_type' => 'SALE',
        'created_at' => $now->copy()->subHour(),
        'updated_at' => $now->copy()->subHour(),
      ],
      [
        'in_out' => false,
        'amount' => 8500.00,
        'description' => 'Compra de leche entera y almendras',
        'transaction_type' => 'EXPENSE',
        'created_at' => $now->copy()->subHours(5),
        'updated_at' => $now->copy()->subHours(5),
      ],
    ]);

    // 11. USER CASHFLOWS
    DB::table('user__cashflows')->insert([
      ['user_id' => 3, 'cashflow_id' => 1, 'created_at' => $now, 'updated_at' => $now],
      ['user_id' => 1, 'cashflow_id' => 2, 'created_at' => $now, 'updated_at' => $now],
    ]);

    // 12. STORE SCHEDULES
    // FIX: specific_date debe ser NULL para reglas de día de semana recurrentes
    for ($i = 0; $i < 7; $i++) {
      DB::table('store_schedules')->insert([
        'day_of_week'   => $i,
        'open_time'     => '08:00:00',
        'close_time'    => '21:00:00',
        'is_closed'     => ($i === 0), // Domingo cerrado
        'specific_date' => null,       // NULL = regla recurrente semanal
        'created_at'    => $now,
        'updated_at'    => $now,
      ]);
    }

    // Ejemplo de fecha específica (feriado cerrado)
    DB::table('store_schedules')->insert([
      'day_of_week'   => null,
      'open_time'     => '00:00:00',
      'close_time'    => '00:00:00',
      'is_closed'     => true,
      'specific_date' => '2026-01-01', // Año Nuevo cerrado
      'created_at'    => $now,
      'updated_at'    => $now,
    ]);

    // 13. REAJUSTE DE SECUENCIAS PARA POSTGRESQL (CRÍTICO)
    if (DB::getDriverName() === 'pgsql') {
      $tables = [
        'roles', 'users', 'categories', 'products',
        'purchase_orders', 'product__purchase_orders',
        'purchase_order__histories', 'cashflows', 'store_schedules'
      ];

      foreach ($tables as $table) {
        $seq = "{$table}_id_seq";
        DB::statement("SELECT setval('$seq', COALESCE((SELECT MAX(id) FROM \"$table\"), 1));");
      }
    }
  }
}
