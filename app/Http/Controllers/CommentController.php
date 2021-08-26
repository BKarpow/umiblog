<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private CommentService $service;

    public function __construct()
    {
        $this->service = new CommentService();
    }

    function create(Request $request)
    {
        $data = $this->service->validateCreateNew($request);
        $commentId = $this->service->createNew($data);
        return response()->json(
            new ApiResponse(true, 'Comment created, id:'.$commentId)
        );;
    }

    function show(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
        ]);
        $comments = $this->service->getCommentsFromArticle($request->article_id);
        if ($comments) {
            return response()->json(
                new ApiResponse(true, 'Getting comments', $comments->toArray())
            );
        } else {
            return response()->json(
                new ApiResponse(false, 'Comments not found')
            );
        }
    }
}
