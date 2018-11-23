<?php

namespace bitlimited;

class FileFromServer implements MethodIterator
{
	public function Ready($filename, $keyword, $step)
	{
		
		$result = null; 
		if($file_handle = fopen($filename, "r"))
		{
			fseek($file_handle, 0);
			#
			#	устанавливаем стартовую строку
			#
			$row = 1;
			
			#
			#	устанавливаем шаг по строке
			#
			$is_step = (empty($step)) ? 1024 : ($step <= 0) ? 1024 : $step;
			
			#
			#	перебераем строки
			#
			while(fgetss($file_handle) !== false)
			{
				#
				#	перебераем строку 
				#
				while(($file_row = fgets($file_handle, $is_step)) !== false)
				{
					$position = stripos($file_row,$keyword);
					if($position !== false)
					{
						$result[$row]['position'] = $position;
						break;
					}
					
				}
				$row++;
			}
			fclose($file_handle);
		}
		else
		{
			throw new \Exception("Ошибка при откртии файла");
		}
		return $result;
	}
}