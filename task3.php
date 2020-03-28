<?php
//$result = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //print_r($_POST);
    $resulttext = "Результат:";
    $result = $_POST['values'];
    $resulttext = "Результат:";
    $formval = preg_replace('/\s+/', '', $_POST['values']);
    $result = longestLength($formval);
}

function longestLength($string)
{
    $len = strlen($string);
    for($i = $len; $i > 1; $i--) {
        $subStrLength = $i;
        $offset = 0;
        do
        {
            $subStr = substr($string, $offset, $subStrLength);
            if(count(array_unique(str_split($subStr))) == $subStrLength) {
                return $subStrLength;
            }
            $offset++;
        } while($offset + $subStrLength <= $len);
    }
    return $i;
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
<? echo $resulttext.$result; ?>