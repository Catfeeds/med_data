 <?php
/**
 * 后台验证登录类
 * @author tivon
 * @date 2015-04-22
 */
class VipIdentity extends CUserIdentity
{
	/**
	 * 验证身份
	 * @return bool
	 */
	public function authenticate()
	{
		//内置帐号
		// if($this->username=='admin' && ($this->password=='admin123'))
		// {
		// 	$this->errorCode = self::ERROR_NONE;
		// 	$this->setState('id',1);
		// 	$this->setState('username','管理员');
		// 	$this->setState('avatar','');
		// 	return $this->errorCode;
				// } else{
		if (is_numeric($this->username)) {
			$user = DoctorExt::model()->find("status=1 and phone='".$this->username."'");
		} else {
			$user = DoctorExt::model()->find("status=1 and name='".$this->username."'");
		}

			if($user){
				if($user->code == $this->password) {
					$user->last_login = time();
					$user->save();
					$this->errorCode = self::ERROR_NONE;
					$this->setState('id',$user->id);
					$this->setState('username',$user->name);
					$this->setState('avatar','');
					$this->setState('hid',$user->hid);
					$this->setState('hname',$user->hospital->name);
					// $this->setState('hid',CompanyExt::model()->findByPk($user->cid)->name);
					return $this->errorCode;
				}
			}
		// }

		$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		return $this->errorCode;
	}

	public function getId()
	{
		return $this->getState('id');
	}

	public function getName()
	{
		return $this->getState('username');
	}

	public function getIp()
    {
        $ip = '127.0.0.1';
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}