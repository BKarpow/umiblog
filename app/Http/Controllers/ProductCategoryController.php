<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductCategoryService;
use App\Http\Responses\ApiResponse;

class ProductCategoryController extends Controller
{
    private ProductCategoryService $service;

    function __construct()
    {
        $this->service = new ProductCategoryService();
    }

    function create(Request $request)
    {
        $data = $this->service->validateNewItem($request);
        return response()
            ->json(
                new ApiResponse($this->service->createNewItem($data))
            );
    }

    function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:50',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'max:250',
            'image' => 'max:150',
        ]);
        return response()->json(
            new ApiResponse($this->service->updateItem((int)$request->category_id, $data))
        );
    }

    function delete(Request $request) {
        $request->validate([
            'category_id' => 'required|exists:product_categories,id',
        ]);
        return response()->json(
            new ApiResponse($this->service->deleteItem((int)$request->category_id))
        );
    }
}
