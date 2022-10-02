# 220719-

[Laravel(+Vue.js)でSNS風Webサービスを作ろう！ - Laravelのインストール(Mac編)](https://www.techpit.jp/courses/11/curriculums/12/sections/103/parts/357)

- 手順通り、コマンドをやるがエラーが出る
  
`$ docker-compose exec workspace composer create-project --prefer-dist laravel/laravel . "6.20.0"`

- memory_sizeエラーになった
[LaravelでPHP Fatal error: Allowed memory size ...](https://qiita.com/Qubieeee/items/66f5199e41650d25cbc3)
- localのphp.iniのファイルサイズを変更する
- なぜかメモリサイズ変わらない

- 手順砕いてやってみる
`docker-copmpose exec workspace bash`
- バージョン指定してインストール
[laravelをバージョン指定してインストール](https://technolog.jp/laravel-version-install/)

- 同じくメモリーサイズエラーが出た
[php.iniファイルの場所をターミナルで確認する](https://qiita.com/miriwo/items/acb49b0a97b5d5fa47fd)
- php.ini場所確認して
- ini-development, ini-productionはあったが、php.iniなかった
- ini-development, ini-productionのメモリサイズが128Mだったので -1 として
- ini-developmentをphp.iniとしてコピー作成

- 再度バージョン指定でインストール
- 動き始めた、結構進んだ
- けどトークン求められたエラー

- apt-get install とか apt-get update　とか
- git, vim, unzip, zip
[Composer でライブラリをインストールした際に Cloning failed using an ssh ... が出たときの対応内容](https://tt-computing.com/composer-cloning-failed-ssh)
- 再度バージョン指定でインストール
- ようやくできたけどディレクトリが `laravel/laravel` (無駄な階層)になったのでローカル側を修正

- localhostでlaravelの画面出てきた
["storage/logs/laravel.log" could not be opened: failed to open stream: ...](https://akizora.tech/laravel-log-error-4495)

---

``` sql
psql -U default -h postgres -d larasns

passwordはsecret
```

---

## 学んだこと

- リソースフルルート
- DI(インスタンス引数)
- @auth @guest  
- PUT PATCHメソッド
- belongsTo(users<-article.user_id) 
- hasOne(users->article.user_id)

## 振り返り
- 33 /100 % = あと2日でできる算段
- リソースフルルート使えば、CRUD作るの容易→これに当てはめて、機能を考えるべき

---

# 220722

- authorizeResourceメソッド
- ポリシー
- ゲストユーザー(nullable型)

- firstOrCreate
- attach, detach
- モデルprotected, guarded
- ディレクティブ種類(loop)
- アクセサ
- 戻り値の指定 function(): intみたいな
- 引数も同様に function(string $var)とした方がいい
- joinとか使わずして、belongsToとかつかって、モデルから引っ張ってくれば、モデルの変数(インスタンス)だけ格納すれば、viewで実行できるね
- Route::prefix('users')->name('users.')->group(function () {… name()後付けの書き方できる

- @include('users.tabs', ['hasArticles' => true, 'hasLikes' => false]) 値を渡せるみたい