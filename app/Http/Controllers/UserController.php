<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        return view('panel.user.index', [
            'users' => $this->userService->getAllUsers(),
            'isPaginate' => $this->userService->isEnablePaginate(),
        ]);
    }

    function delete($user_id) {
        $ok = $this->userService->deleteUser($user_id);
        return redirect()->route('panel.user.index')->with('status', 'Користувача видалено!');
    }

    function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:30',
            'phone' => 'required|max:30',
            'email' => 'required|email',
            'role' => 'required|max:5',
            'userId' => 'required|exists:users,id',
            'password' => 'max:300',
        ]);
        $ok = $this->userService->update($data);
        return response()->json(['ok' => $ok]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:7',
        ]);
        $newUserId = $this->userService->createNewUser($request);
        return response()->json(['ok' => true, 'newUserId' => $newUserId]);
    }
}
