<?php
//$result = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //print_r($_POST);
    $resulttext = "Результат:";
    $result = $_POST['values'];
    $resulttext = "Результат:";
    $formval = preg_replace('/\s+/', '', $_POST['values']);
    $result = longestLength($formval);
    $result2 = "(по второму варианту функции:".longestLength2($formval).")";

}
// первый вариант
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
// второй вариант
function longestLength2($string)
{
    $arr = array();
    for ($i = 0; $i < mb_strlen($string); $i++) {
        $arr[$i] = array();
        for ($m = $i; $m < mb_strlen($string); $m++) {
            $char = mb_substr($string, $m, 1);
            if (!in_array($char ,$arr[$i])) {
                array_push($arr[$i], $char);
            } else {
                break;
            }
        }
    }
    $mcount = 0;
    foreach ($arr as $arrval) {
        $count = count($arrval);
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