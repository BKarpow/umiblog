<?php


namespace App\Services;


use App\Models\Tag;

class TagService extends BaseService
{
    use StringToolsTrait;

    public function __construct()
    {
        $this->enablePaginate = true;
        $this->perPagesPaginate = 20;
        $this->enableOrderBy = true;
        $this->methodOrderBy = 'DESC';
    }

    /**
     * Пошук тегу в таблиці
     * @param string $tag
     * @return mixed
     */
    public function searchTag(string $tag):mixed
    {
        return $this->search(Tag::class, 'name', $tag);
    }

    /**
     * Створить новий тег в таблиці
     * @param array $data
     * @return int - ід створеного тегу
     */
    public function createTag(array $data):int
    {
        $tag = new Tag();
        $tag->name = $data['name'];
        $tag->alias =  $this->translit( $data['name']);
        $tag->save();
        return (int)$tag->id;
    }

    /**
     * Поверне готовий рядок з кодом свг іконки для тегів.
     * Код готовий для вставки в hyml
     * @return string - <svg>....</svg>
     */
    static public function svgIcon():string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                  <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                  <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z"/>
                </svg>';
    }
}