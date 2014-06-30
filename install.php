<!DOCTYPE html>
<?php
function execCmd($cmd){
    exec($cmd." 2>&1", $output, $retval);
    foreach($output as $result){
        echo $result."<br>\r\n";
    }
}

if($_POST["install"]){
    // 出力バッファをリセットする。
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    // selfupdateを実行
    if(file_exists("/usr/bin/php5")){
        $phpExec = "/usr/bin/php5";
    }elseif(file_exists("/usr/bin/php")){
        $phpExec = "/usr/bin/php";
    }else{
        die("PHP実行ファイルがありません");
    }
    $baseDir = dirname(__FILE__);
    echo "インストールを実行中です。しばらくお待ちください。<br>\r\n";
    execCmd("HOME=".$baseDir." ".$phpExec." ".$baseDir."/composer.phar selfupdate");
    execCmd("HOME=".$baseDir." ".$phpExec." ".$baseDir."/composer.phar install");

    // 設定ファイル取得用のパラメータを設定
    $params = array();
    $params["site_code"] = "shorturl";
    $params["site_name"] = "短縮URLシステム";
    $params["prefilters[]"] = "VizualizerShortage";
    $params = array_merge($params, $_POST);

    // パラメータをクエリ化し、HTTPヘッダを作成
    $data = http_build_query($params, "", "&");
    $header = array(
        "Content-Type: application/x-www-form-urlencoded",
        "Content-Length: ".strlen($data)
    );
    $context = array(
        "http" => array(
            "method"  => "POST",
            "header"  => implode("\r\n", $header),
            "content" => $data
        )
    );

    if(empty($_POST["domain_name"])){
        $_POST["domain_name"] = "localhost";
    }
    if(!is_dir($baseDir."/_configure/")){
        mkdir($baseDir."/_configure/");
    }
    if(($fp = fopen($baseDir."/_configure/configure_".$_POST["domain_name"].".php", "w+")) !== FALSE){
        $content = file_get_contents("http://config.vizualizer.jp/index.php", false, stream_context_create($context));
        echo nl2br(htmlspecialchars($content));
        fwrite($fp, $content);
        fclose($fp);
    }
    // データベースを作成
    require $baseDir . "/vendor/autoload.php";
    define('VIZUALIZER_SITE_ROOT', realpath("."));

    // Bootstrapを実行する。
    Vizualizer_Bootstrap::register(10, "PhpVersion");
    Vizualizer_Bootstrap::register(20, "Configure");
    Vizualizer_Bootstrap::register(30, "ErrorMessage");
    Vizualizer_Bootstrap::register(40, "Timezone");
    Vizualizer_Bootstrap::register(50, "Locale");
    Vizualizer_Bootstrap::register(60, "UserAgent");
    Vizualizer_Bootstrap::startup();

    $connection = Vizualizer_Database_Factory::begin("default");
    try{
        $connection->query("DROP TABLE admin_company_operators");
        $connection->query(file_get_contents($baseDir."/sql/01_admin_company_operators.sql"));
        $connection->query("DROP TABLE admin_companys");
        $connection->query(file_get_contents($baseDir."/sql/01_admin_companys.sql"));
        $connection->query("DROP TABLE admin_roles");
        $connection->query(file_get_contents($baseDir."/sql/01_admin_roles.sql"));
        $connection->query(file_get_contents($baseDir."/sql/02_admin_company_operators.sql"));
        $connection->query("INSERT INTO `admin_companys` (`company_id`, `company_name`, `display_flg`, `create_time`, `update_time`) VALUES (1, '".$_POST["company_name"]."', 1, NOW(), NOW())");
        $connection->query("INSERT INTO `admin_roles` (`role_id`, `role_code`, `role_name`, `create_time`, `update_time`) VALUES (1, 'administrator', '管理者', NOW(), NOW()), (2, 'user', '利用者', NOW(), NOW())");
        $connection->query("INSERT INTO `admin_company_operators` (`operator_id`, `company_id`, `role_id`, `login_id`, `password`, `operator_name`, `url`, `email`, `display_flg`, `create_time`, `update_time`) VALUES (1, 1, 2, '".$_POST["login_id"]."', SHA1('".$_POST["login_id"].":".$_POST["password"]."'), '".$_POST["operator_name"]."', 'link', '".$_POST["site_email"]."', 1, NOW(), NOW())");
        Vizualizer_Database_Factory::commit($connection);
    }catch(Vizualizer_Exception_Database $e){
        Vizualizer_Database_Factory::rollback($connection);
    }

    $connection = Vizualizer_Database_Factory::begin("shortage");
    try{
        $connection->query("DROP TABLE shortage_click_logs");
        $connection->query(file_get_contents($baseDir."/sql/01_shortage_click_logs.sql"));
        $connection->query("DROP TABLE shortage_urls");
        $connection->query(file_get_contents($baseDir."/sql/01_shortage_urls.sql"));
        Vizualizer_Database_Factory::commit($connection);
    }catch(Vizualizer_Exception_Database $e){
        Vizualizer_Database_Factory::rollback($connection);
    }

    echo "インストールが完了しました。";
    exit;
}
?>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>簡易インストーラー</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<body>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="span12 center login-header">
                <h2>簡易インストーラー</h2>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
        <div class="row-fluid">
            <div class="center span5">
                <div class="well spa12 login-box">
                    <form action="install.php" method="post">
                        <fieldset>
                            <div><label>
                            利用ドメイン
                            <input type="text" name="domain_name" value="" />
                            </label></div>
                            <div><label>
                            メールアドレス
                            <input type="text" name="site_email" value="" />
                            </label></div>
                            <div><label>
                            DB接続先
                            <input type="text" name="database[default][host]" value="" />
                            </label></div>
                            <div><label>
                            DB接続ユーザー
                            <input type="text" name="database[default][user]" value="" />
                            </label></div>
                            <div><label>
                            DB接続パスワード
                            <input type="text" name="database[default][password]" value="" />
                            </label></div>
                            <div><label>
                            DB名
                            <input type="text" name="database[default][name]" value="" />
                            </label></div>
                            <div><label>
                            短縮URL用DB名（オプション）
                            <input type="text" name="database[shortage][name]" value="" />
                            </label></div>
                            <div><label>
                            管理法人名
                            <input type="text" name="company_name" value="" />
                            </label></div>
                            <div><label>
                            管理者名
                            <input type="text" name="operator_name" value="" />
                            </label></div>
                            <div><label>
                            ログインID
                            <input type="text" name="login_id" value="" />
                            </label></div>
                            <div><label>
                            パスワード
                            <input type="text" name="password" value="" />
                            </label></div>
                            <p class="center span5">
                                <button type="submit" name="install" value="install">インストール</button>
                            </p>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!--/row-->
    </div>
    <!--/fluid-row-->
</div>
<!--/.fluid-container-->
</body>
</html>
