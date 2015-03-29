<?php
	
	/**
	*@功能：用户登录
	*/
	
	class LoginAction extends Action{
		
		/**
		*@功能：登录
		*/
		public function index(){
			if(IS_POST){
				if(empty($_POST['login']) && empty($_POST['pwd'])){
						//$this->redirect('login');
						$this->error('登陆失败，账号或密码错误！');
					}else{
						$login	= I('post.login');
						$pwd	= I('post.pwd');
						$wz	= I('post.wz');
						$logins = getgb(remove_xss($login));
						$pwd = getgb(remove_xss($pwd));
						$data = D('Login')->login($logins,$pwd);
							if($data==1){
								//判断账号是不是审核通过
								$where['uid'] = $logins;
					$state =D('Users')->where($where)->field('ID,yz,logins')->find();
								if($state['yz']==1){
								//写入登录信息
								$loginf['zhdlsj']=date('Y-m-d H:i:s',time());
								$loginf['zhdlip']=get_client_ip();
								$loginf['logins']=$state['logins']+1;
								M('users')->where('ID = '.$state['ID'])->save($loginf);
									if($wz==''){
										$this->success('登录成功','/user/');
									}else{
										$this->success('登录成功',$wz);		
									}
								}else{
									$wheres['type'] ='verification';
									$wheres['code'] = $state['yz']; 
									$stateinfo = D('zjboee_datatict')->field('name')->where($wheres)->find();
									session('mark',null);
									$name = $stateinfo['name'];
									$this->error("$name");
								}
							}else{
								$this->error('登陆失败，账号或密码错误！');
							}
				}
			}else{
				$this->error('出错了');
			}
		}
		
		public function login(){
			$this->display();
		}
		
		public function loginyz(){
			header("Content-Type:text/html; charset=utf-8");
			if(IS_POST){
				if(empty($_POST['name']) AND empty($_POST['param'])){
						echo '{"info":"数据验证失败！","status":"n"}';
					}else{
						$where['uid']= getgb(I('post.param'));
						$model = D('Users');
						$date = $model->where($where)->count();
						if($date){
							echo '{"info":"这个用户名已经被使用，请更换！","status":"n"}';
						}else{
							echo '{"info":"恭喜您该账号名可以注册！","status":"y"}';
						}
					}
				}else{
					echo '{"info":"数据验证失败！","status":"n"}';
			}
		}

		public function logintel(){
			header("Content-Type:text/html; charset=utf-8");
			if(IS_POST){
				if(empty($_POST['name']) AND empty($_POST['param'])){
						echo '{"info":"数据验证失败！","status":"n"}';
					}else{
						$where['name']= gettel(I('post.param'));
						$where['lx'] = 'haoduan';
						$date = D('zj_types')->where($where)->count();
						if($date){
							$val = I('post.param');
							$tel = $this->Repeattel($val);
							if($tel){
								echo '{"info":"该手机号码已经被注册！","status":"n"}';
							 }else{
							 	echo '{"info":"恭喜您该手机号码可以注册！","status":"y"}';
							}
						}else{
							echo '{"info":"请使用松原号码注册！","status":"n"}';
						}
					}
				}else{
					echo '{"info":"数据验证失败！","status":"n"}';
			}
		}

		/**
		*@验证是不是未审核会员
		*/
		public function yzuser(){
			header("Content-Type:text/html; charset=utf-8");
			if(IS_POST){
				$where['name'] = I('post.param');
				$date = D('Users')->where($where)->find();
				if($date){
					echo '{"info":"会员认证未通过，请等待审核","status":"n"}';
				}
			}else{
				echo '{"info":"数据验证失败！","status":"n"}';
			}
		}
		
		
				/**
		*@验证手机号码是不是重复号码
		*/
		public function Repeattel($val){
			$where['tel'] = $val;
			$where['MOBILE2'] = $val;
			$where['MOBILE3'] = $val;
			$where['MOBILE4'] = $val;
			$where['MOBILE5'] = $val;
			$where['_logic'] = 'OR';
			$tel = D('Users')->where($where)->find();
			if($tel){
				return 1;				
			}else{
				return 0;
			}
		}	

	}
