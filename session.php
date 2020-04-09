<?

class session{
	protected $cookieName = 'sess';
	protected $path = '/var/www/cache/';
	protected $lifeTime = 1800;
	protected $time = [];
	protected $text,$hash;
	protected function timePart($time){
		$tmp = substr(time()+$time,0,-3) - 1500000;
		return $tmp;
	}
	protected function makeID(){
		return md5(time());
	}
	protected function setCookie(){
		setCookie($this->cookieName,$this->time['real'].':'.$this->id,0,'/','.klenov.su');
	}

	public function __construct($params){
		$this->params = implode('',$params);
		$this->time['real'] = $this->timePart(time());
		if($_COOKIE[$this->cookieName]){//кука есть
			list($this->time['file'],$id) = explode(':',$_COOKIE[$this->cookieName]);
			if(is_file($this->path.$time.'/'.$id)){//если файл есть и сигнатура ок - читаем
				$text = file_get_contents($path);
				if(substr($text,0,strlen($this->params))===$this->params) $this->text = substr($text,strlen($this->params));
			}
		}
		if(!$this->text){//делаем новую
			list($time['file'],$id) = [$this->time['real'],$this->makeID()];
		    $this->setCookie();
		}else $this->hash = md5($this->text);
	}
	public function open(){
		global $user;
    	if($this->text) $user = unserialize($this->text);
	}
	public function close(){
        global $user;

        file_put_contents(serialize($user));
	}
}
?>