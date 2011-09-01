<?php
/**
 * @author iann
 * this class work with parameters from Request = GET,POST
 *
 */
namespace BlueSeed;
class Request
{
	/**
	 *
	 * The data received in $_GET parsed by processURLParam
	 * in format where any value is independent
	 * @var ARRAY
	 * @access protected
	 */
	protected $GET;


	/**
	 *
	 * The data received in $_GET parsed by processURLParam
	 * in format [N] = N+1
	 * @var Array
	 * @access protected
	 */
	protected $PAIRGET;
	/**
	 *
	 * The data received in $_POST
	 * @var Array
	 * @access protected
	 */
	protected $POST;

    function __construct (Array $GET, Array $POST)
    {
		$this->processURLParam($GET);
		$this->POST = (object) $POST;
    }
	/**
	 *
	 * Method where the friendly URL are parsed into Controller /
	 * and Action /Data1/Data2/DataN
	 * @return void
	 * @access private
	 */
	private function processURLParam(Array $GET){
		if (count($GET)==0) {
			$this->setDefaultControllerAction($GET);
			return true;
		}

		$k = array_keys($_GET);
		$GET = explode ('/', $k[0]);
		if ($GET[count($GET)-1]=='') {
			array_pop($GET);
		}
		if ($this->setDefaultControllerAction($GET)) {
			return true;
		}
		foreach ($GET as $idx => $each){
			$this->GET[$idx]	= filter_var($each, FILTER_SANITIZE_URL );
			if (!($idx % 2)) {
			$this->PAIRGET[$each] = (($idx+1) < count($GET))
									?filter_var($GET[($idx+1)], FILTER_SANITIZE_URL )
									:NULL;
			}
		}
	}
	private function setDefaultControllerAction(Array $GET)
	{
		$this->GET[0]	= (array_key_exists(0, $GET))?ucfirst($GET[0])."Controller":"IndexController";
		$this->GET[1]	= (array_key_exists(1, $GET))?ucfirst($GET[1]):"Index";
		$this->PAIRGET['controller'] = $this->GET[0];
		$this->PAIRGET['action'] = $this->GET[1];
		return (count($GET)==0)?false:true;
	}
	public function isGet()
	{
		return !$this->isPOST();
	}
	public function isPost()
	{
		return (boolean) count($_POST);
	}
	public function setParam($name, $value){
		$this->POST[$name] = $value;
	}
	public function getParam($name)
	{
		return $this->POST[$name];
	}
	public function getQuery($name)
	{
		if(array_key_exists($name, $this->PAIRGET)) {
			return $this->PAIRGET[$name];
		} else {
			return (array_key_exists($name, $this->GET))
				?$this->GET[$name]
				:NULL;
		}
	}
}