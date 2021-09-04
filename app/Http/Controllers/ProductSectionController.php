<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ProductSectionService;

class ProductSectionController extends Controller
{
    public ProductSectionService $service;

    public function __construct()
    {
        $this->service = new ProductSectionService();
    }

    public function index()
    {
        $sections = $this->service->getAllItemFromPanel();
        return view('panel.productSection.index', [
            'sections' => $sections,
            'isPaginate' => $this->service->isEnablePaginate()
        ]);
    }

    function create(Request $request)
    {
        $data = $this->service->validateNewItem($request);
        return response()
            ->json(
                new ApiResponse($this->service->createNewItem($data))
            );
    }

    function getAllApi()
    {
        return response()->json(
            $this->service->getAllItemsForApi()
        );
    }

    function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:50',
            'description' => 'max:250',
            'section_id' => 'required|exists:product_sections,id',
            'image' => 'max:250',
        ]);
        $itemId = (int)$data['section_id'];
        return response()->json(
            new ApiResponse($this->service->updateItem($itemId, $data))
        );
    }

    function delete(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:product_sections,id',
        ]);
        return response()
            ->json(
                new ApiResponse($this->service->deleteItem((int)$request->section_id))
            );
    }
}
