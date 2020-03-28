<?php
//$result = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //получаем результаты из формы, удаляя возможные пробелы
    $resulttext = "Результат:";
    $formval = preg_replace('/\s+/', '', $_POST['values']);
    $a = explode(',', $formval);
    $n = count($a);
    if ($n==1) {
        // отсекаем сценарий, когда введено одно число
        $result = "Список значений не задан";
    } else {
        // исключаем ситуации ввода текстовых значений
        $txt = array("й", "ц", "у", "к", "е", "н", "г", "ш",
            "щ", "з", "х", "ъ",  "ф", "ы", "в", "а",  "п", "р", "о", "л",  "д", "ж", "э", "ё",
            "я", "ч", "с", "м",  "и", "т", "ь", "б",  "ю", "q", "w", "e",  "r", "t", "y", "u",
            "i", "o", "p", "a",  "s", "d", "f", "g",  "h", "j", "k", "l",  "z", "x", "c", "v",
            "b", "n", "m", "@",  "$", "%", "^", "&",  "*", "(", ")", "_",  "-", "+", "=", "{",
            "}", ":", ";", "?");
        foreach ($a as $value) {
            for ($i = 0; $i < mb_strlen($value); $i++) {
                $char = mb_substr($value, $i, 1);
                if (in_array($char, $txt)) {
                    $result = "В списке есть нечисловое значение. Выполнить расчет невозможно";
                    break;
                }
            }
        }
        if(!$result) {
            // выполняем сборку диапазонов
            $result = summaryRanges($a);
            //var_dump($result);
        }
    }

}

function summaryRanges($arr)
{
    sort($arr);
    $resarr = array();
    $finarr = array();
    $arr2 = $arr;
    $lastval = 0;
    $m = 0;
    $mid = "->";
    // выявление возможных диапазонов
    foreach ($arr as $key => $value) {
        $vl = $value;
        if ($m>0) {
            $n=$m-1;
            $lastval = end($resarr[$n]);
        }
        if($vl>=$lastval) {
            $resarr[$m] = array($vl);
            $vl++;
            if (in_array($vl, $arr2)) {
                array_push($resarr[$m], $vl);
                $check = false;
                do
                {
                    $vl++;
                    if (in_array($vl, $arr2)) {
                        array_push($resarr[$m], $vl);
                    } else {
                        $check = true;
                    }
                } while ($check == false);
                $m++;
            }
        }
    }
    // преобразование выявленных значений
    foreach ($resarr as $resval) {
        if(count($resval)>1) {
            $beg = array_shift($resval);
            $end = end($resval);
            $exp = $beg.$mid.$end;
            array_push($finarr, $exp);
        }
    }
    if(!$finarr) {
        $finarr = "Последовательностей не выявлено";
    }
    return($finarr);
}
?>
<!DOCTYPE html>
<html lang="ru">
<form action="" method="post">
    <p><b>Введите последовательность чисел через запятую:</b><br>
        <input name="values" type="text" size="40">
    </p>
    <input name="operation" type="submit" value="Вывести список диапазонов"/>
</form>
<? echo $resulttext;
    print_r($result);
    ?>

