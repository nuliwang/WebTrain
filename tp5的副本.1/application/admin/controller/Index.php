<?php

namespace app\admin\controller;

use app\frontend\controller\User;
use think\Controller;
use think\Session;
use think\Request;
use Think\Db;

class Index extends Controller {

    public $action;
    public $limit = 10;

    public $sex_list = [
        1 => '男',
        2 => '女',
    ];
    public $seat_list = [
        1 => '一等座',
        2 => '二等座',
        3 => '软卧',
        4 => '硬卧',
        5 => '无座',
    ];

    public function initialize() {
        $this->action = request()->action();
        // 不需要登录的 action
        $not_login_action = [
            'login',
            'logout',
            'register'
        ];
        if (!in_array($this->action, $not_login_action)) {
            // 判断session中是否存有用户信息 没有跳转到登录页
            if (empty(session('user'))) {
                $this->redirect('/admin/index/login');
            }
        }
        // 获取当前方法名 并映射到view
        $this->assign('action', $this->action);
        // 用户信息映射到 view
        $this->assign('userInfo', session('user'));
    }

    /**
     * 登陆
     */
    public function login() {
        if (!empty(session('user'))) {
           $this->redirect('/admin/index');
//         $this->success('亲爱的管理员！登陆成功',url('/admin/index'));
        }
        // 如果接收到post传值 则进行用户名密码匹配
        if (request()->isPost()) {
            $name     = input('name', '');
            $password = input('password', '');
            if (empty($name) || empty($password)) {
                $this->error('用户名或密码不可为空');
            }
            $user = Db::table('user')->where('name', $name)->where('password', $password)->find();
            if (empty($user)) {
                $this->error('用户名或密码错误');
            }

            // 用户信息存储到session
            session('user', $user);

            // 跳转到首页
            $this->success('登陆成功');
            $this->redirect('/admin/index');


        }
        return view('login');
    }

    /**
     * 登出
     */
    public function logout() {
        // 清空 sesion
        session('user', []);
        $this->redirect('/admin/index/login');
    }

