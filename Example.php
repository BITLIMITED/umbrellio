<?php
#
#	Test namespace
#
namespace bitlimited;

require_once(dirname(__FILE__)."/MethodIterator.php");
require_once(dirname(__FILE__)."/ExampleMethods.php");

#
#	Class Example
#	return array( Key [current row] = Value [first position] )
#
class Example
{
	private $method;
	private $filename;
	private $error;
	
	public $config;
	
	public function __construct($filename = null) {
		if(empty($this->config))
			$this->config = parse_ini_file(dirname(__FILE__)."/config.ini");
		
		if(empty($this->filename) and !is_null($filename)){
			try{
				$this->filename = $this->checked($filename);
			}catch(\Exception $error){
				$this->error = $error;
			}
		}
	}
	
	protected function clearError(){
		return $this->error = null;
	}
	#
	#	set method
	#
	public function setMethod($method)
	{
		$object = __NAMESPACE__ ."\\".$method;
		$this->method = new $object();
	}
	#
	#	set filename
	#
	public function setFile($filename = null){
		if(empty($this->filename) and !empty($filename))
		{
			$this->clearError();
			try{
				$this->filename = $this->checked($filename);
			}catch(\Exception $error){
				$this->error = $error;
			}
		}
	}
	
	#
	#	читаем файл
	#
	public function ready($keyword = null)
	{ 
		$result = null;
		if(!empty($this->error))
			throw new \Exception($this->error->getMessage());
		elseif(empty($keyword))
			throw new \Exception("Укажите ключевую букву / слово для поиска!");
		else
			$result = $this->method->ready( $this->filename, $keyword, $this->config['step'] );
		return $result;
	}
	
	#
	# проверка файла
	#
	public function checked($filename):string
	{
		if(is_null($filename) or !is_string($filename))
			throw new \Exception("Пустое название файла!");
		elseif(file_exists($filename) === false)
			throw new \Exception("Файл не найден!");
		elseif(is_readable($filename) === false)
			throw new \Exception("Файл не найдет и/или не удается прочитать!");
		else{ 
			if(!in_array(pathinfo($filename, PATHINFO_EXTENSION ), $this->config['extension']))
				throw new \Exception("Файл не соответствует стандарту расширения!");
			elseif(filesize($filename) > $this->config['max_size'])
				throw new \Exception("Файл больше размером чем хочется!");
			else
				return trim($filename);
		}
	}
}