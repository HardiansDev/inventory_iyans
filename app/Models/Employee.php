<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number',
        'name',
        'age',
        'email',
        'phone',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'address_ktp',
        'religion',
        'marital_status',
        'nationals',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'photo',
        'department_id',
        'position_id',
        'status_id',
        'date_joined',
        'is_active',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function status()
    {
        return $this->belongsTo(EmploymentStatus::class, 'status_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}