    /**
     * 注册
     */
    public function register() {
        if (!empty(session('user'))) {
            $this->redirect('/admin/index');
        }
        // 如果接收到post传值 则进行用户名密码匹配
        if (request()->isPost()) {
            $name      = input('name', '');
            $password  = input('password', '');
            $password2 = input('password2', '');
            $sex       = input('sex', 1);
            $birthday  = input('birthday', '');
            $address   = input('address', '');
            $remarks   = input('remarks', '');
            if (empty($name) || empty($password)) {
                $this->error('用户名或密码不可为空');
            }
            if ($password != $password2) {
                $this->error('两次输入密码不一致');
            }
            // 检查该用户名是否已经注册
            $has = Db::table('user')->where('name', $name)->find();
            if (!empty($has)) {
                $this->error('该用户名已注册请直接登录');
            }
            $data = [
                'name' => $name,
                'password' => $password,
                'sex' => $sex,
                'birthday' => $birthday,
                'address' => $address,
                'remarks' => $remarks,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $uid = Db::table('user')->insertGetId($data);
            if ($data){
                $this->success('注册成功','login');
            }
            $data['id'] = $uid;
            // 用户信息存储到session
            session('user', $data);
            // 跳转到登录页
//            $this->success('注册成功',url('login'));
//            $this->redirect('/admin/index/login');
        }
        return view('register');
    }

    /**
     * 用户 模块
     */
    public function index() {
        // 检查登陆用户 如果非admin跳转到车次信息
        if (session('user.id') != 1){
//            $this->success('亲爱的用户！登陆成功',url('/admin/index/ticket'));

            $this->redirect('/admin/index/ticket');


        }
        $name  = input('name', '');
        $sex   = input('sex', '');
        $query = Db::table('user')->where('status', 1);
        if (!empty($name)) {
            $query->where('name', 'like', "%{$name}%");
        }
        if (!empty($sex)) {
            $query->where('sex', $sex);
        }
        $list = $query->order('create_time desc')->paginate(5, false, ['query' => request()->param()]);
//        $this->limit
        // 获取分页显示
        $page = $list->render();
        $this->assign('name', $name);
        $this->assign('sex', $sex);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('sex_list', $this->sex_list);
        return view('user_list');
    }

    /**
     * 新增用户
     */
    public function add_user() {
        // 如果接收到post传值 则进行用户添加
        if (request()->isPost()) {
            $name     = input('name', '');
            $password = input('password', '');
            $sex      = input('sex', 1);
            $birthday = input('birthday', '');
            $address  = input('address', '');
            $remarks  = input('remarks', '');
            // 检查该用户名是否已经注册
            $has = Db::table('user')->where('name', $name)->find();
            if (!empty($has)) {
                $this->error('该用户名已注册');
            }
            $data = [
                'name' => $name,
                'password' => $password,
                'sex' => $sex,
                'birthday' => $birthday,
                'address' => $address,
                'remarks' => $remarks,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            Db::table('user')->insert($data);
          $this->success('注册成功',url('/admin/index'));
//          $this->redirect('/admin/index');
        }
        return view('add_user');
    }

    /**
     * 修改用户
     */
    public function update_user() {
        $id = input('id', '');
        // 如果接收到post传值 则进行用户添加
        if (request()->isPost()) {
            $name     = input('name', '');
            $password = input('password', '');
            $sex      = input('sex', 1);
            $birthday = input('birthday', '');
            $address  = input('address', '');
            $remarks  = input('remarks', '');
            $data     = [
                'name'        => $name,
                'sex'         => $sex,
                'birthday'    => $birthday,
                'address'     => $address,
                'remarks'     => $remarks,
                'update_time' => date('Y-m-d H:i:s'),
            ];
            if (!empty($password)) {
                $data['password'] = $password;
            }
            Db::table('user')->where('id', $id)->update($data);
            $this->success('修改成功',url('/admin/index'));
//            $this->redirect('/admin/index');
        }
        $info = Db::table('user')->where('id', $id)->find();
        $this->assign('info', $info);
        return view('update_user');
    }

    /**
     * 删除用户
     */
    public function delete_user() {
        $id = input('id', '');
        if (empty($id)) {
            return getCodeJson(0);

        }
        $data = [
//            'status' => 0,
//            'update_time' => date('Y-m-d H:i:s')
        $id = input('id')
        ];


        Db::table('user')->where('id', $id)->delete($data);

        return getCodeJson(1);

    }

    /**
     * 车票 模块
     */
    public function ticket() {
        $trip = input('trip', '');
        $from = input('from', '');
        $to   = input('to', '');
        $seat = input('seat', '');
        $query = Db::table('ticket')->where('status', 1);
        if (!empty($trip)) {
            $query->where('trip', 'like', "%{$trip}%");
        }
        if (!empty($from)) {
            $query->where('from', 'like', "%{$from}%");
        }
        if (!empty($to)) {
            $query->where('to', 'like', "%{$to}%");
        }
        if (!empty($seat)) {
            $query->where('seat', $seat);
        }
        $list = $query->order('create_time desc')->paginate(5, false, ['query' => request()->param()]);
        // 获取分页显示
        $page = $list->render();
        $this->assign('trip', $trip);
        $this->assign('from', $from);
        $this->assign('to', $to);
        $this->assign('seat', $seat);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('seat_list', $this->seat_list);
        return view('ticket_list');
    }

    /**
     * 新增车票
     */
    public function add_ticket() {
        // 如果接收到post传值 则进行用户添加
        if (request()->isPost()) {
            $trip      = input('trip', '');
            $from      = input('from', '');
            $to        = input('to', 1);
            $from_time = input('from_time', '');
            $to_time   = input('to_time', '');
            $seat      = input('seat', '');
            $data      = [
                'trip'        => $trip,
                'from'        => $from,
                'to'          => $to,
                'from_time'   => $from_time,
                'to_time'     => $to_time,
                'seat'        => $seat,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            Db::table('ticket')->insert($data);
            if($data){
                $this->success('新增成功',url('/admin/index/ticket'));
            }else{
                $this->error('新增失败',url('/admin/index/ticket'));
            }
//            $this->redirect('/admin/index/ticket');
        }
        return view('add_ticket');
    }

    /**
     * 修改车票
     */
    public function update_ticket() {
        $id = input('id', '');
        // 如果接收到post传值 则进行用户添加
        if (request()->isPost()) {
            $trip      = input('trip', '');
            $from      = input('from', '');
            $to        = input('to', 1);
            $from_time = input('from_time', '');
            $to_time   = input('to_time', '');
            $seat      = input('seat', '');
            $data     = [
                'trip'        => $trip,
                'from'        => $from,
                'to'          => $to,
                'from_time'   => $from_time,
                'to_time'     => $to_time,
                'seat'        => $seat,
                'update_time' => date('Y-m-d H:i:s'),
            ];
            Db::table('ticket')->where('id', $id)->update($data);
            if($data){
                $this->success('修改成功',url('admin/index/ticket'));
            }else{
                $this->error('修改失败',url('admin/index/ticket'));
            }

//            $this->redirect('/admin/index/ticket');
        }
        $info = Db::table('ticket')->where('id', $id)->find();
        $this->assign('info', $info);
        return view('update_ticket');
    }

    /**
     * 删除车票
     */
    public function delete_ticket() {
        $id = input('id', '');
        if (empty($id)) {
            return getCodeJson(0);
        }
        $data = [
//            'status' => 0,
//            'update_time' => date('Y-m-d H:i:s')
        $id = input('id')
        ];
        Db::table('ticket')->where('id', $id)->delete($data);
        return getCodeJson(1);
    }

    /**
     * 预订车票
     */
    public function book_ticket() {
        $id = input('id', '');
        if (empty($id)) {
            $this->error('预订失败');
        }
        // 检查车次信息
        $info = Db::table('ticket')->where('status', 1)->where('id', $id)->find();
        if (empty($info)) {
            $this->error('预订失败');
        }
        $data = [
            'uid'         => session('user.id'),
            'trip'        => $info['trip'],
            'from'        => $info['from'],
            'to'          => $info['to'],
            'from_time'   => $info['from_time'],
            'to_time'     => $info['to_time'],
            'seat'        => $info['seat'],
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s'),
        ];
        Db::table('order')->insert($data);
        $this->success('预订成功');

    }

    /**
     * 订单 模块
     */
    public function order() {
        // 检查登陆用户 如果非admin跳转到车次信息
//        if (session('user.id') != 1){
//            $this->redirect('/admin/index/ticket');
//        }
        if(session('user.id') != 1){
            $user = input('user', session('user.name'));}
        else{
            $user = input('user', '');
        }
        $trip = input('trip', '');
        $from = input('from', '');
        $to   = input('to', '');
        $seat = input('seat', '');
        $query = Db::table('order')->where('status', 1);
        $uidArray = [];
        if (!empty($user)) {
            $userList = Db::table('user')->where('name', 'like', "%{$user}%")->select();
            if (!empty($userList)) {
                $uidArray = array_column($userList, 'id');
            } else {
                $uidArray = [-1];
            }
            $query->where('uid', 'in', $uidArray);
        }
        if (!empty($trip)) {
            $query->where('trip', 'like', "%{$trip}%");
        }
        if (!empty($from)) {
            $query->where('from', 'like', "%{$from}%");
        }
        if (!empty($to)) {
            $query->where('to', 'like', "%{$to}%");
        }
        if (!empty($seat)) {
            $query->where('seat', $seat);
        }


        $list = $query->order('create_time desc')->paginate(5, false, ['query' => request()->param()]);
        // 获取分页显示
        $page = $list->render();
        $user_list = [];

        foreach($list as $k => $v) {
            $userInfo = Db::table('user')->where('id', $v['uid'])->find();
            $user_list[$v['id']] = $userInfo['name'];

        }

        $this->assign('user', $user);
        $this->assign('trip', $trip);
        $this->assign('from', $from);
        $this->assign('to', $to);
        $this->assign('seat', $seat);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('user_list', $user_list);
        $this->assign('seat_list', $this->seat_list);

        return view('order_list');
    }

    /**
     * 修改车票
     */
    public function update_order() {
        $id = input('id', '');
        // 如果接收到post传值 则进行用户添加
        if (request()->isPost()) {
            $trip      = input('trip', '');
            $from      = input('from', '');
            $to        = input('to', 1);
            $from_time = input('from_time', '');
            $to_time   = input('to_time', '');
            $seat      = input('seat', '');
            $data     = [
                'trip'        => $trip,
                'from'        => $from,
                'to'          => $to,
                'from_time'   => $from_time,
                'to_time'     => $to_time,
                'seat'        => $seat,
                'update_time' => date('Y-m-d H:i:s'),
            ];
            Db::table('order')->where('id', $id)->update($data);
            if($data){
                $this->success('修改成功',url('admin/index/order'));
            }else{
                $this->error('修改失败',url('admin/index/order'));
            }
//            $this->redirect('/admin/index/order');
        }
        $info = Db::table('order')->where('id', $id)->find();
        $this->assign('info', $info);
        return view('update_order');
    }

    /**
     * 删除车票
     */
    public function delete_order() {
        $id = input('id', '');
        if (empty($id)) {
            return getCodeJson(0);
        }
        $data = [
            $id = input('id')
        ];
        Db::table('order')->where('id', $id)->delete($data);
        return getCodeJson(1);
    }
}
