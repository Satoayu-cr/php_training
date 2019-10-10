<?php

require_once __DIR__ . '/functions.php';
require_logined_session();

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
    <head>
        <title>会員限定ページ</title>
        <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link rel="stylesheet" href="SlickGrid-master/slick.grid.css" type="text/css"/>
    <link rel="stylesheet" href="SlickGrid-master/css/smoothness/jquery-ui-1.11.3.custom.css" type="text/css"/>
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
        <table width="100%">
            <tr>
                <td valign="top" width="50%">
                <div id="myGrid" style="width:600px;height:500px;"></div>
                </td>
                </td>
            </tr>
        </table>
    <script src="SlickGrid-master/lib/jquery-1.11.2.min.js"></script>
    <script src="SlickGrid-master/lib/jquery.event.drag-2.3.0.js"></script>

    <script src="SlickGrid-master/slick.core.js"></script>
    <script src="SlickGrid-master/slick.grid.js"></script>

<?php

$dsn = 'pgsql:dbname=php_training_database host=172.20.0.35 port=5432';
$user = 'php_training_user';
$password = '7890';

try {
    $dbh = new PDO($dsn, $user, $password);
    $sql = 'select * from pokemon_status';

    //連想配列を作る
    foreach ($dbh->query($sql) as $row) {
        $id = strval($row["dict_num"]);
        $table_data[]=array(
            '図鑑番号'=>$row['dict_num'],
            '名前'=>$row['name'],
            'タイプ１'=>$row['type1'],
            'タイプ2'=>$row['type2'],
            '操作'=>$id,
        );
    }

} catch (PDOException $e) {
    print('Error:'.$e->getMessage());
    die();
}
$php_json = json_encode($table_data, JSON_UNESCAPED_UNICODE);
$dbh = null;
?>

<script>
function linkFormatter(cellvalue, options, rowdata) {
    var val = "<a href= './detail.php?id=" + rowdata + "'>" + '詳細' + "</a>";
    return val;
}
  var grid;
  var columns = [
    {id: "図鑑番号", name: "図鑑番号", field: "図鑑番号"},
    {id: "名前", name: "名前", field: "名前"},
    {id: "タイプ１", name: "タイプ１", field: "タイプ１"},
    {id: "タイプ2", name: "タイプ2", field: "タイプ2"},
    {id: "操作", name: "操作", field: "操作",formatter: linkFormatter},
  ];
  var options = {
    forceFitColumns:true,
    enableCellNavigation: true,
    enableColumnReorder: false
  };

  var js_array = JSON.parse('<?php echo $php_json; ?>');
    grid = new Slick.Grid("#myGrid", js_array, columns, options);

</script>
    </body>
</html>