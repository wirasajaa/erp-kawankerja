<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory, HasUlids;
    protected $guarded = ['id'];

    public function getEducations($employee_id = null, $perPage = 5)
    {
        return $this->where('employee_id', $employee_id)->orderBy('education_level', 'desc')->paginate($perPage);
    }
}
