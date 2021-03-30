<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Property\CreatePropertyRequest;
use App\Http\Requests\Property\UpdatePropertyRequest;
use App\Http\Services\PropertyService;

class PropertyController extends Controller
{
    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * @var PropertyService
     */
    private $propertyService;

    /**
     * @method __construct
     * @param PropertyRepository $repository
     * @return void
     */
    public function __construct(PropertyRepository $repository, PropertyService $service)
    {
        $this->propertyRepository = $repository;
        $this->propertyService = $service;
    }

    /**
     * Display a listing of the properties resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = $this->propertyRepository->getAll();
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePropertyRequest $request
     * @return JsonResponse
     */
    public function store(CreatePropertyRequest $request): JsonResponse
    {
        $data = $request->all();

        try {
            $response = $this->propertyService->createProperty($data);
            return response()->json($response, Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $response = $this->propertyService->getProperty($id);
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePropertyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->all();

        $response = $this->propertyRepository->update($id, $data);
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->propertyRepository->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
