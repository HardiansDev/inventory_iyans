<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table = 'educations';

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'employee_id',
        'education_level',
        'institution_name',
        'major',
        'start_year',
        'end_year',
        'certificate_number',
        'gpa',
    ];

    // Relasi ke tabel employees (Many-to-One)
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
