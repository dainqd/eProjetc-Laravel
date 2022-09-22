<?php


namespace App\Services;

use App\Models\ExtraClass;
use App\Models\Group;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseService
{
    protected $modelClass;
    protected Model $model;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        if ($this->modelClass) {
            $this->model = app()->make($this->modelClass);
        }
    }

    public function listAll(): Collection|array
    {
        return $this->model->newQuery()->get();
    }

    public function list(int $perPage): LengthAwarePaginator
    {
        return $this->model->newQuery()->paginate($perPage);
    }

    public function listByGroup(Group $group, int $limit): LengthAwarePaginator
    {
        return $this->model->newQuery()->where('group_id', $group->id)->paginate($limit);
    }

    public function find(int $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function findByAttribute(string $attr, mixed $data): Model | null
    {
        return $this->model->newQuery()->where($attr, $data)->first();
    }

    public function store(mixed $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(mixed $data, Model $model): Model
    {
        $model->fill($data);
        $model->save();
        $model->refresh();
        return $model;
    }

    public function destroy(Model $model): Model
    {
        $model->delete();
        return $model;
    }

    public function listDeleted(): Collection|array
    {
        return $this->model->onlyTrashed()->get();
    }

    public function findByIdWithTrash(int|string $id): Model
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    public function restoreById(int|string $id): Model
    {
        $result = $this->model->withTrashed()->findOrFail($id);
        $result->restore();
        $result->refresh();
        return $result;
    }
}
