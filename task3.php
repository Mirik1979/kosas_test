<?php
//$result = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //print_r($_POST);
    $resulttext = "Результат:";
    $result = $_POST['values'];
}
?>
    <!DOCTYPE html>
    <html lang="ru">
    <form action="" method="post">
        <p><b>Введите последовательность чисел через запятую:</b><br>
            <input name="values" type="text" size="40">
        </p>
        <input name="operation" type="submit" value="Вывести самую длинную подстроку"/>
    </form>
<? echo $resulttext.$result; ?>