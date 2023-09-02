<?php

namespace App\Repositories;

use App\Filters\ModelsFilter;
use App\Interfaces\IUserRepository;
use App\Models\User;
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
     * Find user by email
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

}
