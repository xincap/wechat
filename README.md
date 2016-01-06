# 1、安装说明 #
1. 将 **migrations** 拷贝到系统 **migrations** 目录下。
2. 执行 **php artisan migrate** 进行迁移。
3. 打开系统下的 **DatabaseSeeder.php** 增加下列代码

`$this->call(WechatSeeder::class);`

`$this->call(PluginSeeder::class);`
