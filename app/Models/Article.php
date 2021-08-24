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
}
