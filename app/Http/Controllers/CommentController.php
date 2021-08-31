<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Comment;
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
            $comments = $this->service->formatFromApi($comments);
            return response()->json(
                new ApiResponse(true, 'Getting comments', $comments)
            );
        } else {
            return response()->json(
                new ApiResponse(false, 'Comments not found')
            );
        }
    }

    function index()
    {
        return view('panel.comment.index', [
            'comments' => $this->service->getCommentsFromArticleNoModer(),
            'isPaginate' => true,
        ]);
    }

    function togglePublic($commentId)
    {
        $cid = abs( (int)$commentId );
        $com = Comment::find($cid);
        if ($com) {
            $com->moderate = !(bool)$com->moderate;
            $com->save();
            return response()->json(
                new ApiResponse(true, '', ['toggle' => $com->moderate])
            );
        } else {
            abort(404);
        }
    }

    function getCommentsFromAjaxApi(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'limit' => 'required',
            'offset' => 'required',
        ]);
        return response()->json(
            $this->service->getCommentsFromArticleIdApi(
                abs( (int)$request->article_id ),
                (int) $request->limit,
                (int) $request->offset
            )
        );
    }
}
