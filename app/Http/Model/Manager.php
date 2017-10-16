<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{

    //模型关联表
    protected $table = 'manager';

//    表的主键
    public $primaryKey = 'manager_id';
//    允许操作的字段
    protected $fillable = ['manager_name', 'manager_pwd'];

//    不允许批量操作的字段
    protected $guarded = [];

//    是否维护时间字段
    public $timestamps = false;
}
