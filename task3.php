<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // преобразовываем данные из формы в массив, убирая пробелы
    $result = $_POST['values'];
    $resulttext = "Результат:";
    $formval = preg_replace('/\s+/', '', $_POST['values']);
    // считаем длину первым способом
    $result = longestLength($formval);
    // считаем длину вторым способом
    $result2 = "(по второму варианту функции:".longestLength2($formval).")";

}
// первый способ
function longestLength($string)
{
    // считаем общую длину строки
    $len = strlen($string);
    for($i = $len; $i > 1; $i--) {
        $subStrLength = $i;
        $offset = 0;
        do
        {
            $subStr = substr($string, $offset, $subStrLength);
            // возвращаем максимальную длину при выполнении заданных условий
            if(count(array_unique(str_split($subStr))) == $subStrLength) {
                return $subStrLength;
            }
            $offset++;
        } while($offset + $subStrLength <= $len);
    }
    // возвращаем максимальную длину если проверочные условия не были выполнены
    return $i;
}
// второй вариант
function longestLength2($string)
{
    // создаем пустой массив для сборки различных комбинаций символов
    $arr = array();
    $mcount = 0;
    for ($i = 0; $i < mb_strlen($string); $i++) {
        $arr[$i] = array();
        // перебираем подстроки, наполняя массив с комбинациями символов
        for ($m = $i; $m < mb_strlen($string); $m++) {
            $char = mb_substr($string, $m, 1);
            if (!in_array($char ,$arr[$i])) {
                array_push($arr[$i], $char);
            } else {
                // останавливаемся, если символ неуникальный
                break;
            }
        }
        // подсчитываем наибольшее значение массива
        $count = count($arr[$i]);
        if($count >= $mcount) {
            $mcount = $count;
        }
    }
    return $mcount;
}
?>
    <!DOCTYPE html>
    <html lang="ru">
    <form action="" method="post">
        <p><b>Введите последовательность чисел через запятую:</b><br>
            <input name="values" type="text" size="40">
        </p>
        <input name="operation" type="submit" value="Вывести длину макс последовательности"/>
    </form>
<? echo $resulttext.$result.$result2; ?>