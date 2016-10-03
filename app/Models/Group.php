<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public $timestamps = false;

    public function courseOpened()
    {
        return $this->belongsTo(CourseOpened::class);
    }

    public function classes()
    {
        return $this->hasMany(Clase::class);
    }

    public function students()
    {
       return $this->belongsToMany(Student::class,'students_x_groups','group_id','student_id');
    }
}