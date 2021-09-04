<?php


namespace App\Services;
use Illuminate\Http\Request;


interface ServiceInterface
{
    public function validateNewItem(Request $request):array;
    public function createNewItem(array $data):bool;
    public function updateItem(int $itemId, array $data):bool;
    public function deleteItem(int $itemId):bool;
    public function getAllItemFromPanel():mixed;
}
