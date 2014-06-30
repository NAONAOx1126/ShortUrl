CREATE TABLE IF NOT EXISTS `shortage_click_logs` (
  `click_log_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'クリックログID',
  `url_id` int(11) NOT NULL COMMENT '転送URL ID',
  `url_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'アクセスした短縮URLのコード',
  `click_type` int(11) NOT NULL COMMENT '転送種別（1:PC、2:SP、3:MB）',
  `referer` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'クリックしたときのリファラ',
  `user_agent` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'クリックしたときのユーザーエージェント',
  `ip_address` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'アクセス時のIPアドレス',
  `create_time` datetime NOT NULL COMMENT 'データ登録日時',
  PRIMARY KEY (`click_log_id`),
  KEY `url_id` (`url_id`),
  KEY `click_type` (`click_type`),
  KEY `url_code` (`url_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='クリックログテーブル'
