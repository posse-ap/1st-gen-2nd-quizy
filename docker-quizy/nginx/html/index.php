<?php
  $id = $_GET['id'];
  echo $id;


// echo phpinfo();

// $dsn = 'mysql:dbname=shop;host=127.0.0.1';
// $user = 'root';
// $password = 'password';

// try {
//     $dbh = new PDO($dsn, $user, $password);
//     echo "接続に成功しました\n";
// } catch (PDOException $e) {
//     echo "接続に失敗しました\n";
//     echo $e->getMessage() . "\n";
// }

    
//<meta charset="UTF-8">
//<title>テスト</title>
//<?php
//    try {
//        # hostには「docker-compose.yml」で指定したコンテナ名を記載
//        $dsn = "mysql:host=quizy_php_0_db_1;dbname=mysql;";
//        $db = new PDO($dsn, 'root', 'pass');
//
//        $sql = "SELECT * FROM questions";
//        $stmt = $db->prepare($sql);
//        $stmt->execute();
//        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        var_dump($result);
//    } catch (PDOException $e) {
//        echo $e->getMessage();
//        exit;
//    }


// <?php

//  try {
//    $pdo = new PDO(
//      'mysql:host=db;dbname=mysql;charset=utf8mb4',
//      'dbuser',
//      'dbpass',
//      [
//        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//  			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//  			PDO::ATTR_EMULATE_PREPARES   => false,
//      ]
//    );

//    $pdo->query("DROP TABLE IF EXISTS questions");
//    $pdo->query(
//      "CREATE TABLE questions (
//        id INT,
//        name VARCHAR(140)
//      )"
//  	);
	
//  	$pdo->query(
//  		"INSERT INTO questions (id, name) VALUES
//  			(1, '東京の難読地名クイズ'),
//  			(2, '広島県の難読地名クイズ')"
//  	);
  
//    $stmt = $pdo->query("SELECT * FROM questions");
//    $questions = $stmt->fetchAll();
//    foreach($questions as $question) {
//      printf(
//        '%s (%d)' . PHP_EOL,
//        $question['name'],
//        $question['id']
//      );
//    }
//  } catch (PDOException $e) {
//    echo $e->getMessage() . PHP_EOL;
//    exit;
//  }

// http://www.flatflag.nir87.com/pdo_construct-912
// データベースに接続するために必要なデータソースを変数に格納
  // mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
  $dsn = 'mysql:host=db;dbname=quizy;charset=utf8mb4;[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,]';
 
  // データベースのユーザー名
    $user = 'root';
 
  // データベースのパスワード
    $password = 'root_pass_fB3uWvTS';
 
// tryにPDOの処理を記述
try {
 
  // PDOインスタンスを生成
  $dbh = new PDO($dsn, $user, $password);
  echo "接続成功\n";
// エラー（例外）が発生した時の処理を記述
} catch (PDOException $e) {
 
  // エラーメッセージを表示させる
  echo 'データベースにアクセスできません！' . $e->getMessage();
 
  // 強制終了
  exit;
 
}

// $result = mysql_select_db('mysql', $dbh);
// if (!$result) {
//   exit('データベースを選択できませんでした。');
// }
if(@$_POST["id"] != "" OR @$_POST["name"] != ""){ //IDおよびユーザー名の入力有無を確認
    // $stmt = $pdo->query("SELECT * FROM questions WHERE ID='".$_POST["id"] ."' OR Name LIKE  '%".$_POST["name"]."%')"); //SQL文を実行して、結果を$stmtに代入する。
    // $stmt = $dbh->query("SELECT * FROM 'questions' WHERE id='".$_POST["id"] ."' OR name LIKE  '%".$_POST["name"]."%')"); //SQL文を実行して、結果を$stmtに代入する。
    // $result = $stmt->fetch();
    // var_dump($result);
}
$stmt = $dbh->query("SELECT * FROM questions WHERE id LIKE '%" . $_POST["id"] . "%'");
                // " SELECT * FROM contacts  WHERE id LIKE '%" . $_POST["search_name"] . "%' "
$result = $stmt->fetchAll();
var_dump($result);
$result = var_dump($result);
	
