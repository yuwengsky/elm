<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Manager;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

require_once app_path().'/Http/Org/code/Code.class.php';
use App\Http\Org\code\Code;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //后台登录页面显示
    public function login()
    {
        return view('admin/login');
    }

    //生成验证码
    public function yzm()
    {
        $code = new Code();
        $code->make();
    }

    //后台登录处理
    public function dologin(Request $request)
    {
        //1.接收用户提交过来的数据
        $input = $request ->except('_token');
        //2.对提交过来的数据进行表单验证，用户名必须在4-18位之间，密码必须子啊4-18位之间
        //validator::make('要进行表单验证的数据','验证规则','设置提示信息');
        $rules = [
            'manager_name'=>'required|between:4,18',
            'manager_pwd'=>'required|between:4,18'
        ];

        $msg = [
            'manager_name.required'=>'用户名必须输入',
            'manager_name.between'=>'用户名必须在4-18位',
            'manager_pwd.required'=>'用户必须输入',
            'manager_pwd.between'=>'用户密码必须在4-18位',
        ];

        //进行手动表单验证
        $validator = Validator::make($input,$rules,$msg);
        //如果验证失败
        if($validator->fails()){
            return redirect('admin/login')
            ->withErrors($validator)
            ->withInput();
        }

        //进行逻辑验证
            // 1.验证码是否正确
        if($input['code'] != session('code')){
            return redirect('admin/login')->with('errors','验证码错误')->withInput();
        }
//            3.1 用户名是否存在
        $manager = Manager::where('manager_name','=',$input['manager_name'])->first();

        if(!$manager){
            return redirect('admin/login')->with('errors','此用户不存在')->withInput();
        }
//            3.2 密码是否正确
//        dd($user);
        if(Crypt::decrypt($manager->manager_pwd) != $input['manager_pwd']){
            return redirect('admin/login')->with('errors','密码错误')->withInput();
        }
//        4.将登录用户的状态值保存到session中
//        session_start();
//        $_SESSION['user'] = 'zhangsan';
//        写入一条数据到session中
//        session(['key' => 'value']);
//        dd(session('key'));
//        将用户信息存入到session中
        session(['manager'=>$manager]);
//        5.进入后台首页
        return redirect('admin/index');
    }

    
   
}
