# 開発ログ

## 課題定義

- 背景・目的

  - 解決したい課題は？
    - 日々本を読んでも内容を忘れてしまう
    - 読んだ本の感想を記録して置けるようにしたい
    - 書籍名や著者名、評価のスコア、読書状況も管理したいが、既存のメモ帳等だと項目ごとに管理できない
    - 既存の読書管理サービスもあるが、自分好みに項目を設定できない

- ゴール(達成状態)

  - 読書ログを登録できる(書籍名、著者名、読書状況、評価、感想)
  - 読書ログを表示できる

- やらないこと
  - 最低限以外の機能(変更、削除、会員登録機能など)
  - PHP の高度な機能の使用(クラス、例外など)
  - インフラの構築(Heroku を使用)

## インセプションデッキに基づいてやっていく場合

- WHY を明確にする

  - 我々はなぜここにいるのか
  - エレベーターピッチ
  - パッケージデザイン
  - 「ご近所さん」を探せ

- HOW を明確にする
  - 技術的な解決策
  - 夜も眠れない問題
  - 期間を見極める
  - トレードオフスライダー
  - 何がどれだけ必要か

## 要件定義

### 業務要件

- 業務フロー

登場人物ごとに業務(行動)の流れを図にする

### 機能要件

- ページ遷移図
- WF(画面図)
- 機能
- データ

### 非機能要件(今回はやらない)

- 性能
- 拡張性
- 可用性
- セキュリティ

### 運用・保守要件(今回はやらない)

- 運用体制
- 保守体制
- 障害時体制

## タスクバラし

- 必要なタスクだけに取り組める
- 最短経路を探せる
- 自分の仕事を把握し、自立して仕事できる

1. テキスト版アプリケーションを作成
2. アプリケーションをデータベースに対応させる
3. Web アプリケーションを作成
4. Heroku を使用してアプリケーションを Web 上に公開

## コーディング規約

```
PHPではPSRが最もスタンダードなコーディング規約です。中でもPSR-1とPSR-12は基本的な部分をまとめた規約なので、目を通してみましょう。

PSR-1（公式ドキュメント）
https://www.php-fig.org/psr/psr-1/

PSR-1（日本語訳）
https://www.ritolab.com/entry/91

PSR-12(公式ドキュメント)
https://www.php-fig.org/psr/psr-12/

PSR-12(日本語訳)
https://www.ritolab.com/entry/208
```

## DB 接続

```
docker compose exec app mysql -h db -u book_log -D book_log -p
pass
```

```
CREATE TABLE companies
(
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  establishment_date DATE,
  founder VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8mb4;
```

- book_log

```
CREATE TABLE reviews (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(100),
  status VARCHAR(10),
  score INTEGER,
  summary VARCHAR(1000),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8mb4;
```

INSERT INTO reviews (title, author, status, score, summary) VALUES ('PHP 入門', '山田太郎', '読了', 5, 'PHP の入門書です。');
