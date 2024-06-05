<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingAbsence extends Model
{
    use HasFactory, HasUlids;
    protected $guarded = ['id'];
    public function profile()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
