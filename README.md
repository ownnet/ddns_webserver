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
#### 配置修改
1. 修改  `{path}/config/db.php`  
'dns'=>'sqlite:path/to/main.db',
修改为指向main.db文件的实际路径；该文件默认位于ownnet/ddns_ns_server仓库  
**注意：该文件为数据库，请勿放置在http可访问的目录**    
2. 修改`{path}/config/params.php`  
修改adminEmail及默认时区