<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class BaseService
{

    /**
     * Вмикає розбивання записів на сторінки
     * @var bool
     */
    protected bool $enablePaginate;

    /**
     * Кількість записів на сторінку, за замовчуванням 20
     * @var int
     */
    protected int $perPagesPaginate;

    /**
     * Вмикає слртування, за замовчування увімкнено
     * @var bool
     */
    protected bool $enableOrderBy;

    /**
     * Медод сортування desc, або asc. За замовчуванням DESC
     * @var string
     */
    protected string $methodOrderBy;


    /**
     * @param bool $enablePaginate
     */
    public function setEnablePaginate(bool $enablePaginate): void
    {
        $this->enablePaginate = $enablePaginate;
    }

    /**
     * @return bool
     */
    public function isEnablePaginate(): bool
    {
        return $this->enablePaginate;
    }

    /**
     * @param int $perPagesPaginate
     */
    public function setPerPagesPaginate(int $perPagesPaginate): void
    {
        $this->perPagesPaginate = $perPagesPaginate;
    }

    /**
     * @return int
     */
    public function getPerPagesPaginate(): int
    {
        return $this->perPagesPaginate;
    }

    /**
     * @param string $methodOrderBy
     */
    public function setMethodOrderBy(string $methodOrderBy): void
    {
        $methodOrderBy = trim($methodOrderBy);
        $methodOrderBy = (strtolower($methodOrderBy) === 'desc') ? 'DESC' : 'ASC';
        $this->methodOrderBy = $methodOrderBy;
    }

    /**
     * @return string
     */
    public function getMethodOrderBy(): string
    {
        return $this->methodOrderBy;
    }

    /**
     * @return bool
     */
    public function isEnableOrderBy(): bool
    {
        return $this->enableOrderBy;
    }

    /**
     * @param bool $enableOrderBy
     */
    public function setEnableOrderBy(bool $enableOrderBy): void
    {
        $this->enableOrderBy = $enableOrderBy;
    }

    protected function getAllItems($model)
    {
        $items = $model::all();
        if ($this->isEnablePaginate() && !$this->isEnableOrderBy()) {
            $items = $model::paginate($this->getPerPagesPaginate());
        }
        if ($this->isEnableOrderBy() && !$this->isEnablePaginate()) {
            $items = $model::orderBy('created_at', $this->getMethodOrderBy())->get();
        }
        if ($this->isEnableOrderBy() && $this->isEnablePaginate()) {
            $items = $model::orderBy('created_at', $this->getMethodOrderBy())
                ->paginate($this->getPerPagesPaginate());
        }
        return $items;
    }

    /**
     * Метод для пошуку в таблиці на визначені колонці
     * @param $model - Клас моделі таблиці
     * @param string $column - Колонка по якій буде пошук
     * @param string $searchText - що саме шукати
     * @return mixed - поверне залежно від налаштувань - колекцію, ябо пагіновиний резельтат
     */
    protected function search($model, string $column, string $searchText):mixed
    {
        $func = ($this->isEnablePaginate()) ? 'paginate' : 'get';
        return $model::where($column, 'like', '%'. $searchText .'%')->get();
//            ->$func( ($this->isEnablePaginate()) ? $this->getPerPagesPaginate() : null ) ;
    }

    /**
     * Метод для видалення запису з бази
     * @param $model
     * @param int $idItemDeleted
     * @return bool
     */
    protected function delete($model, int $idItemDeleted):bool
    {
        $item = $model::find($idItemDeleted);
        if ($item) {
            $item->delete();
            return true;
        } else {
            return false;
        }
    }

}
