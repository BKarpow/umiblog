<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private MenuService $service;

    public function __construct()
    {
        $this->service = new MenuService();
    }

    function getMenu(Request $request)
    {
        $request->validate([
            'nameMenu' => 'required|string|max:50|min:4',
        ]);
        $data = $this->service->formatToApi(
            $this->service->getItemsFromNameMenu($request->nameMenu) );
        return response()
            ->json(new ApiResponse(true, '', $data));
    }

    function index()
    {
        return view('panel.menu.index', [
            'menus' => $this->service->getAllMenus(),
            'isPaginate' => $this->service->isEnablePaginate(),
        ]);
    }

    function create()
    {
        return view('panel.menu.create');
    }

    function createAction(Request $request)
    {
        $newId = $this->service->createNew(
            $this->service->validateCreateNew($request)
        );
        return response()->json(new ApiResponse(true));

    }

    function getPositions()
    {
        return response()
            ->json(new ApiResponse(true, 'Get positions menu',
            $this->service->getAllMenuNames()->toArray()));
    }

    function delete($id)
    {
        $this->service->deleteMenu($id);
        return redirect()->route('panel.menu.index')->withStatus('Видалено успішно');
    }
}
