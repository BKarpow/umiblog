<?php


namespace App\Services;


use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Сервісний клас бізнес-логіки для користувачів.
 * Class UserService
 * @package App\Services
 */
class UserService extends BaseService
{

    public function __construct()
    {
        $this->enablePaginate = true;
        $this->perPagesPaginate = 20;
        $this->enableOrderBy = true;
        $this->methodOrderBy = 'DESC';
    }

    /**
     * Видаляє користувача по його іж
     * @param $userId
     * @return bool
     */
    public function deleteUser($userId)
    {
        $userId = abs( (int)$userId );
        return $this->delete(User::class, $userId);
    }

    /**
     * Оноалює користувача по id, вказаному в параметрі масиву $data['userId']
     * @param array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        $uid = abs(intval($data['userId'])) ?? false;
        $user = User::find($uid);
        if (!$uid || !$user) {
            return false;
        }
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->save();
        return true;
    }

    /**
     * Метод створить нового користувача та поверне його id
     * @param $request
     * @return int
     */
    public function createNewUser($request): int
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = ($request->role == 0) ? User::ROLE_USER : (int)$request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        return (int)$user->id;
    }


    /**
     * Поверне спосок користувачів.
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return $this->getAllItems(User::class);
    }

    /**
     * Встановить роль адміна для користувача
     * @param User $user
     */
    public function setRoleAdmin(User $user): void
    {
        $this->setRole($user, User::ROLE_ADMIN);
    }

    /**
     * Встановить роль модератора для користувача
     * @param User $user
     */
    public function setRoleModer(User $user): void
    {
        $this->setRole($user, User::ROLE_ADMIN);
    }

    /**
     * Встановить роль звичайного користувача для користувача
     * @param User $user
     */
    public function setRoleUser(User $user): void
    {
        $this->setRole($user, User::ROLE_ADMIN);
    }

    /**
     * Служблва функція для встановлення ролей
     * @param User $user
     * @param int $role
     */
    private function setRole(User $user, int $role): void
    {
        $user->role = $role;
        $user->save();
    }

}

