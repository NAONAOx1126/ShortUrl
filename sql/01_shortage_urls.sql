CREATE TABLE IF NOT EXISTS `shortage_urls` (
  `url_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '転送URL ID',
  `operator_id` int(11) NOT NULL COMMENT 'オペレータID',
  `url_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '転送URLコード',
  `url_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '転送URL名',
  `pc_url` varchar(1024) COLLATE utf8_unicode_ci NOT NULL COMMENT '転送先URL（PC）',
  `sp_url` varchar(1024) COLLATE utf8_unicode_ci NOT NULL COMMENT '転送先URL（SP）',
  `mb_url` varchar(1024) COLLATE utf8_unicode_ci NOT NULL COMMENT '転送先URL（MB）',
  `pc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'PCのリンクの状態',
  `sp_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'SPのリンクの状態',
  `mb_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '携帯のリンクの状態',
  `custom_tag` varchar(8192) COLLATE utf8_unicode_ci NOT NULL COMMENT 'リダイレクトページに仕込むカスタムタグ',
  `description` varchar(2048) COLLATE utf8_unicode_ci NOT NULL COMMENT 'メモ',
  `create_time` datetime NOT NULL COMMENT 'データ登録日時',
  `update_time` datetime NOT NULL COMMENT 'データ最終更新日時',
  PRIMARY KEY (`url_id`),
  UNIQUE KEY `url_code` (`operator_id`,`url_code`),
  KEY `operator_id` (`operator_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='転送URLテーブル'
