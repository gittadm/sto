<?php

namespace App\Services\Departments;

use App\Models\Department;
use Illuminate\Support\Collection;

class DepartmentService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Department::orderBy('name')->get();
    }

    /**
     * @param  array  $data
     * @return Department
     */
    public function store(array $data): Department
    {
        return Department::create($data);
    }

    /**
     * @param  int  $departmentId
     * @return Department
     */
    public function getDepartmentById(int $departmentId): Department
    {
        return Department::findOrFail($departmentId);
    }

    /**
     * @param  int  $departmentId
     * @param  array  $data
     * @return Department
     */
    public function update(int $departmentId, array $data): Department
    {
        $department = $this->getDepartmentById($departmentId);
        $department->update($data);

        return $department;
    }

    /**
     * @param  int  $departmentId
     */
    public function delete(int $departmentId): void
    {
        Department::where('id', $departmentId)->delete();
    }
}
