<div align="center">

# Dcat Laravel Log Viewer

<p>
    <a href="https://github.com/jqhph/laravel-log-viewer/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-7389D8.svg?style=flat" ></a>
     <a href="https://styleci.io/repos/215738797">
        <img src="https://github.styleci.io/repos/215738797/shield" alt="StyleCI">
    </a>
    <a href="https://github.com/jqhph/laravel-log-viewer/releases" ><img src="https://img.shields.io/github/release/jqhph/laravel-log-viewer.svg?color=4099DE" /></a> 
</p>

`Dcat Log Viewer`是一个`Laravel`日志查看工具，支持大文件日志的查看和搜索功能，更改自[laravel-admin-extensions/log-viewer](https://github.com/laravel-admin-extensions/log-viewer)。

</div>

![](https://cdn.learnku.com/uploads/images/202007/09/38389/5Ps3bfhdrR.png!large)

## 功能

- [x] 支持多层级目录
- [x] 支持查看大文件日志
- [x] 支持日志关键词检索
- [x] 支持多层级目录文件名称搜索
- [x] 支持下载功能
- [x] 支持分页
- [x] 支持手机页面


## 环境

- PHP >= 7
- laravel >= 5.5


## 安装

```bash
composer require dcat/laravel-log-viewer
```

发布配置文件，此步骤可省略

```bash
php artisan vendor:publish --tag=dcat-log-viewer
```

然后访问 `http://hostname/dcat-logs` 即可

配置文件

```php

return [
    'route' => [
        // 路由前缀
        'prefix'     => 'dcat-logs',
         // 命名空间
        'namespace'  => 'Dcat\LogViewer',
         // 中间件
        'middleware' => [],
    ],

    // 日志目录
    'directory' => storage_path('logs'),

    // 搜索页显示条目数（搜索后不分页，所以这个参数可以设置大一些）
    'search_page_items' => 500,

    // 默认每页条目数
    'page_items' => 30,
];
```

## License
[The MIT License (MIT)](LICENSE).
