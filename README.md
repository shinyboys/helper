# 微擎小程序模块 TP6.0 框架助手函数库

~~~
use think\helper\MicroEngine;
~~~

```php
// 检测当前是否在微擎框架中
MicroEngine::isMicroEngine()

// 获取当前模块标识
MicroEngine::getModuleName()

// 获取微擎平台 uniacid
MicroEngine::getUniacid()

// 返回包含uniacid的数组
MicroEngine::uniacid($data = null)
```