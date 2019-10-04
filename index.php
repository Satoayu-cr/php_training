<?php

require_once __DIR__ . '/functions.php';
require_logined_session();

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
    <head>
        <title>会員限定ページ</title>
    </head>

    <style type="text/css">
        th{
            background-color:#FFFFCC;
        }
    </style>

    <body>
        <h1>
            ようこそ,<?=h($_SESSION['username'])?>さん
            <span style="font-size: small;">
                <a href="/logout.php?token=<?=h(generate_token())?>">ログアウト</a>
            </span>
        </h1>

<?php

$dsn = 'pgsql:dbname=php_training_database host=172.20.0.35 port=5432';
$user = 'php_training_user';
$password = '7890';

print('<table border = "1" style="border-collapse: collapse"><tr>');
print('<th>図鑑番号</th><th>名前</th><th>タイプ１</th><th>タイプ2</th></tr>');

try {
    $dbh = new PDO($dsn, $user, $password);
    $sql = 'select * from pokemon_status';

    foreach ($dbh->query($sql) as $row) {
        print('<td>'.$row['dict_num'].'</td>');
        print('<td>'.$row['name'].'</td>');
        print('<td>'.$row['type1'].'</td>');
        print('<td>'.$row['type2'].'</td></tr>');
    }
} catch (PDOException $e) {
    print('Error:'.$e->getMessage());
    die();
}
print('</table>');

$dbh = null;

?>

    </body>
</html>