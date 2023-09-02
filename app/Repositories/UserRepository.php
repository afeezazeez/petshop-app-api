<?php

namespace App\Repositories;

use App\Filters\ModelsFilter;
use App\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Arr;


class UserRepository implements IUserRepository
{

    protected User $model;
    /**
     * @var int|mixed
     */
    private mixed $page;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    private mixed $limit;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->page  = request()->page ?? 1;
        $this->limit = request()->limit ?? config('app.default_pagination');
    }


    /**
     * Find admin by email
     *
     * @param string $email
     * @return User|null
     */
    public function findAdminByEmail(string $email): User|null
    {
        return $this->model->where('email', $email)
            ->where('is_admin',1)->first();
    }

    /**
     * Find user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findUserByEmail(string $email): User|null
    {
        return $this->model->where('email', $email)
            ->where('is_admin',0)->first();
    }



    /**
     * Create admin
     * @param array<string,mixed> $data
     * @return User
     */
    public function createAdmin(array $data): User
    {
        $data = Arr::add($data, 'is_admin', 1);
        return $this->model->create($data);
    }

    /**
     * Create user account
     * @param array<string,mixed> $data
     * @return User
     */
    public function createUserAccount(array $data): User
    {
        $data = Arr::add($data, 'is_admin', 0);
        return $this->model->create($data);
    }

    /**
     * fetch users
     *@return array<string, mixed>
     */
    public function fetchUsers():array
    {
        $query = User::query();
        $users = app(Pipeline::class)
                ->send($query)
                ->through([ModelsFilter::class])
                ->via('process')
                ->thenReturn()
                ->where('is_admin',0)
                ->paginate($this->limit,['*'],'page',$this->page)
                ->toArray();
        return $users;
    }

    /**
     * update user
     */
    public function updateUser(string $uuid,array $data):User
    {
        $user = User::where('uuid',$uuid)->firstorfail();
        $user->update($data);
        return $user;
    }

    /**
     * update user
     * @param array<string,mixed> $data
     */
    public function updateUserAccount(array $data): User|null
    {
        $user = auth()->user();
        if ($user){
            $user->update($data);
        }
        return $user;
    }


    /**
     * delete user
     */
    public function deleteUser(string $uuid):void
    {
       User::where('uuid',$uuid)->delete();

    }

    /**
     * delete authenticated user account
     */
    public function deleteAuthUser():void
    {
        if (auth()->user()){
            auth()->user()->delete();
        }
    }





}
