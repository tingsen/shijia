<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class EmailController extends BaseController {
	
	function forget(){
		if(is_login()){
			redirect(U('Index/index'), 3, '页面跳转中...');
		}else{
			$this->display();
		}
	}
	
	function verification(){
		if(is_login()){
			redirect(U('Index/index'), 3, '页面跳转中...');
		}else{
			$this->display();
		}
	}
	
	function jihuo(){
		if(!IS_POST){
			$this->error('请填写邮箱');
		}
		$db = D('User');
		$user = $db->where(array('email'=>I('post.email','','strtolower')))->find();
		if(!$user || $user['activation'] == 2){
			$this->error('用户已经激活 或者你还没有注册');
		}
		//邮箱验证
		$getpasstime = time();
		$rnd = rand(2014,$getpasstime);
		$token = md5($user['email'].$user['password'].$rnd);
		$org = C('DOMAIN');
		$url = $org."/home/email/activate?type=2&email=".$user['email']."&token=".$token;//构造URL 

		$time = date('Y-m-d H:i');
		$emailbody = "亲爱的".$user['email']."：<br/>您在".$time."注册十佳网站。请点击下面的链接激活帐号 （按钮24小时内有效）。<br/><a href='".$url."'target='_blank'>".$url."</a>";
		$mail = new \Think\Mail();
		//邮箱地址换成自己的
		$result = $mail->SendMail($user['email'],'激活账户',$emailbody,'十佳网站');
		if($result == 1){
			$a = array(
				'uid' => $user['id'],
				'email' => $user['email'],
				'getpasstime' => $getpasstime,
				'token' => $token,
				'type' => 2
			);
			$email = D('Email');
			$map['uid'] = $user['id'];
			$map['email'] = $user['email'];
			$up = $email->where($map)->find();
			if($up){
				$email->where(array('uid'=>$user['id']))->save($a);
				$this->success('激活邮件重新发送成功，请查看邮件');
			}else{
				$email->add($a);
				$this->success('激活邮件发送成功，请查看邮件');
			}
		}else{
			$this->error('激活邮件未发送成功,请稍后再试');
		}
	}
	
	function activate(){
		$type = stripslashes(trim($_GET['type']));
		$email = stripslashes(trim($_GET['email']));
		$token = stripslashes(trim($_GET['token']));
		
		$db = D('Email');
		$map['type'] = $type;
		$map['email'] = $email;
		$map['token'] = $token;
		$user = $db->where($map)->find();
		if($user){
			if(time()-$user['getpasstime']>24*60*60){ 
	            redirect(U('login/index'), 3, '该链接已过期');
	        }elseif($token != $user['token']){
				redirect(U('login/index'), 3, '该链接错误 请重新发送');
			}else{
				$u = D('User');
				if($u->where(array('id' => $user['uid']))->setField('activation',2)){
					$db->where($map)->delete();
					$this->success('激活成功,请登录', U('home/login/index'));
				}
	        }
		}else{
			redirect(U('home/login/index'), 3, '该链接错误');
		}
	}
	
	function resend(){
		if(!IS_POST){
			$this->error('请填写邮箱');
		}
		$db = D('User');
		$user = $db->where(array('email'=>I('post.email','','strtolower')))->find();
		if(!$user){
			$this->error('没有该用户');
		}
		$getpasstime = time();
		$rnd = rand(1000,$getpasstime);
		$token = md5($user['email'].$user['password'].$rnd);
		$org = C('DOMAIN');
		$url = $org."/home/email/up_password?type=1&email=".$user['email']."&token=".$token;//构造URL 

		$time = date('Y-m-d H:i');
		$emailbody = "亲爱的".$user['email']."：<br/>您在".$time."提交了找回密码请求。请点击下面的链接重置密码 
（按钮24小时内有效）。<br/><a href='".$url."'target='_blank'>".$url."</a>";
		$mail = new \Think\Mail();
		//邮箱地址换成自己的
		$result = $mail->SendMail($user['email'],'十佳网站',$emailbody,'十佳网站');
		if($result == 1){
			$data = array(
				'uid' => $user['id'],
				'email' => $user['email'],
				'getpasstime' => $getpasstime,
				'token' => $token,
				'type' => 1
			);
			$email = D('Email');
			$map['uid'] = $user['id'];
			$map['email'] = $user['email'];
			$up = $email->where($map)->find();
			if($up){
				$email->where(array('uid'=>$user['id']))->save($data);
				$this->success('重新发送成功，请查看邮件');
			}else{
				$email->add($data);
				$this->success('发送成功，请查看邮件');
			}
		}else{
			$this->error('邮件发送失败');
		}
	}
	
	function up_password(){
		$token = stripslashes(trim($_GET['token'])); 
		$email = stripslashes(trim($_GET['email']));
		
		$db = D('Email');
		$map['email'] = $email;
		$map['$token'] = $token;
		$user = $db->where($map)->find();
		if($user){
			if(time()-$user['getpasstime']>24*60*60){ 
	            redirect(U('login/index'), 3, '该链接已过期');
	        }elseif($token != $user['token']){
				redirect(U('login/index'), 3, '该链接错误 请重新发送');
			}else{
	            $this->assign('uid',$user['uid']);
	            $this->assign('token',$token);
	            $this->display();
	        }
		}else{
			redirect(U('home/login/index'), 3, '该链接错误');
		}
	}
	
	function up_user_password(){
		if(!IS_POST){
			$this->error('请填写密码');
		}
		$db = D('Email');
		$map['uid'] = I('uid');
		$map['token'] = I('token');
		$email = $db->where($map)->count();
		if($email){
			$data = array(
				'id' => I('uid'),
				'password' => I('post.password'),
				'repassword' => I('post.repassword')
			);
			$user = D('User');
			if($user->create($data)){
				$user->save();
				$db->where($map)->delete();
				redirect(U('home/login/index'), 3, '修改成功...');
			}else{
				$this->error($user->getError());
			}
		}else{
			redirect(U('home/login/index'), 3, '修改失败...');
		}
	}
}
