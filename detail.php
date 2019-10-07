<?php

require_once __DIR__ . '/functions.php';
require_logined_session();

header('Content-Type: text/html; charset=UTF-8');
$id = $_REQUEST["id"];

?>

<!DOCTYPE html>
    <head>
        <title>詳細</title>
    </head>

    <style type="text/css">
        th{
            background-color:#FFFFCC;
        }
    </style>

    <body>
    <?php

    $dsn = 'pgsql:dbname=php_training_database host=172.20.0.35 port=5432';
    $user = 'php_training_user';
    $password = '7890';

    print('<table border = "1" style="border-collapse: collapse"><tr>');

    try {
        $dbh = new PDO($dsn, $user, $password);
        $id = strval($id);
        print($id);

        $sql = 'select * from pokemon_status WHERE dict_num = \''.$id.'\'';
        $row = $dbh->query($sql);

        foreach ($dbh->query($sql) as $row) {
            print('<tr><th>図鑑番号</th><td>'.$row['dict_num'].'</td></tr>');
            print('<tr><th>名前</th><td>'.$row['name'].'</td></tr>');
            print('<tr><th>タイプ１</th><td>'.$row['type1'].'</td></tr>');
            print('<tr><th>タイプ２</th><td>'.$row['type2'].'</td></tr>');
            print('<tr><th>特性１</th><td>'.$row['type2'].'</td></tr>');
            print('<tr><th>特性２</th><td>'.$row['type2'].'</td></tr>');
            print('<tr><th>夢特性</th><td>'.$row['chara_sp'].'</td></tr>');
            print('<tr><th>HP</th><td>'.$row['status_hp'].'</td></tr>');
            print('<tr><th>こうげき</th><td>'.$row['status_attack'].'</td></tr>');
            print('<tr><th>ぼうぎょ</th><td>'.$row['status_defense'].'</td></tr>');
            print('<tr><th>とくこう</th><td>'.$row['status_spattack'].'</td></tr>');
            print('<tr><th>とくぼう</th><td>'.$row['status_spdefense'].'</td></tr>');
            print('<tr><th>すばやさ</th><td>'.$row['status_speed'].'</td></tr>');
            print('<tr><th>合計</th><td>'.$row['status_sum'].'</td></tr>');
        }
    } catch (PDOException $e) {
        print('Error:'.$e->getMessage());
        die();
    }
    print('</table><a href="./index.php">戻る</a>');
    $dbh = null;
    ?>
    </body>
</html>