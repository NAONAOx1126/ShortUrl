短縮URLシステム
========

このシステムはサイト上に短縮URL用のエントリを登録し、カウントしつつ、リダイレクトを行うものです。

利用方法
--------

利用方法は、インストール時に設定したアカウントにてログインし、短縮URLを登録します。
この時、短縮URLコードが実際に発行されるURLの末尾となります。
発行されるURLはディレクトリ形式とHTML形式の2パターンがあり、目的に応じて取捨選択してください。

短縮URLにアクセスがあるたびにクリックカウントが加算されます。
日別／月別にクリック数を参照することが可能です。
また、各アクセスの詳細を参照することもできます。

短縮URLのリダイレクトはmeta refreshで0秒リダイレクトを行っています。
そのため、短縮URLのページにカスタムタグを入れることができます。
このカスタムタグにGoogle Analyticsのタグなどを入れることで、アクセス解析にデータを送信することが可能です。

インストール
--------

まず、本zipファイルを解凍したものを、サーバーにアップします。

> さくらのレンタルサーバーを利用している場合は、.htaccessの
> RewriteEngine on
> の後に
> RewriteBase <システムまでのパス>
> を設定してください。
> 例えば、http://test.jp/ShortUrl/にシステムをアップした場合は
> RewriteBase /ShortUrl/
> のように記述します。

> 一部のサーバーでは、magic_quotes_gpcがONになっている場合があります。
> 本システムでは、magic_quotes_gpcはOFFになっている前提で実装されておりますので、magic_quotes_gpcはOFFにしてください。
> なお、PHP5.4.0以降の場合は、該当の設定が削除されておりますので、設定を行う必要はありません。

ファイルのアップロードが完了しましたら、アップしたディレクトリの下にあるinstall.phpをブラウザで開きます。
install.phpのフォームに必要事項を記入し、インストールボタンを押すと、システムがインストールされます。
インストール完了と表示されましたら、インストールが完了しておりますので、アップしたURLを開くとログイン画面が表示されます。

インストールが完了しましたら、アップされているinstall.phpは削除してください。
