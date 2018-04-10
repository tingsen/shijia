<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class LoginController extends BaseController {
	
    public function index(){
		if(is_login()){
			redirect(U('home/index/index'), 1, '页面跳转中...');
		}else{
			$this->assign('css_header_material', true);
			$this->display();
		}
	}
	
	public function signup(){
		if(is_login()){
			redirect(U('home/index/index'), 2, '页面跳转中...');
		}else{
			$this->assign('css_header_material', true);
			$this->display();
		}
	}
	/*
	public function create(){
		if(IS_POST){
			$data = array(
				'email' => I('post.email','','strtolower'),
				'nickname' => I('post.nickname','', 'htmlspecialchars'),
				'password' => I('post.password'),
				'repassword' => I('post.repassword')
			);
			$db = D('User');
			$db->where(array('email'=>I('post.email','','strtolower')))->find();
			if (!$db->create($data)){
				$this->error($db->getError());
			}else{
				$db->add();
				$this->success('注册成功...', U('home/login/index'));
			}
		}else{
			$this->error('请注册用户');
		}
	}
	*/
	
	public function create(){
		if(IS_POST){
			$data = array(
				'email' => I('post.email','','strtolower'),
				'nickname' => I('post.nickname','', 'htmlspecialchars'),
				'password' => I('post.password'),
				'repassword' => I('post.repassword')
			);
			$db = D('User');
			$db->where(array('email'=>I('post.email','','strtolower')))->find();
			if (!$db->create($data)){
				$this->error($db->getError());
			}else{
				$user_id = $db->add();
				//邮箱验证
				$getpasstime = time();
				$rnd = rand(2014,$getpasstime);
				$token = md5($data['email'].$data['password'].$rnd);
				$org = C('DOMAIN');
				$url = $org."/home/email/activate?type=2&email=".$data['email']."&token=".$token;//构造URL 
		
				$time = date('Y-m-d H:i');
				$emailbody = "亲爱的".$data['email']."：<br/>您在".$time."注册十佳网站。请点击下面的链接激活帐号 
		（按钮24小时内有效）。<br/><a href='".$url."'target='_blank'>".$url."</a>";
				$mail = new \Think\Mail();
				//邮箱地址换成自己的
				$result = $mail->SendMail($data['email'],'激活账户',$emailbody,'十佳网站');
				if($result == 1){
					$a = array(
						'uid' => $user_id,
						'email' => $data['email'],
						'getpasstime' => $getpasstime,
						'token' => $token,
						'type' => 2
					);
					$email = D('Email');
					$email->add($a);
					//提示跳转
					$this->success('注册成功,请先登录激活账户', U('home/login/index'));
				}else{
					redirect(U('home/email/verification'), 3, '激活邮件未发送成功,请重新发送激活邮件');
				}
			}
		}else{
			$this->error('请注册用户');
		}
	}
	
	public function login(){
		if(!IS_POST){
			$this->error('请填写用户名或密码');
		}
		$code = I('verify');
		$verify = new \Think\Verify();
		$a = $verify->check($code);
		if (!$a){
			$this->error('验证码不正确','index');
		}
		$db = D('User');
		$user = $db->where(array('email'=>I('post.email','','strtolower')))->find();
		if(!$user || I('post.password','','md5') != $user['password']){
			$this->error('用户名或密码不正确','index');
		}
		if(!$user || $user['activation'] != 2){
			$this->error('你的帐号还没有激活，请激活帐号','index');
		}
		$data = array(
			'id' => $user['id'],
			'last_time' => time(),
			'login_ip' => get_client_ip()
		);
		$db->save($data);
		$token = md5($user['id'].$user['password'].C('DES_SESSION_KEY_TOKEN'));
		session('uid',$user['id']);
		session('name',$user['nickname']);
		session('token',$token);
		if($user['role_id'] == 3){
			$this->success('登录成功!', U('home/rater/index'));
		}else{
			$this->success('登录成功!', U('home/index/index'));
		}
		//redirect(U('home/index/index'));
	}
	
	public function logout(){
		sign_out();
	}
	
	public function verify(){
		$config = array(
			'fontSize' => 16, // 验证码字体大小
			'length' => 4, //验证码字数
			'useNoise' => false, // 关闭验证码杂点
		);
        $Verify = new \Think\Verify($config);
		$Verify->entry();
    }

	//ajax验证邮箱存在否
	public function ajax_validate_email() {
		$email = I('post.email');
		$user = D('User')->where(array('email'=>strtolower($email)))->find();
		if(empty($user)) {
			$b = true;
		}else{
			$b = false;
		}
		$this->ajaxReturn($b);
	}
}
