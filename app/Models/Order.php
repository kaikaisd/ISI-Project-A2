<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }

    public static function statusFormat($status)
    {
        switch ($status) {
            case -1:
                return 'Cancelled';
            case 1:
                return 'Pending';
            case 2:
                return 'On Hold';
            case 3:
                return 'Delivered';
            default:
                return 'Unknown';
        }
    }
}
