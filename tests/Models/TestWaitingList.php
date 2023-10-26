<?php 

namespace tests\Models;
use Illuminate\Database\Eloquent\Model;

class TestWaitingList extends Model
{

    protected $connection = "testing";

    protected $table = 'waitinglist';

    protected $fillable = [
        'email',
        'position',
        'status'
    ];
    
}