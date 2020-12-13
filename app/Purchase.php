<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['name', 'code', 'host', 'licence', 'ip', 'url', 'time', 'buyer', 'supported_until', 'status'];
}
