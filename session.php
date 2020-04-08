<?

class session{
	protected $ses_name = 'sess';
	protected function timePart($time){
		$tmp = substr(time()+$time,0,-3) - 1500000;
		return $tmp;
	}
	protected function makeID(){
		return md5(time());
	}
	protected function setCookie(){
		setCookie($this->ses_name,$this->time.':'.$this->id,0,'/','.klenov.su');
	}
	public function __construct(){
		$this->path = '/var/www/cache/';
		$this->time = $this->timePart(1800);
		if($_COOKIE[$this->ses_name]){//кука есть
			list($time,$id) = explode(':',$_COOKIE[$this->ses_name]);
			if(is_file($this->path.$time.'/'.$id) && $time!=$this->time){//проверяем файл и древность
				rename($this->path.$time.'/'.$id,$this->path.$this->time.'/'.$id);
				$this->setCookie();
			}
		}else{//делаем новую
			list($time,$id) = [$this->time,$this->makeID()];
		    $this->setCookie();
		}
	}
	public function open(){
		global $user;
		$path = $this->path.$this->time.'/'.$this->id;
    	if(is_file($path)) $user = unserialize(file_get_contents($path));
	}
	public function close(){
        global $user;
        file_put_contents(serialize($user));
	}
}
?>