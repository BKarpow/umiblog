<?php


namespace App\Services;

use App\Models\Comment;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentService extends BaseService
{
    use StringToolsTrait;

    public function __construct()
    {
        $this->enablePaginate = true;
        $this->perPagesPaginate = 10; // кількісит сикивй на сторінці
        $this->enableOrderBy = true;
        $this->methodOrderBy = 'DESC';
        $this->setColumnOrderBy('created_at');
    }

    /**
     * Валідація форми створення коментаря
     * @param Request $request
     * @return array
     */
    public function validateCreateNew(Request $request):array
    {
        return $request->validate([
            'article_id' => 'required|exists:articles,id',
            'comment' => 'required|string|min:3|max:250',
        ]);
    }

    /**
     * Метод створить новий коментарь та поверне його ід
     * @param array $data
     * @return int
     */
    public function createNew(array $data):int
    {
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->comment = $data['comment'];
        $comment->article_id = $data['article_id'];
        $comment->save();
        return (int) $comment->id;
    }

    /**
     * Поаерне колекцію коментарів для статті
     * @param $articleId
     * @return mixed
     */
    public function getCommentsFromArticle($articleId):mixed
    {
        $articleId = abs( (int)$articleId );
        return Comment::whereArticleId($articleId)
            ->whereModerate(true)
            ->orderBy('created_at', 'desc')->get();
    }

    /**
     * Метод поверне апі колекцію коментарів для певної статті. 
     * @param int $articleId - ід статті
     * @param int $limit - скільки коментарів за один запит
     * @param int $offset - зміщення по списку коментарів
     * @return ApiResponse
     */
    public function getCommentsFromArticleIdApi(int $articleId, int $limit, int $offset):ApiResponse
    {
        $data = [];
        if ($this->isEnableOrderBy()) {
            $data = Comment::whereArticleId($articleId)
                ->orderBy($this->getColumnOrderBy(), $this->getMethodOrderBy())
                ->limit($limit)->offset($offset)
                ->get();
        } else {
            $data = Comment::whereArticleId($articleId)
                ->limit($limit)->offset($offset)
                ->get();
        }

        if ($data) {
            $data = $this->formatFromApi($data);
            return new ApiResponse(true, 'Get comments from article', $data);
        } else {
            return new ApiResponse(false, 'Error getting comments from article id '.$articleId);
        }
    }

    /**
     * Поаерне колекцію коментарів всіх коментарів
     * @return mixed
     */
    public function getCommentsFromArticleNoModer():mixed
    {
        return Comment::orderBy('created_at', 'desc')->paginate(25);
    }

    /**
     * Формує масив для апі
     * @param $collections
     * @return array
     */
    public function formatFromApi($collections):array
    {
        $data = [];
        foreach ($collections as $item) {
            $data[] = [
                'id' => $item->id,
                'avatar' => $item->author->getAvatar(),
                'author' => $item->author->name,
                'comment' => $item->comment,
                'date' => $item->date(),
            ];
        }
        return $data;
    }
}
