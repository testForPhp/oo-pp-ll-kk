# 网站导航

 - 定时任务
 
 `* */1 * * * curl xxx.com/create/html/s`   创建静态首页
 
 `* 0 * * * curl xxx.com/s/auto/s/update/status ` 更新状态：推荐|排名|加色|广告
 
 `0 3 * * 2 curl xxx.com/s/auto/check/link` 提取检查链接
 
 `20-60/1 3 * * 2 curl xxx.com/s/auto/check/link/check `  检查链接是否可以访问