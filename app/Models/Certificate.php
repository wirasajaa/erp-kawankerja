<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory, HasUlids;
    protected $guarded = ['id'];

    public function getCertificates($employee_id = null, $perPage = 6)
    {
        return $this->where('employee_id', $employee_id)->paginate($perPage);
    }
}
