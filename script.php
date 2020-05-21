<?php
require_once 'connection.php'; // подключаем скрипт подключаемся к серверу
//находим ip
function getIp() {
  $keys = [
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED_FOR',
    'REMOTE_ADDR'
  ];
  foreach ($keys as $key) {
    if (!empty($_SERVER[$key])) {
      $ip = trim(end(explode(',', $_SERVER[$key])));
      if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
      }
    }
  }
}
//ищим браузер
function getBro() {
$user_agent = $_SERVER["HTTP_USER_AGENT"];
return $user_agent;
}

$ip = getIp();
$bro = getBro();
$date_today = date("j, n, Y");
$today[1] = date("H:i:s");
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$link = mysqli_connect($host, $user, $password, $database)
    or die("Ошибка " . mysqli_error($link));
// выполняем операции с базой данных
$sql = "INSERT INTO log_ip (`ip`, `browser`, `date_today`, `today`, `hostname`) VALUES ('$ip', '$bro', '$date_today','$today[1]', '$hostname')";
if (mysqli_query($link, $sql)) {
      echo "как дела?<br>";
} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($link);
}
mysqli_close($link);

// выведем IP клиента на экран
echo 'ip = ' . $ip;
?>
