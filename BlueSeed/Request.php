<?php
/**
 * @author iann
 * this class work with parameters from Request = GET,POST
 *
 */
class Request
{
	/**
	 *
	 * The data received in $_GET parsed by processURLParam
	 * @var ARRAY
	 * @access protected
	 */
	protected $GET;
	/**
	 *
	 * The data received in $_POST
	 * @var Array
	 * @access protected
	 */
	protected $POST;

    function __construct ()
    {
		$this->processURLParam();
		$this->POST = (object) $_POST;
    }
	/**
	 *
	 * Method where the friendly URL are parsed into Controller /
	 * and Action /Data1/Data2/DataN
	 * @return void
	 * @access private
	 */
	private function processURLParam(){
		$GET = array();
		if (count($_GET)>0){
			$k = array_keys($_GET);
			$GET = explode('/', $k[0]);
			$this->controller 	= ucfirst(trim(array_shift($GET)))."Controller";
			$this->action		= trim(array_shift($GET));
		}

			if($this->action == '') {
				$this->action	= "Index";
            } else {
                if ($GET) {
                    if (is_int((count($GET) / 2))) {
                        for ($c = 0; $c < count($GET); $c++) {
                            $this->GET[$GET[$c]] = $GET[($c + 1)];
                            $c++;
                        }
                    } else {
                        throw new \Exception('Wrong parameter count');
                    }
                }
            }
		}else{
			$this->controller 	= "IndexController";
			$this->action		= "Index";
		}
	}
}
?>