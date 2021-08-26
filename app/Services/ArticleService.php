<?php


namespace App\Services;


use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleService extends BaseService
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
     * Повертає всі записи
     * @return mixed
     */
    public function getAll()
    {
        return $this->getAllItems(Article::class);
    }

    /**
     * Метод який поверне транслітерований рядок.
     * @param string $text
     * @return string
     */
    public function getTrans(string $text):string
    {
        return $this->translit($text);
    }

    /**
     * Валідація даних форми створення статті
     * @param Request $request
     * @return array
     */
    public function validateData(Request $request):array
    {
        return $request->validate([
            'title' => 'required|max:150',
            'url' => 'required|max:150',
            'short_content' => 'string',
            'content' => 'required|min:10',
            'tags' => 'min:1',
            'image' => 'max:222',
//            'categories' => 'min:1', //TODO Валидація категорій увімкнути коли реалізкє категорії
            'source_main' => 'max:150',
            'source_1' => 'max:150',
            'source_2' => 'max:150',
            'source_3' => 'max:150',
            'source_other' => 'max:150',
            'public' => 'min:1|max:10',
            'main' => 'min:1|max:10',
            'top' => 'min:1|max:10',
            'important' => 'min:1|max:10',
            'red' => 'min:1|max:10',
            'green' => 'min:1|max:10',
            'blue' => 'min:1|max:10',
            'fake' => 'min:1|max:10',
            'doubt' => 'min:1|max:10',
        ]);
    }

    private function formatterTags(string $tags):string
    {
        $tags = json_decode($tags, true);
        if (!empty($tags)) {
            $data = [];
            foreach ($tags as $tag) {
                $data[] = $this->translit($tag['name']);
            }
            $tags = $data;
        }
        return json_encode($tags);
    }

    /**
     * Метод створить нову статтю в базі
     * @param array $data
     * @return mixed
     */
    public function createNew(array $data)
    {
        $article = new Article();
        $article->author_id = Auth::id();
        $article->title = $data['title'];
        $article->url = $this->translit( $data['title']);
        if (!empty($data['short_content'])) {
            $article->short_content = $data['short_content'];
        }
        $article->content = $data['content'];
        $article->tags =   $this->formatterTags( $data['tags']);
        if (!empty($data['source_main'])) {
            $article->source_main = $data['source_main'];
        }
        if (!empty($data['source_1'])) {
            $article->source_1 = $data['source_1'];
        }
        if (!empty($data['source_2'])) {
            $article->source_2 = $data['source_2'];
        }
        if (!empty($data['source_3'])) {
            $article->source_3 = $data['source_3'];
        }
        if (!empty($data['source_other'])) {
            $article->source_other = $data['source_other'];
        }
        if (isset($data['public'])) {
            $article->public = true;
        }
        if (isset($data['main'])) {
            $article->main = true;
        }
        if (isset($data['top'])) {
            $article->top = true;
        }
        if (isset($data['important'])) {
            $article->important = true;
        }
        if (isset($data['red'])) {
            $article->red = true;
        }
        if (isset($data['green'])) {
            $article->green = true;
        }
        if (isset($data['blue'])) {
            $article->blue = true;
        }
        if (isset($data['fake'])) {
            $article->fake = true;
        }
        if (isset($data['doubt'])) {
            $article->doubt = true;
        }
        $article->image = $data['image'];
        $article->save();
        return $article->id;
    }

    /**
     * Метод видалить статтю по її ід
     * @param $idArticle
     * @return bool
     */
    public function deleteArticle($idArticle):bool
    {
        $idArticle = abs(intval($idArticle));
        return $this->delete(Article::class, $idArticle);
    }

    /**
     * Поаертає пагіновану колекцію публічних статтей та сортує їх по новизні
     * @return mixed
     */
    public function getNewArticle()
    {
        return Article::wherePublic(true)
            ->orderBy('created_at', 'desc')
            ->paginate($this->getPerPagesPaginate());
    }

    /**
     * Поверне статтю по її ід яке прописано першим в урл
     * @param string $url
     * @return mixed
     */
    public function getArticle(string $url)
    {
        $idArticle = abs( (int)$url );
        $article = Article::find($idArticle);
        if ($article) {
            $article->increment('views');
        }
        return $article;
    }

    /**
     * Поаерне список статей для певного тегу
     * @param string $tagName
     * @return mixed
     */
    public function getArticlesFromTag(string $tagName):mixed
    {
        $res = '';
        $alias = $this->translit($tagName);
        if ($this->isEnablePaginate() && !$this->isEnableOrderBy()) {
            $res = Article::whereJsonContains('tags', $alias)
                ->paginate($this->getPerPagesPaginate());
        } elseif (!$this->isEnablePaginate() && $this->isEnableOrderBy()) {
            $res = Article::whereJsonContains('tags', $alias)
                ->orderBy($this->getColumnOrderBy(),
                $this->getMethodOrderBy())->get();
        } elseif ($this->isEnablePaginate() && $this->isEnableOrderBy()) {
            $res = Article::whereJsonContains('tags', $alias)
                ->orderBy($this->getColumnOrderBy(),
                    $this->getMethodOrderBy())->paginate($this->getPerPagesPaginate());
        } else {
            $res = Article::whereJsonContains('tags', $alias)
                ->get();
        }
        return $res;
    }
}
