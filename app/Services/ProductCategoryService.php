<?php


namespace App\Services;


use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryService extends BaseService implements ServiceInterface
{

    public function __construct()
    {
        $this->enablePaginate = true;
        $this->perPagesPaginate = 20;
        $this->enableOrderBy = true;
        $this->methodOrderBy = 'DESC';
    }

    public function validateNewItem(Request $request): array
    {
        // TODO: Implement validateNewItem() method.
        return $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'string|max:250',
            'image' => 'max:250',
            'section_id' => 'required|exists:product_sections,id',
        ]);
    }

    public function createNewItem(array $data): bool
    {
        // TODO: Implement createNewItem() method.
        $cat = new ProductCategory();
        $cat->name = $data['name'];
        $cat->alias = TranslitService::convert($data['name']);
        $cat->description = $data['description'];
        $cat->image = $data['image'];
        $cat->section_id = $data['section_id'];
        return $cat->save();
    }

    public function updateItem(int $itemId, array $data): bool
    {
        $cat = ProductCategory::find($itemId);
        if ($cat) {
            $cat->name = $data['name'];
            $cat->description = $data['description'];
            if (isset($data['image'])) {
                $cat->image = $data['image'];
            }
            return $cat->save();
        } else {
            return false;
        }
    }

    public function deleteItem(int $itemId): bool
    {
        $cat = ProductCategory::find($itemId);
        if ($cat) {
            $cat->delete();
            return true;
        } else {
            return false;
        }
    }

    public function getAllItemFromPanel(): mixed
    {
        // TODO: Implement getAllItemFromPanel() method.
    }
}
