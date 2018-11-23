# Example Class для чтения файла

Тестировался на PHP v.7.2.0

### Пример использования

    $example = new \bitlimited\Example();
    $example->setMethod( $methodName );
    try{
		$response = $example->ready($keyword);
		....
    }catch(\Exception $e){
    	print_r($e->getMessage());
    }
## Конфигурация
Настройка параметров установлена в __config.ini__ файле 

| Ключ | Значение |
| ------ | ------ |
| max_size| Максимальный размер файла (байтах) |
| extension | Массив допустимых расширений  |
| step| Шаг поиска в строке (байтах) |

### 1. Установка файла для чтения

    new Example( $filename );
    // или альтернативный вариант 
    $example->setFile( $filename );

### 2. Выбор метода для чтения файла

    $example->setMethod( (string)$methodName );
| Метод | Задача |
| ------ | ------ |
| FileFromServer| поиск первого вхождения строки (по строчный поиск)|

    
### 3. Установка искомого ключа 

    $example->ready( (string)$keyword );

## Метод FileFromServer
Результатом данного метода является ассоциативный массив

    array(
    номер строки => array( ['position'] => позиция в строке ),
    )