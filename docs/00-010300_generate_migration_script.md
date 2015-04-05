DEVELOP : Generate Migration Script
-----------------------------------

- Generate migration script (with **Yii2 Yiic**)

```sh
// master table
$ yii migrate/create --migrationPath=@vendor/adipriyantobpn/klog-country/migrations add_tb_MASTER_TABLE_NAME

// transaction table
$ yii migrate/create --migrationPath=@vendor/adipriyantobpn/klog-country/migrations add_tb_TRANSACTION_TABLE_NAME
```

- Define columns for each table

```php
    private $tb_name = '{{%MASTER_TABLE_NAME}}';
    ...
        $this->createTable($this->tb_name, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'descr' => Schema::TYPE_TEXT,

            'status' => Schema::TYPE_STRING . '(20) NOT NULL',
            'created_at' => Schema::TYPE_DATETIME,
            'updated_at' => Schema::TYPE_DATETIME,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
        ], $tableOptions);
```

- Execute migration script

```sh
// execute migration script
$ yii migrate --migrationPath=@vendor/adipriyantobpn/klog-country/migrations

// undo migration script for 5 steps
$ yii migrate/down 5 --migrationPath=@vendor/adipriyantobpn/klog-country/migrations

// redo migration script for 5 steps
$ yii migrate/redo 13 --migrationPath=@vendor/adipriyantobpn/klog-country/migrations
```