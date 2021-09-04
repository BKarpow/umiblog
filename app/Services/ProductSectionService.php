<?php


namespace App\Services;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use App\Models\ProductSection;
use App\Http\Responses\ApiResponse;


class ProductSectionService extends BaseService implements ServiceInterface
{
    public function __construct()
    {
        $this->enablePaginate = true;
        $this->perPagesPaginate = 20;
        $this->enableOrderBy = true;
        $this->methodOrderBy = 'DESC';
    }

    /**
     * Validate create new item
     * @param Request $request
     * @return array
     */
    public function validateNewItem(Request $request):array
    {
        return $request->validate([
            'name' => 'required|string|max:50|min:2',
            'description' => 'string|max:250',
            'image' => 'max:250',
        ]);
    }

    /**
     * Create new item
     * @param array $data
     * @return bool
     */
    public function createNewItem(array $data): bool
    {
        // TODO: Implement createNewItem() method.
        $productSection = new ProductSection();
        $productSection->name = $data['name'];
        $productSection->alias = TranslitService::convert($data['name']);
        $productSection->description = $data['description'];
        if (isset($data['image'])) {
            $productSection->image = $data['image'];
        }
        return (bool)$productSection->save();
    }

    public function deleteItem(int $itemId): bool
    {
        // TODO: Implement deleteItem() method.
        return $this->delete(ProductSection::class, $itemId);
    }

    public function getAllItemFromPanel(): mixed
    {
        // TODO: Implement getAllItemFromPanel() method.
        return $this->getAllItems(ProductSection::class);
    }

    public function updateItem(int $itemId, array $data): bool
    {
        // TODO: Implement updateItem() method.
        $productSection = ProductSection::find($itemId);
        if (!$productSection) {
            return false;
        }
        $productSection->name = $data['name'];
        $productSection->alias = TranslitService::convert($data['name']);
        $productSection->description = $data['description'];
        if (isset($data['image'])) {
            $productSection->image = $data['image'];
        }
        return (bool)$productSection->save();
    }

    public function getAllItemsForApi():ApiResponse
    {
        $data = ProductSection::orderBy('id', 'desc')->get();
        if (!$data) {
            return new ApiResponse(false, 'No match sections!');
        }
        return new ApiResponse(true, 'Section product', $this->formatForApi($data));
    }

    public function formatForApi($coll):array
    {
        $data = [];
        foreach ($coll as $item) {
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
                'alias' => $item->alias,
                'categories' => $item->categories()->orderBy('created_at', 'desc')->get(),
                'description' => $item->description,
                'image' => $item->image,
                'created' => $item->dateCreate(),
                'updated' => $item->dateUpdate(),
            ];
        }
        return $data;
    }
}
