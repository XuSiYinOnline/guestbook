<?php
 include( 'password.php');
session_start();
// 共用表情库
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

// 处理管理员回复
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $reply = trim($_POST['reply']);
    
    // 安全过滤
    $reply = htmlspecialchars($reply);
    $reply = str_replace(["\r\n", "\n", "\r"], '<br>', $reply);

    // 读取并更新数据
    $records = file('data.txt');
    $updated = [];
    foreach ($records as $record) {
        $data = json_decode(trim($record), true);
        if ($data['id'] === $id) {
            $data['reply'] = $reply;
        }
        $updated[] = $data;
    }
    
    // 保存修改
    file_put_contents('data.txt', '');
    foreach ($updated as $data) {
        file_put_contents('data.txt', json_encode($data).PHP_EOL, FILE_APPEND);
    }
    
    header("Location: admin.php");
    exit;
}

// 读取所有留言
$records = array_reverse(file('data.txt'));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>留言管理</title>
    <style>
        body{padding:20px;background:#f5f5f5;font:normal normal 12px/1.1 'Microsoft Yahei',Tahoma,Verdana,Arial,Sans-Serif;}
        .message{background: white;margin-bottom:20px;border-radius:5px;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
        .header{padding:15px;border-bottom:1px solid #eee;display: flex;justify-content: space-between;font-size:12px;color:#666;}
        .content{padding:15px;line-height:1.6;font-size:12px;color:#666;}
        .reply-form{padding:15px;border-top: 1px dashed #eee;}
        textarea{width:98%;margin:10px 0;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:12px;color:#666;}
		textarea:focus{outline: none;border-color:#ff4757;}
        .admin-reply{background: #f8f9fa;padding:15px;margin:10px;border-radius:4px;font-size:12px;color:#666;}
        button{cursor:pointer;width:72px;margin:0 7px;padding:8px;line-height:1;color:#666;background-color:#eee;
		border:1px solid #999;}
        button:focus,button:hover{background-color:#999;border-color:#000;}
		h2{color:#666;}
    </style>
<head>
<body>
    <h2>留言管理</h2>
    
    <?php foreach ($records as $record): 
        $msg = json_decode(trim($record), true);
        $original_message = str_replace('<br>', "\n", strip_tags($msg['message'], '<img>'));
    ?>
    <div class="message">
        <div class="header">
            <div>
                <strong><?= $msg['id'] ?>.楼</strong> 
                <?= $msg['name'] ?> <?= $msg['time'] ?>
            </div>
            <div>
                <?= $msg['ip'] ?> - <?= $msg['city'] ?>
            </div>
        </div>
        
        <div class="content">
            <?= $msg['message'] ?>
        </div>

        <?php if (!empty($msg['reply'])): ?>
        <div class="admin-reply">
            <strong style="color:red">管理员:</strong>
		    <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?= $msg['reply'] ?>
        </div>
        <?php endif; ?>

        <form class="reply-form" method="post">
            <input type="hidden" name="id" value="<?= $msg['id'] ?>">
            <textarea name="reply" placeholder="输入回复内容" rows="3"><?= 
                isset($msg['reply']) ? str_replace('<br>', "\n", $msg['reply']) : '' 
            ?></textarea>
            <button type="submit">保存回复</button>
        </form>
    </div>
    <?php endforeach; ?>
</body>
</html>