<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //получаем результаты из формы, удаляя возможные пробелы
    $resulttext = "Результат:";
    $formval = preg_replace('/\s+/', '', $_POST['values']);
    // преобразовываем данные из формы в массив
    $a = explode(',', $formval);
    // считаем размер массива
    $n = count($a);
    if ($n==1) {
        // отсекаем сценарий, когда введено одно число
        $result = "Список значений не задан";
    } else {
        // исключаем ситуации ввода текстовых и пустых значений
        $pattern = '#^[0-9]+$#';
        foreach ($a as $value) {
            if(!preg_match($pattern, $value)) {
                $result = "В списке есть нечисловые\пустые значения. Выполнить расчет невозможно";
                break;
            }
        }
        // если в массиве лишь числа, то приступаем к решению задачи
        if(!$result) {
                $arr = array();
                // формируем комбинации чисел в массиве
                generate(0, $n);
                // выводим наибольшее значение массива
                $result = arrangeBiggestNumber($arr);
        }

    }
}
// функция для вывода наибольшего числа среди комбинаций
function arrangeBiggestNumber($arr)
{
    rsort($arr);
    return($arr[0]);
}
// функция для подготовки возможных комбинаций
function generate($l, $r)
{
    // ссылка на переменные вне функции
    global $n, $a, $arr;
    if ($l == $r) {
        $vr = implode("", $a);
        // добавление в массив уникальной комбинации
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

