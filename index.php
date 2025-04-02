<?php
session_start();
$emotions = [
    '[微笑]' => 'wx.gif',
    '[晕]' => 'y.gif',
    '[心花怒放]' => 'xhnf.gif',
    '[鼓掌]' => 'gz.gif',
    '[哈欠]' => 'hax.gif', 
    '[憨笑]' => 'sx.gif',   
    '[汗]' => 'han.gif',
    '[吃惊]' => 'cj.gif',
    '[鄙视]' => 'bs.gif',
    '[闭嘴]' => 'bz.gif', 
    '[呲牙]' => 'cy.gif',
    '[害羞]' => 'hx.gif',
    '[衰]' => 'shuai.gif',
    '[偷笑]' => 'tx.gif',
    '[折磨]' => 'zm.gif', 
    '[难过]' => 'ng.gif',
    '[示爱]' => 'sa.gif',
    '[可爱]' => 'ka.gif',
    '[泪]' => 'lei.gif',
    '[酷]' => 'cool.gif', 
    '[发呆]' => 'fd.gif',
    '[敲打]' => 'qd.gif',
    '[再见]' => 'zj.gif',
    '[强]' => 'qiang.gif',
    '[差劲]' => 'cha.gif', 
    '[顶你]' => 'ding.gif',
    '[勾引]' => 'gy.gif',
    '[耶]' => 'ye.gif'
    ];
    // IP库解析类
$ipadress = $_SERVER['REMOTE_ADDR'];
$response = file_get_contents("http://www.geoplugin.net/json.gp?ip=". $ipadress . "&lang=zh-CN");
$details = json_decode($response);
$city = $details->geoplugin_city;
$region = $details->geoplugin_region;



// 系统识别函数
function getOS($ua) {
    $os_platform = "未知";
    $os_array = array(
        // 移动设备优先
        '/android/i'                => 'Android',
        '/iphone|ipad|ipod/i'       => 'iOS',
        '/windows phone/i'          => 'Windows Phone',
        '/blackberry|rim tablet os|bb10/i' => 'BlackBerry',
        '/symbian|symbos/i'         => 'Symbian',

        // 桌面 Windows 系列（从新到旧）
        '/windows nt 10.0/i'        => 'Windows 10',
        '/windows nt 6.3/i'         => 'Windows 8.1',
        '/windows nt 6.2/i'         => 'Windows 8',
        '/windows nt 6.1/i'         => 'Windows 7',
        '/windows nt 6.0/i'         => 'Windows Vista',
        '/windows nt 5.2/i'         => 'Windows Server 2003',
        '/windows nt 5.1/i'         => 'Windows XP',
        '/windows nt 5.0/i'         => 'Windows 2000',

        // 苹果桌面系统
        '/macintosh|mac os x/i'     => 'Mac OS X',

        // Linux 发行版（具体到通用）
        '/ubuntu/i'                 => 'Ubuntu',
        '/fedora/i'                 => 'Fedora',
        '/debian/i'                 => 'Debian',
        '/linux mint/i'             => 'Linux Mint',
        '/centos/i'                 => 'CentOS',
        '/opensuse/i'               => 'openSUSE',
        '/gentoo/i'                 => 'Gentoo',
        '/arch linux|arch/i'        => 'Arch Linux',
        '/linux/i'                  => 'Linux',

        // 其他操作系统
        '/cros/i'                   => 'Chrome OS',
        '/freebsd/i'                => 'FreeBSD',
        '/openbsd/i'                => 'OpenBSD',
        '/netbsd/i'                 => 'NetBSD',
        '/sunos|solaris/i'          => 'Solaris',
        '/playstation/i'            => 'PlayStation',
        '/xbox/i'                   => 'Xbox',
        '/nintendo switch/i'        => 'Nintendo Switch',
        '/tizen/i'                  => 'Tizen',
        '/webos/i'                  => 'WebOS'
    );
    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $ua)) $os_platform = $value;
    return $os_platform;
}

