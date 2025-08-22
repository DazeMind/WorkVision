<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OrderDeliveries;
use App\Models\OrderDetail;
use App\Models\ProductsService;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_order_and_delivery_when_type_is_delivery()
    {
        // Creamos productos de prueba
        $products = ProductsService::factory()->count(2)->create();

        // Datos que enviarás al endpoint
        $payload = [
            'client_id' => 1,
            'id_company' => 1,
            'company_id' => 1,
            'total_amount' => 10000,
            'discounts' => 1000,
            'products' => $products->pluck('id')->toArray(),
            'type' => 'order/delivery',
            'delivery_amount' => 2000,
            'destination_address' => 'Calle Falsa 123',
            'destination_comuna' => 'Santiago Centro',
            'destination_region' => 'RM',
            'address_origin' => 'Bodega 1',
            'delivery_date' => now()->toDateString(),
        ];

        // Hacemos el request al controlador
        $response = $this->postJson('/api/orders', $payload);

        // Verificamos si se creó el pedido
        $this->assertDatabaseHas('order_sales', [
            'sale_price' => 10000,
            'discounts' => 1000,
            'total_amount' => 9000
        ]);

        // Verificamos si se creó la entrega
        $this->assertDatabaseHas('order_deliveries', [
            'destination_address' => 'Calle Falsa 123'
        ]);

        // Verificamos detalles del pedido
        $this->assertDatabaseCount('order_details', 2);

        $response->assertStatus(200); // Asume que retorna 200, puedes ajustar esto
    }
}
