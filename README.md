＃　mogitate
＃＃　環境構築
-　Dockerビルド
　1. git clone  git@github.com:emru30/mogitate.git
　2. docker-compos up -d --build
＃＃＃　Laravel環境構築
　1. docker-compose exec php bash
　2. composer install
　3. .envに以下を追加
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
　4. アプリケーションキーの作成
php artisan key:generate
　5. マイグレーションの実行
php artisan migrate
　6. シーディングの実行
php artisan db:seed
＃＃＃＃　実行環境
・PHP8.0
・MySQL8.0.26
＃＃＃＃＃　URL
・開発環境：http://localhost/
・phpMyAdmin：http://localhost:8080/
