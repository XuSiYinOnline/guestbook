<?php
//登陆设置
$LOGIN_INFORMATION = array(
  'admin' => 'admin888'
);
// true-显示登陆和密码框，false-仅显示密码框
define('USE_USERNAME', true);
// 注销后重定向
define('LOGOUT_URL', 'https://www.xusiyin.com');
// 超时设置，0表示不超时
define('TIMEOUT_MINUTES', 0);
//true-上次活动超时时间，false-登陆超时时间
define('TIMEOUT_CHECK_ACTIVITY', true);
// 不要更改下面的代码
// 显示使用示例
if(isset($_GET['help'])) {
  die('页面的开头第一行包含以下代码:<br>&lt;?php include("' . str_replace('\\','\\\\',__FILE__) . '"); ?&gt;');
}
// 超时时间（秒）
$timeout = (TIMEOUT_MINUTES == 0 ? 0 : time() + TIMEOUT_MINUTES * 60);
// 注销退出？
if(isset($_GET['logout'])) {
  setcookie("verify", '', $timeout, '/'); // 清除密码;
  header('Location: ' . LOGOUT_URL);
  exit();
}
if(!function_exists('showLoginPasswordProtect')) {
// 显示登陆表单
function showLoginPasswordProtect($error_msg) {
?>
<html>
<head>
  <title>登陆</title>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <style>
  body { 
       background-color:white;display:flex;justify-content:center;align-items:center;
       font:normal normal 12px/1.1 'Microsoft Yahei',Tahoma,Verdana,Arial,Sans-Serif; }
       input{width:200px;margin:5px 0; padding:8px; border:1px solid #000;}
	   input:focus{outline: none;border-color:#ff4757;}
       button{cursor:pointer;width:72px;margin:0 7px;padding:8px;padding:8px;line-height:1;color:#666;background-color:#eee;
       border:1px solid #999;}
       button:focus,button:hover{background-color:#999;border-color:#000;}
	   .login{text-align:center;}
  </style>
  <div class="login">
  <form method="post">
<?php if (USE_USERNAME) echo '账  号<br/><input type="input" name="access_login" /><br/>密  码<br />'; ?>
    <input type="password" name="access_password" /><p></p><button type="submit">确定</button>
	<br/><br/><br/><font color="red"><?php echo $error_msg; ?></font>
  </form>
  </div>
</body>
</html>
<?php
  // 到此为止
  die();
}
}
// 用户提供的密码
if (isset($_POST['access_password'])) {
  $login = isset($_POST['access_login']) ? $_POST['access_login'] : '';
  $pass = $_POST['access_password'];
  if (!USE_USERNAME && !in_array($pass, $LOGIN_INFORMATION)
  || (USE_USERNAME && ( !array_key_exists($login, $LOGIN_INFORMATION) || $LOGIN_INFORMATION[$login] != $pass ) ) 
  ) {
    showLoginPasswordProtect("密码错误");
  }
  else {
    // 如果密码已验证，则设置cookie
    setcookie("verify", md5($login.'%'.$pass), $timeout, '/');   
    // 清除密码保护器变量
    unset($_POST['access_login']);
    unset($_POST['access_password']);
    unset($_POST['Submit']);
  }
}
else {
  // 检查是否设置了密码cookie
  if (!isset($_COOKIE['verify'])) {
    showLoginPasswordProtect("");
  }
  // 检查cookie是否良好
  $found = false;
  foreach($LOGIN_INFORMATION as $key=>$val) {
    $lp = (USE_USERNAME ? $key : '') .'%'.$val;
    if ($_COOKIE['verify'] == md5($lp)) {
      $found = true;
      // 延长超时时间
      if (TIMEOUT_CHECK_ACTIVITY) {
        setcookie("verify", md5($lp), $timeout, '/');
      }
      break;
    }
  }
  if (!$found) {
    showLoginPasswordProtect("");
  }
}
?>
