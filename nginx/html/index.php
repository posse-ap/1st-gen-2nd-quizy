<?php 
// phpinfo();

// ーーーーーーーーーーーーーーーーーーurl変更くんーーーーーーーーーーーーーーーーーーーーーー
function url_param_change($par=Array(),$op=0){
    $url = parse_url($_SERVER["REQUEST_URI"]);
    if(isset($url["query"])) parse_str($url["query"],$query);
    else $query = Array();
    foreach($par as $key => $value){
        if($key && is_null($value)) unset($query[$key]);
        else $query[$key] = $value;
    }
    $query = str_replace("=&", "&", http_build_query($query));
    $query = preg_replace("/=$/", "", $query);
    return $query ? (!$op ? "?" : "").htmlspecialchars($query, ENT_QUOTES) : "";
}

// // 追加または上書き
// $url_param = url_param_change(Array("パラメータ名"=>"追加または上書きする内容"));

// // 削除
// $url_param = url_param_change(Array("削除するパラメータ名"=>null));

// // 第2引数を指定
// $url_param = url_param_change(Array("パラメータ名"=>"内容"),1);

// 使用例
// $url_param = url_param_change(Array("id"=>$id));

//https://dgcolor.info/blog/87/ 



// ーーーーーーーーーーーーーーーーーーーーーー自作関数ーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


function connect_mysql($host_name,$db_name,$usr_name,$password){
    try {
        $dsn = "mysql:host=".$host_name.";dbname=".$db_name."; charset=utf8";
        $ret = new PDO($dsn, $usr_name, $password);
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
    return $ret;
}

// 使用例
// $dbh = connect_mysql("db","quizy","root","root_pass_shuto");


function mysql_to_arry($dbh,$sql){
    $res = $dbh->query($sql);
    $ret = $res->fetchAll();
    return $ret;
}
// 使用例
// $sql = "SELECT * FROM `questions`";
// $data = mysql_to_arry($dbh,$sql);



//ーーーーーーーーーーーーーーーーーーーーurlのidを取得ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

$id = $_GET['id'];
if ($id==NULL) {
    $id = 1;
}
if ($id>2) {
    $id = 1;
    echo "そのidの問題は用意されていません<br>";
}
// idがない時は想定していないので、とりあえず東京を出すようにする


//ーーーーーーーーーーーーーーーーーーーーdb接続してデータ持ってくるーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
//db接続に必要な情報を持ってくる 
$dbh = connect_mysql("db","quizy","root","root_pass_shuto");

// questionsから$idと一致する物(id=1なら東京の難読地名クイズ)を持ってくる
$sql = "SELECT * FROM questions WHERE id = $id"; 
// $sql = "SELECT * FROM `questions` WHERE id = $id"; 

$title_data = mysql_to_arry($dbh,$sql);

// タイトル
$title = $title_data[0][1];

// 選択肢のテーブル名を指定(choices1が東京、choices2が広島)
$choices_name = "choices";
$choices_name .= $id;

$sql2 = "SELECT * FROM $choices_name";

$data2 = mysql_to_arry($dbh,$sql2);

// nameだけの情報に変更
$choices = array_column($data2, 'name');

// 3こづつの配列に変更
$choices = array_chunk($choices,3);

// js用に変更
$choices_js = json_encode($choices);

// 接続を閉じる
$dbh = null;

//ーーーーーーーーーーーーーーーーーーーーdb接続してデータ持ってくるここまでーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


//// js用に変更
$page_id_js = json_encode($id);



// 今回は東京と広島だけなので単純に入れ替えるようにしている
if($id == 1){
    $id = 2;
    $place = "広島";
}else{
    $id = 1;
    $place = "東京";
}

// 関数を使ってurlにid=をつけている
$url_param = url_param_change(Array("id"=>$id));

?>



<!-- ここからhtml -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link href="https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/html5resetcss/html5reset-1.6.css">
    <link rel="stylesheet" href="./quizy3.css">
</head>
<!-- jsにデータを投げている -->
<script  type="text/javascript">
var page_id = <?php echo $page_id_js ?>;
var question_list = <?php echo $choices_js ?>
</script>

<body>
    <a href="http://localhost:8080<?php echo $url_param; ?>"><?php echo $place; ?>に切り替えるよ</a>
    <div id="main" class="main">
        <script src="./quizy3.js"></script>
    </div>
</body>

</html>