function getPhone($ua) {
    $mobile_brand = "PC";
    $brand_array = array(
        '/iphone/i'                => 'iPhone',
        '/huawei/i'                => 'Huawei',
        '/honor/i'                 => 'Honor',    // 荣耀属于华为
        '/xiaomi/i'                => 'Xiaomi',
        '/redmi/i'                 => 'Redmi',    // 红米属于小米
        '/oppo/i'                  => 'OPPO',
        '/realme/i'                => 'Realme',    // Realme 与 OPPO 关联但独立品牌
        '/vivo/i'                  => 'Vivo',
        '/samsung/i'               => 'Samsung',
        '/oneplus/i'               => 'OnePlus',
        '/sony/i'                  => 'Sony',
        '/xperia/i'                => 'Sony',      // 索尼手机型号标识
        '/lg/i'                    => 'LG',
        '/motorola/i'              => 'Motorola',
        '/moto/i'                  => 'Motorola',  // Moto 型号常见前缀
        '/nokia/i'                 => 'Nokia',
        '/google/i'                => 'Google',
        '/pixel/i'                 => 'Google',    // Google 亲儿子系列
        '/lenovo/i'                => 'Lenovo',
        '/zte/i'                   => 'ZTE',
        '/asus/i'                  => 'ASUS',
        '/rog phone/i'             => 'ASUS',      // 华硕游戏手机系列
        '/meizu/i'                 => 'Meizu',
        '/blackberry/i'            => 'BlackBerry',
        '/htc/i'                   => 'HTC',
        '/alcatel/i'               => 'Alcatel',
        '/sharp/i'                 => 'Sharp',
        '/tecno/i'                 => 'Tecno',
        '/infinix/i'               => 'Infinix',
        '/poco/i'                  => 'POCO',      // 小米子品牌
        '/micromax/i'              => 'Micromax',
        '/lava/i'                  => 'Lava',
        '/gionee/i'                => 'Gionee',
        '/coolpad/i'               => 'Coolpad',
        '/leeco/i'                 => 'LeEco',
        '/nexus/i'                 => 'Nexus',     // 谷歌Nexus系列
        '/windows phone/i'         => 'Microsoft'  // 微软Lumia系列
    );
    foreach ($brand_array as $regex => $value)
        if (preg_match($regex, $ua)) $mobile_brand = $value;
    return $mobile_brand;
}

   // 处理表单提交
