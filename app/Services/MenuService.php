<?php


namespace App\Services;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuService extends BaseService
{
    use StringToolsTrait;

    public function __construct()
    {
        $this->enablePaginate = true;
        $this->perPagesPaginate = 10; // кількісит сикивй на сторінці
        $this->enableOrderBy = true;
        $this->methodOrderBy = 'DESC';
    }

    /**
     * Поверне список всіх меню
     * @return mixed
     */
    public function getAllMenus():mixed
    {
        return $this->getAllItems(Menu::class);
    }


    /**
     * Метод валідації створення нового пункта меню
     * @param Request $request
     * @return array
     */
    public function validateCreateNew(Request $request):array
    {
        return $request->validate([
            'name_menu' => 'string|max:100',
            'alias_menu' => 'string|max:100',
            'href' => 'required|string|max:166',
            'title' => 'required|string|max:166',
            'target' => 'string',
            'route' => 'string',
        ]);
    }

    /**
     * Метод створить пункт меню в базі
     * @param array $data
     * @return int
     */
    public function createNew(array $data):int
    {
        $menu = new Menu();
        if (isset($data['name_menu'])){
            $menu->name_menu = $data['name_menu'];
            $menu->alias_menu = $this->translit($data['name_menu']);
        }
        $menu->href = $data['href'];
        $menu->title = $data['title'];
        if (isset($data['target'])) {
            $menu->target = '_blank';
        }
        if (isset($data['route'])){
            $menu->route = true;
        }
        $menu->save();
        return (int)$menu->id;
    }

    /**
     * Метод поверне список всіх імен меню.
     * @return mixed
     */
    public function getAllMenuNames():mixed
    {
        return Menu::select('name_menu')
            ->groupBy('name_menu')->get();
    }

    /**
     * Метод поверне пункти меню по назві меню
     * @param string $nameMenu
     * @return mixed
     */
    public function getItemsFromNameMenu(string $nameMenu)
    {
        return Menu::where('alias_menu', '=', $this->translit($nameMenu))->get();
    }

    /**
     * Метод видалить пункт меню по його ід
     * @param $id
     * @return bool
     */
    public function deleteMenu($id):bool
    {
        $id = abs( (int)$id );
        return  $this->delete(Menu::class, $id);
    }

}