echo $_SERVER['QUERY_STRING'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ガチで東京の人しか解けない！ #東京の難読地名クイズ</title>
    <link rel="stylesheet" href="quizy.css">
    
    <link href="https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/html5resetcss/html5reset-1.6.css">
</head>

<header>

<h1 id='hiroshima_title'>広島の難読地名クイズ</h1>
<h1 id='tokyo_title'>東京の難読地名クイズ</h1>
<a href="index.php?id=1" id="tokyo">東京の問題へ</a><br>
<a href="index.php?id=2" id="hiroshima">広島の問題へ</a><br>
        <form action="index.php" method="post">
            ID:<input type="text" name="id" value="<?php echo $_POST['id']?>">
            <?php
                if(preg_match("/[^0-9A-Za-z]/", $_POST['id'])){
                   echo " IDは英数字で入力してください！";
                }
            ?>
            <br>
            <!-- Name:<input type="text" name="name" value="<?php echo $_POST['name']?>"><br> -->
            <input type="submit">
        </form>
        <table>
            <tr><th>ID</th><th>Name</th></tr>
            <!-- ここでPHPのforeachを使って結果をループさせる -->
            <?php foreach ((array)$stmt as $row): ?>
                <tr><td><?php echo $row[0]?></td><td><?php echo $row[1]?></td></tr>
            <?php endforeach; ?>
        </table>






    <div class = "header_left">
        <h4>kuizy</h4>
    </div>
    <div class = "header_right">
        <a href="/ranking" class="icon">
            <img src="https://d1khcm40x1j0f.cloudfront.net/static/img/tab/tournament-on.png" alt="ランキング">
            <span>ランキング</span>
        </a>
        
        <a href="/quiz/prepare" class="icon">
            <img src="https://d1khcm40x1j0f.cloudfront.net/static/img/tab/create-on.png" alt="クイズ作成">
            <span>作ってみる</span>
        </a>
        
        
        <a href="/search" class="icon">
            <img src="https://d1khcm40x1j0f.cloudfront.net/static/img/tab/search-on.png" alt="検索">
            <span>検索する</span>
        </a>
    </div>
</header>

<body>
    
    
    
    <div class="main">
        <h1>ガチで東京の人しか解けない！ #東京の難読地名クイズ</h1>
        <!-- ここから1問目 -->
        <div class="quiz">
            <h2 class="mondaibunn">1. この地名はなんて読む？</h2>
            <img src="https://d1khcm40x1j0f.cloudfront.net/quiz/34d20397a2a506fe2c1ee636dc011a07.png">
            
            <ul>
                <li class="choices" id="quiz_1_1" name="choices_1" onclick="check(1,1,2)">たかわ</li>
                <li class="choices" id="quiz_1_2" name="choices_1" onclick="check(1,2,2)">たかなわ</li>
                <li class="choices" id="quiz_1_3" name="choices_1" onclick="check(1,3,2)">こうわ</li>
                <li id="answerbox_1" class="answerbox">
                    <span id="answertext_1"></span><br>
                    <span>正解は「たかなわ」です！</span>
                </li> 
            </ul>
        </div>
        
        
        <!-- ここから2問目 -->
        <div class="quiz">
            <h2 class="mondaibunn">2. この地名はなんて読む？</h2>
            <img src="https://d1khcm40x1j0f.cloudfront.net/quiz/512b8146e7661821c45dbb8fefedf731.png">
            
            <ul>
                <li class="choices" id="quiz_2_1" name="choices_2" onclick="check(2,1,3)">かめど</li>
                <li class="choices" id="quiz_2_2" name="choices_2" onclick="check(2,2,3)">かめと</li>
                <li class="choices" id="quiz_2_3" name="choices_2" onclick="check(2,3,3)">かめいど</li>
                <li id="answerbox_2" class="answerbox">
                    <span id="answertext_2"></span><br>
                    <span>正解は「かめいど」です！</span>
                </li> 
            </ul>
        </div>
    </div>
    
    <script>
        // URLのパラメータを取得
var urlParam = location.search.substring(1);
 
 // URLにパラメータが存在する場合
 if(urlParam) {
   // 「&」が含まれている場合は「&」で分割
   var param = urlParam.split('&');
  
   // パラメータを格納する用の配列を用意
   var paramArray = [];
  
   // 用意した配列にパラメータを格納
   for (i = 0; i < param.length; i++) {
     var paramItem = param[i].split('=');
     paramArray[paramItem[0]] = paramItem[1];
   }
//    var tokyo = document.getElementById("tokyo");
//    var hiroshima = document.getElementById("hiroshima");
   // パラメータidがosakaかどうかを判断する
   console.log(paramArray.id);
   if (paramArray.id == '1') {
    document.getElementById("tokyo").style.display="none";
    document.getElementById("hiroshima_title").style.display ="none";
   } else {
    document.getElementById("hiroshima").style.display ="none";
    document.getElementById("tokyo_title").style.display="none";
   }
 }



var 
    </script>
    <script src="quizy.js"></script>
</body>
</html>
