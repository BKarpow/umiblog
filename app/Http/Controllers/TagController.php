<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagService $service;

    public function __construct()
    {
        $this->service = new TagService();
    }

    function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:150',
        ]);
        $id = $this->service->createTag($data);
        return response()
            ->json(new ApiResponse(true, 'Create new tag',
                ['id'=>$id, 'name' => $data['name']]));
    }

    function search(Request $request)
    {
        $data = $request->validate([
            's' => 'required|max:150'
        ]);
        $this->service->setEnablePaginate(false);
        $res = $this->service->searchTag($data['s']);
        return response()
            ->json(new ApiResponse(true, '', $res->toArray()));
    }
}
