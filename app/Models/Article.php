<?php

namespace App\Models;

use App\Services\TagService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Поверне масив тегів
     * @return array
     */
    public function getTags():array
    {
        return json_decode($this->tags, true);
    }


    /**
     * Формує рядок тегів
     * @param string $before
     * @param string $after
     * @param bool $icon
     * @param string $separator
     * @return string
     */
    public function tagsToString(string $before = '<span>',
                                 string $after = '</span>',
                                 bool $icon = true,
                                 string $separator = ', ' ):string
    {
        $_SESSION['before_tag'] = $before;
        $_SESSION['icon_tag'] = $icon;
        $_SESSION['after_tag'] = $after;
        $namesArrayFromTags = array_map(function($item){
            if (isset($item['name'])) {
                $tag = ($_SESSION['icon_tag']) ?  TagService::svgIcon().$item['name'] : $item['name'];
                return $_SESSION['before_tag'] . $tag . $_SESSION['after_tag'];
            } elseif (!empty($item) && is_string($item)) {
                $name = TagService::getNameTagFromAlias($item);
                if (empty($name) ) {
                    return '';
                }
                $tag = ($_SESSION['icon_tag']) ?  TagService::svgIcon().$name : $name;
                return $_SESSION['before_tag'] . $tag . $_SESSION['after_tag'];
            } else {
                return '';
            }
        }, $this->getTags());
        $_SESSION['before_tag'] = null;
        $_SESSION['icon_tag'] = null;
        $_SESSION['after_tag'] = null;
        return implode($separator, $namesArrayFromTags);
    }

    /**
     * Поверне скорочений текст до 255 символів, та очистить його від тегів.
     * @return string
     */
    public function shortContent():string
    {

        return mb_substr( strip_tags( $this->short_content ), 0, 255 );
    }

    /**
     * Метод поверне посилання на повну статтю
     * @return string
     */
    public function href():string
    {
        $text = (string)$this->id . '-' . $this->url.'.html';
        return route('article.show', ['url'=>$text]);
    }

    /**
     * Повертає сформовану дату публікації для статті
     * @return string
     */
    public function getCreateDate():string
    {
        return $this->created_at->format('Y-m-d H:i');
    }

    /**
     * Поверне імя автора статті
     * @return string
     */
    public function getAuthorName():string
    {
        return $this->author->name;
    }

    /**
     * Метод звязку з таблицею користувачів
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne('\App\Models\User', 'id', 'author_id');
    }

    /**
     * Поверне список посилань для тегів статті
     * @return string
     */
    public function getTagsString():string
    {
        $tagsString = '';
        $tags = json_decode($this->tags, true);
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $href = route('article.tag', ['tag' => $tag]);
                $tagsString .= "<a href='{$href}'>{$tag}</a>".PHP_EOL;
            }
        }
        return $tagsString;
    }
}
