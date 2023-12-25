<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\SubDistrict;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $primaryKey = 'code';
    public $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'fullname',
        'username',
        'gender',
        'phone', 
        'place_of_birth',
        'date_of_birth',
        'address', 
        'is_active', 
        'email',
        'password',
        'created_at', 
        'updated_at', 
    ];

    public function getUserProfile() {
        $code = auth('customer')->user()->code;
        $data = DB::table('customers')
            ->select('customers.*')
            ->where(['code' => $code])
            ->first();
        return $data;
    }

    public function getUserProfileById($code) {
        $data = DB::table('customers')
            ->select('customers.*')
            ->where(['code' => $code])
            ->first();
        return $data;
    }
}
