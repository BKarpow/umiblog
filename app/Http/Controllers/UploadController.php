<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\StringToolsTrait;
use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    use StringToolsTrait;

    private UploadService $service;

    public function __construct()
    {
        $this->service = new UploadService();
    }

    function uploadImage(Request $request)
    {
        $filename = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        $filename = $this->translit($filename);
        $fileExt = $request->file('image')->getClientOriginalExtension();
        $fileStore = $this->getNameFileToStore($filename, $fileExt);
        $path = $request->file('image')->storeAs($this->service->getUploadPath(), $fileStore);
        return response()
            ->json(new ApiResponse(true, 'Load image', ['path' => $this->correctStoragePath( $path)]));
    }


}
