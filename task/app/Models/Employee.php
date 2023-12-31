<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Events\UserRegisteredEvent;

class Employee extends Model
{
    use HasFactory , Notifiable ;

    // protected $fillable = ['name','email','password','company_id','image'];

    function  company(){

        return $this->belongsTo(Company::class);
    }

    protected $dispatchesEvents = [
        'created' => UserRegisteredEvent::class,
    ];

}
