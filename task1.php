<?php

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
            if (in_array($value, $txt)) {
                $result = "В списке есть нечисловое значение. Выполнить расчет невозможно";
                break;
            }
        }
        if(!$result) {
            $arr = array();
            // формируем комбинации чисел в массиве
            generate(0, $n);
            // выводим наибольшее значение массива
            $result = arrangeBiggestNumber($arr);
        }
    }
}

function arrangeBiggestNumber($arr)
{
    rsort($arr);
    return($arr[0]);
}

function generate($l, $r)
{
    global $n, $a, $arr;
    if ($l == $r) {
        $vr = implode("", $a);
        array_push($arr, $vr);
    } else {
        for ($i = $l; $i < $r; $i++) {
            $v = $a[$l];
            $a[$l] = $a[$i];
            $a[$i] = $v; //{обмен a[i],a[l]}
            generate($l + 1, $r); //{вызов новой генерации}
            $v = $a[$l];
            $a[$l] = $a[$i];
            $a[$i] = $v; //{обмен a[i],a[l]}
        }
    }
    return;
}


?>
<!DOCTYPE html>
<html lang="ru">
<form action="" method="post">
    <p><b>Введите последовательность чисел через запятую:</b><br>
        <input name="values" type="text" size="40">
    </p>
    <input name="operation" type="submit" value="Сопоставить наибольшее число"/>
</form>
<?
// выводим результат
echo $resulttext;
print_r($result); ?>

