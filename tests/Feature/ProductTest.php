<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Finance;
use App\Models\Producer;
use App\Models\Product;
use App\Models\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\RoleConst;
use App\Models\User;
use Tests\TestCase;
use Exception;

class ProductTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->user = User::where('email', 'user@user.ru')->first();

        if (!$this->user) {
            throw new Exception('Нет пользователей в базе данных');
        }
    }

    public function test_finance_groups_index()
    {
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->getJson('/api/finance-groups');

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('success', 'finance_groups')
            ->where('success', true)
            ->whereType('finance_groups', 'array')
        );
    }

    public function test_finance_groups_store()
    {
        $name = 'Финансовая группа '.rand();
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->postJson('/api/finance-groups', [
                'name' => $name
            ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('success', 'finance_group')
            ->where('success', true)
            ->whereType('finance_group', 'array')
            ->where('finance_group.name', $name)
        );

        $this->assertDatabaseHas('finance_groups', [
            'name' => $name
        ]);
    }

    public function test_finances_index()
    {
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->getJson('/api/finances');

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('finances', 'meta', 'links')
            ->whereType('finances', 'array')
        );
    }

    public function test_finances_store()
    {
        $finance = Finance::factory()->make();
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->postJson('/api/finances', [
                'name' => $finance->name,
                'operation_type' => $finance->operation_type,
                'sum' => $finance->sum,
                'finance_group_id' => $finance->finance_group_id
            ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('success', 'finance')
            ->where('success', true)
            ->whereType('finance', 'array')
            ->where('finance.name', $finance->name)
            ->where('finance.operation_type', $finance->operation_type)
            ->where('finance.finance_group.id', $finance->finance_group_id)
        );

        $this->assertDatabaseHas('finances', [
            'name' => $finance->name,
            'operation_type' => $finance->operation_type,
            'sum' => $finance->sum,
            'finance_group_id' => $finance->finance_group_id
        ]);
    }

    public function test_cars_index()
    {
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->getJson('/api/cars');

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('cars', 'success')
            ->where('success', true)
            ->whereType('cars', 'array')
        );
    }

    public function test_cars_store()
    {
        $car = Car::factory()->make();
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->postJson('/api/cars', [
                'number' => $car->number,
                'client_id' => $car->client_id,
                'car_model_id' => $car->car_model_id,
                'vin' => $car->vin,
                'color' => $car->color,
                'year' => $car->year
            ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('success', 'car')
            ->where('success', true)
            ->whereType('car', 'array')
            ->where('car.number', $car->number)
            ->where('car.vin', $car->vin)
            ->where('car.color', $car->color)
            ->where('car.year', $car->year)
            ->where('car.client.id', $car->client_id)
            ->where('car.car_model.id', $car->car_model_id)
        );

        $this->assertDatabaseHas('cars', [
            'number' => $car->number,
            'vin' => $car->vin,
            'color' => $car->color,
            'year' => $car->year,
            'client_id' => $car->client_id,
            'car_model_id' => $car->car_model_id
        ]);
    }

    public function test_storages_index()
    {
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->getJson('/api/storages');

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('storages', 'success')
            ->where('success', true)
            ->whereType('storages', 'array')
        );
    }

    public function test_storages_store()
    {
        $storage = Storage::factory()->make();
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->postJson('/api/storages', [
                'name' => $storage->name,
                'city_id' => $storage->city_id,
            ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('success', 'storage')
            ->where('success', true)
            ->whereType('storage', 'array')
            ->where('storage.name', $storage->name)
            ->where('storage.city.id', $storage->city_id)
        );

        $this->assertDatabaseHas('storages', [
            'name' => $storage->name,
            'city_id' => $storage->city_id,
        ]);
    }

    public function test_producers_index()
    {
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->getJson('/api/producers');

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('producers', 'success')
            ->where('success', true)
            ->whereType('producers', 'array')
        );
    }

    public function test_producers_store()
    {
        $producer = Producer::factory()->make();
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->postJson('/api/producers', [
                'name' => $producer->name,
            ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('success', 'producer')
            ->where('success', true)
            ->whereType('producer', 'array')
            ->where('producer.name', $producer->name)
        );

        $this->assertDatabaseHas('producers', [
            'name' => $producer->name,
        ]);
    }

    public function test_products_index()
    {
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->getJson('/api/products');

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('products', 'links', 'meta')
            ->whereType('products', 'array')
        );
    }

    public function test_products_store()
    {
        $product = Product::factory()->make();
        $response = $this->actingAs($this->user, RoleConst::GUARD_NAME)
            ->postJson('/api/products', [
                'name' => $product->name,
                'count' => $product->count,
                'input_sum' => $product->input_sum,
                'output_sum' => $product->output_sum
            ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) =>
        $json->hasAll('success', 'product')
            ->where('success', true)
            ->whereType('product', 'array')
            ->where('product.name', $product->name)
            ->where('product.count', $product->count)
            ->where('product.input_sum', $product->input_sum)
            ->where('product.output_sum', $product->output_sum)
        );

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'count' => $product->count,
            'input_sum' => $product->input_sum,
            'output_sum' => $product->output_sum,
        ]);
    }
}