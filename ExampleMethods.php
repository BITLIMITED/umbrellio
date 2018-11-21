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
			#	start row
			#
			$row = 1;
			
			$is_step = (empty($step)) ? 1024 : ($step <= 0) ? 1024 : $step;
			#
			#	selected current row from file
			#
			while(fgetss($file_handle) !== false)
			{
				#
				#	selected key first position from row
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