$error_msg = ''; // 初始化错误信息变量
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 验证码校验
    if ($_POST['captcha'] != $_SESSION['captcha']) {
        $error_msg = "验证码错误！";
    }
    // 检查提交频率
    else if (isset($_SESSION['last_submit']) && (time() - $_SESSION['last_submit'] < 60)) {
        $error_msg = "提交过于频繁，请稍后再试！";
    }
    // 获取并验证数据
    else {
        $name = htmlspecialchars(trim($_POST['name']));
        $message = htmlspecialchars(trim($_POST['message']));
        if (empty($name) || empty($message)) {
            $error_msg = "姓名和留言内容不能为空！";
        }
    }

    // 如果没有错误则处理数据
    if (empty($error_msg)) {
        $_SESSION['last_submit'] = time();

        // 处理表情替换
        $message = trim($_POST['message']);
        foreach($emotions as $code => $img){
            $message = str_replace(
                $code, 
                '<img src=./images/emotions/'.$img.' class="emotion">', 
                $message
            );
        }
        
        // 安全过滤
        $message = strip_tags($message, '<img>');
        $message = htmlspecialchars($message);
        $message = preg_replace('/&lt;(img.*?)&gt;/i', '<$1>', $message);


        
        // 生成记录
        $data = [
            'id' => count(file('data.txt')) + 1,
            'name' => $name,
            'time' => date('Y-m-d H:i:s'),
            'ip' => $ipadress,
            'city' => $city,
            'os' => getOS($_SERVER['HTTP_USER_AGENT']),
            'phone' => getPhone($_SERVER['HTTP_USER_AGENT']),
            'message' => $message
        ];

        // 保存数据并重定向
        file_put_contents('data.txt', json_encode($data).PHP_EOL, FILE_APPEND);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
// 分页设置
$per_page = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$records = file('data.txt');
$total = count($records);
$total_pages = ceil($total / $per_page);
$records = array_reverse(array_slice($records, ($page-1)*$per_page, $per_page));
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>留言本</title>
    <style>
    body { 
       background-color:white;
       font:normal normal 12px/1.1 'Microsoft Yahei',Tahoma,Verdana,Arial,Sans-Serif;}
        .form-box{padding: 10px;}
        .message{margin-bottom: 20px;border:1px solid #ccc;color:#666;}
        .header{display: flex;justify-content: space-between;padding: 10px;background:#fff;}
        .content{padding: 15px; background: #fff; }
		.name{width: 200px; margin: 5px 0; padding: 8px;  border: 1px solid #000;}
		.captcha{width: 50px; margin: 5px 0; padding: 8px;border: 1px solid #000;} 
		.name:focus {outline: none;border-color:#ff4757;}
		textarea:focus{outline: none;border-color:#ff4757;}
		.captcha:focus{outline: none;border-color:#ff4757;}
        textarea{width: 99.6%; margin: 5px 0; padding: 8px; }
        button{cursor:pointer;width:72px;margin: 0 7px;padding:8px;line-height:1;color:#666;background-color:#eee;border:1px solid #999;}
        button:focus,button:hover{background-color:#999;border-color:#000;}
        .captcha-box{margin: 5px 0;padding:8px; }
        .pagination{margin-top: 20px;text-align:center; }
        .pagination a{display:inline-block;padding: 5px 10px;margin: 0 2px;border:1px solid #000;text-decoration: none;}
        a{color:#666;text-decoration:none;}
        a:focus,a:hover{color:#000;text-decoration:none;}
        /*表情样式 */
        .emotion-panel{margin: 0px -8px;}
        .emotion-item{cursor: pointer;margin:5px;transition:transform 0.2s;width:24px;vertical-align: middle;}
        .emotion-item:hover{transform: scale(1.2);}
    </style>
</head>
<body>
    <!-- 留言表单 -->
        <div class="form-box">
        <?php if (!empty($error_msg)): ?>
            <div style="color:red; margin-bottom:10px; padding:8px; border:1px solid red;width: 99.6%;">
                <?= $error_msg ?>
            </div>
        <?php endif; ?>
		
        <form method="post">
            <input class="name" type="text" name="name" placeholder="姓名" required>
            <textarea name="message" id="message" rows="4" placeholder="留言内容" required></textarea>
            
            <div class="emotion-panel">
                <?php foreach($emotions as $code => $img): ?>
                    <img src="./images/emotions/<?=$img?>" 
                         class="emotion-item"
                         title="<?=$code?>"
                         onclick="insertEmotion('<?=$code?>')">
                <?php endforeach; ?>
            </div>


            <div class="captcha-box">
                <input class="captcha" type="text" name="captcha" placeholder="验证码" required>    <img src="captcha.php?<?=time()?>" onclick="this.src='captcha.php?'+Math.random()" style="margin: -10px 0;" >
            </div>
            <button type="submit">发  送</button>
        </form>
    </div>

    <!-- 留言列表 -->
    <?php foreach($records as $record): 
        $msg = json_decode($record, true);
        // 直接输出已处理的安全HTML
        $display_message = str_replace(["\r\n", "\n", "\r"], '<br>', $msg['message']);
    ?>
        <div class="message">
            <div class="header">
                <span><?=$msg['id']?>.楼   <?=$msg['name']?> </span>
                <span>
                     
                    <?=$msg['city']?>  <?=$msg['time']?>
                </span>
            </div>
            <div class="content"><?=$display_message?></div>
			<?php if (!empty($msg['reply'])): ?>
           <div class="admin-reply" style="margin:10px;padding:10px;background:#f0f0f0;border-radius:4px;color:#666;">
           <strong style="color:red">管理员:</strong>
		   <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?= str_replace(["\r\n", "\n", "\r"], '<br>', htmlspecialchars($msg['reply'])) ?>
           </div>
    <?php endif; ?>
        </div>
    <?php endforeach; ?>

<!-- 分页 -->

        <div class="pagination">

		<span style="margin-left:15px;color:red;"><?= $total ?>条留言</span>
        <?php
        $prev_page = max(1, $page - 1);
        $next_page = min($total_pages, $page + 1);
        
        // 首页
        echo $page > 1 
            ? '<a href="?page=1">首页</a>'
            : '<span class="disabled">首页</span>';
        
        // 上一页
        echo $page > 1 
            ? '<a href="?page='.$prev_page.'">上一页</a>'
            : '<span class="disabled">上一页</span>';
        
        // 页码
        $start = max(1, $page - 2);
        $end = min($total_pages, $page + 2);
        for($i = $start; $i <= $end; $i++):
            echo $i == $page 
                ? '<span class="current">'.$i.'</span>'
                : '<a href="?page='.$i.'">'.$i.'</a>';
        endfor;
        
        // 下一页
        echo $page < $total_pages 
            ? '<a href="?page='.$next_page.'">下一页</a>'
            : '<span class="disabled">下一页</span>';
        
        // 末页
        echo $page < $total_pages 
            ? '<a href="?page='.$total_pages.'">末页</a>'
            : '<span class="disabled">末页</span>';
        ?>
		<br><br>
		<a href="admin.php">管理</a>		
    </div>

    <script>
        // 表情插入功能
        function insertEmotion(code) {
            const textarea = document.getElementById('message');
            const startPos = textarea.selectionStart;
            const endPos = textarea.selectionEnd;
            
            // 在光标位置插入表情代码
            textarea.value = 
                textarea.value.substring(0, startPos) +
                code +
                textarea.value.substring(endPos);
            
            // 聚焦并定位光标
            textarea.focus();
            textarea.selectionStart = textarea.selectionEnd = startPos + code.length;
        }
    </script>
</body>
</html>