# Ownnet DDNS Web端
使用Yii2 Basic模板编写，数据库基于sqlite

## 安装与使用
*{path}为指向程序根目录的地址*  
### apache/nginx+php+sqlite3
  Windows：  
  推荐使用wamp集成环境  
  其他系统： 
  安装apache/nginx+php后，需要手动安装php-sqlite3支持 

### 服务器配置
必要说明:

1. Apache确保开启了mod_rewrite模块
2. 网站根目录指向`{path}/web`目录；如果根目录指向`{path}`目录，也可以正常使用（.htaccess已将其rewrite至web目录），只是此时url中会有/web 目录名称。
3. nginx下未进行详细测试，使用nginx时参照以上两点  


### 源码下载及配置文件修改
#### 源码下载
git clone或者http方式下载并解压本仓库
#### composer安装
1、前往[Composer](https://getcomposer.org/download/)官网下载安装并配置composer  
2、在{path}中执行composer install  

简要方法：  
Linux系统下，可直接在{path}中执行：（如果php安装正常的话）  
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

php composer.phar install
```
#### 目录权限
Windows系统下一般不会出现权限错误。  
Linux下：  
`{path}/runtime/`和`{path}/web/assets/`目录设置为对www-data用户可读写执行  
将main.db及所在目录设置为对www-data用户可读写执行  
参考命令：
```
chgrp www-data databasedir
chgrp www-data databasedir/main.db
chmod g+w databasedir
chmod g+w databasedir/main.db
```  

#### 配置修改
1. 修改  `{path}/config/db.php`  
'dns'=>'sqlite:path/to/main.db',
修改为指向main.db文件的实际路径；该文件默认位于ownnet/ddns_ns_server仓库  
**注意：该文件为数据库，请勿放置在http可访问的目录**    
2. 修改`{path}/config/params.php`  
修改adminEmail及默认时区