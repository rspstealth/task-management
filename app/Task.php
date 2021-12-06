<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tasks';
    public $sortable = [
        'priority',
    ];
    protected $fillable = [
        'task_name',
        'project',
        'priority',
    ];

}
