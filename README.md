## signature

- 对接口请求进行签名验证
- 本拓展满足psr2,psr4 规范
- 已通过单元测试

## 基本使用
1. 安装
```bash
$ composer require aron/laravel-api-response
```

2. 使用
``` php
use use Aron\Response\Traits\ResponseTrait;

$this->response($data = [],
       $code,
       $status
       $message,
       $errors,
       $headers)
```
