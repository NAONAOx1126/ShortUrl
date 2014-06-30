<?php
// サイトコード
Vizualizer_Configure::set("timezone", "Asia/Tokyo");

// サイトコード
Vizualizer_Configure::set("site_code", "shortUrl");

// サイト名
Vizualizer_Configure::set("site_name", "短縮URLシステム");

// サイトメールアドレス
Vizualizer_Configure::set("site_email", "minagawa@dot-hacks.com");

// アクセスドメイン
Vizualizer_Configure::set("site_domain", $_SERVER["SERVER_NAME"]);

// サイトホームディレクトリ
Vizualizer_Configure::set("site_home", realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "templates");

// データベースの接続設定
Vizualizer_Configure::set("database", array(
    "default" => array(
        "read" => array(
            "dbtype" => "mysql", "host" => "192.168.252.156",
            "user" => "vizualizer", "password" => "VZP@ssw0rd",
            "database" => "viz_shortage", "query" => "SET NAMES utf8"
        ),
        "write" => array(
            "dbtype" => "mysql", "host" => "192.168.252.156",
            "user" => "vizualizer", "password" => "VZP@ssw0rd",
            "database" => "viz_shortage", "query" => "SET NAMES utf8"
        )
    )
));

Vizualizer_Configure::set("prefilters", array("VizualizerShortage"));
