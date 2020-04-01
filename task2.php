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
        // исключаем ситуации ввода текстовых значений
        $pattern = '#^[0-9]+$#';
        foreach ($a as $value) {
            if(!preg_match($pattern, $value)) {
                $result = "В списке есть нечисловые \ пустые значения. Выполнить расчет диапазонов невозможно";
                break;
            }
        }
        // если в массиве лишь числа, то приступаем к решению задачи
        if(!$result) {
            // выполняем поиск диапазонов
            $result = summaryRanges($a);
        }
    }
}
// функция поиска дипазанов
function summaryRanges($arr)
{
    // сортируем диапазон по возрастанию
    sort($arr);
    // определяем массив для предварительного расчета
    $resarr = array();
    // определяем массив для финального расчета
    $finarr = array();
    // делаем копию передаваемого массива
    $arr2 = $arr;
    // вводим переменную для контроля последнего найденного значения дипазаона
    $lastval = 0;
    // переменная счетчик
    $m = 0;
    // служебная текстовая переменная
    $mid = "->";
    // выявление возможных диапазонов
    foreach ($arr as $key => $value) {
        $vl = $value;
        if ($m>0) {
              $n=$m-1;
              // считаем последнее найденное значение диапазона
              $lastval = end($resarr[$n]);
        }
        // вычисляем следующий дипазан
        if($vl>$lastval || $lastval==0) {
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
    // преобразовываем выявленные значения
    foreach ($resarr as $resval) {
        // дополнительный контроль
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
    // возвращаем результат
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

