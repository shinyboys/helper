<?php

// +----------------------------------------------------------------------
// | 微擎 TP6.0 框架 微擎助手函数库
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------

/**
 * 检测当前是否在微擎框架中
 *
 * @return boolean true 在(微擎模块) false 不在(独立版,脱离微擎)
 */
function isMicroEngine()
{
    global $_W;
    return !empty($_W['uniacid']);
}

/**
 * 获取微擎模块标识
 */
function module()
{
    global $_W;
    return $_W['current_module']['name'] ?? '';
}

/**
 * 获取微擎平台 uniacid
 */
function getUniacid()
{
    global $_W;
    return $_W['uniacid'] ?? '';
}

/**
 * 返回包含微擎uniacid的数组
 * 
 * @param   $data 附加数据
 * @example uniacid();
 * @example uniacid($data);
 */
function uniacid($data = null)
{
    global $_W;
    $uniacid = isMicroEngine() ? ['uniacid' => $_W['uniacid']] : [];
    return is_null($data) ? $uniacid : array_merge($uniacid, $data);
}

/**
 * 获取本地文件存储目录(绝对路径)
 */
function getLocalStorageDir()
{
    if (isMicroEngine()) {
        return ATTACHMENT_ROOT . module() . '/' . getUniacid();
    } else {
        return public_path() . 'storage';
    }
}

/**
 * 获取本地文件访问前缀(Url前缀)
 */
function getFileAccessPrefix()
{
    if (isMicroEngine()) {
        return implode('/', [request()->domain(), 'attachment', module(), getUniacid(), '']);
    } else {
        return implode('/', [request()->domain(), 'storage', '']);
    }
}

/**
 * 计算两点地理坐标之间的距离
 * 
 * @param  $longitude1 起点经度
 * @param  $latitude1  起点纬度
 * @param  $longitude2 终点经度 
 * @param  $latitude2  终点纬度
 * @param  $unit       单位 1:米 2:公里
 * @param  $decimal    精度 保留小数位数
 */
function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit = 2, $decimal = 2)
{
    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI / 180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if ($unit == 2) {
        $distance = $distance / 1000;
    }
    return round($distance, $decimal);
}
