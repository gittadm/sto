<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Finance
 *
 * @property int $id
 * @property string $name
 * @property int $finance_group_id
 * @property string $operation_type
 * @property int $sum
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinanceGroup $financeGroup
 * @method static \Database\Factories\FinanceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Finance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Finance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Finance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereFinanceGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereOperationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $department_id
 * @property-read \App\Models\Department|null $department
 * @method static \Illuminate\Database\Eloquent\Builder|Finance whereDepartmentId($value)
 */
class Finance extends Model
{
    use HasFactory;

    public const OPERATION_INPUT = 'in';
    public const OPERATION_OUTPUT = 'out';

    protected $guarded = ['id'];

    protected $casts = [
        'sum' => 'integer',
        'finance_group_id' => 'integer',
        'department_id' => 'integer'
    ];

    /* relations */

    public function financeGroup()
    {
        return $this->belongsTo(FinanceGroup::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
