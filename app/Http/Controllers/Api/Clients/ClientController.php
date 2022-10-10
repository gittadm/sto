<?php

namespace App\Http\Controllers\Api\Clients;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Requests\Clients\StoreRequest;
use App\Http\Requests\Clients\UpdateRequest;
use App\Http\Resources\Clients\ClientCollection;
use App\Http\Resources\Clients\ClientResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Clients\ClientWithCarsResource;
use App\Services\Clients\ClientService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * ClientController constructor.
     * @param  ClientService  $clientService
     */
    public function __construct(private ClientService $clientService) {}

    /**
     * Список клиентов
     *
     * Получение списка клиентов с отделом и городом с пагинацией.
     * С помощью дополнительных параметров в url можно указать отдел, город,
     * поле для сортировки и фрагмент для поиска по ФИО, паспорту, email, телефону, номеру автомобиля.
     *
     * Права: `read clients`
     *
     * @group Клиенты
     *
     * @urlParam order string Значения: id, surname. Если параметр не указан, то по id desc.
     * @urlParam department_id integer Получение клиентов только с указанного отдела
     * @urlParam city_id integer Получение клиентов только с указанного города
     * @urlParam name string Фрагмент для поиска по ФИО
     * @urlParam search string Фрагмент для поиска по ФИО, email, телефону или паспорту
     * @urlParam number string Фрагмент для поиска по номеру автомобиля
     *
     * @param  Request  $request
     * @return ClientCollection
     * @throws AuthorizationException
     */
    public function index(Request $request): ClientCollection
    {
        $this->authorize('clients-read');

        $clients = $this->clientService->getPaginatedClients($request->all());

        return new ClientCollection($clients);
    }

    /**
     * Получение клиента
     *
     * Права: `read clients`
     *
     * @group Клиенты
     *
     * @param  Client  $client
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Client $client): JsonResponse
    {
        $this->authorize('clients-read');

        return response_json(['client' => ClientWithCarsResource::make($client)]);
    }

    /**
     * Добавление клиента
     *
     * Права: `crud clients`
     *
     * @group Клиенты
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('clients-crud');

        $client = $this->clientService->store($request->validated());

        return response_json(['client' => ClientResource::make($client)]);
    }

    /**
     * Обновление клиента
     *
     * Права: `crud clients`
     *
     * @group Клиенты
     *
     * @param  UpdateRequest  $request
     * @param  int  $clientId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, int $clientId): JsonResponse
    {
        $this->authorize('clients-crud');

        $client = $this->clientService->update($clientId, $request->validated());

        return response_json(['client' => ClientResource::make($client)]);
    }

    /**
     * Удаление клиента
     *
     * Права: `crud clients`
     *
     * @group Клиенты
     *
     * @param  int  $clientId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     * @throws AuthorizationException
     */
    public function destroy(int $clientId): JsonResponse
    {
        $this->authorize('clients-crud');

        $this->clientService->delete($clientId);

        return response_success();
    }
}
