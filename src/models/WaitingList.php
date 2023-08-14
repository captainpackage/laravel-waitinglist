<?php 

namespace equativa\LaravelWaitinglist\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $table = 'waitinglist';

    protected $fillable = [
        'email',
        'position',
        'status'
    ];
    
}