<?php 
include 'guestbook.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="No MySQL Guestbook">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style>
		
		body{
		background: url(images/bg.gif?v20210410) repeat #0a0a0a;
		}
		.container{
			width: 80%;
			margin: 0 auto;
			font-family: sans-serif;
		}
		.content {
		    position: relative;
		}
		/*form, input, textarea{
			width: 80%;
			
		}*/
		form{
			margin-top: 20px;
		}
		input, textarea{
			border-radius: 5px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			padding:5px; 
		}
		input[type="submit"]{
			background: #4CAF50;
			color: #fff;
			cursor: pointer;
			border: 1px solid #4CAF50;
			padding: 10px;
			font-size: 13px;
		}
		input[type="submit"]:hover{
			opacity: .8;
		}

		span.date-mess{
			/*background: #4CAF50;*/
			color: #fff;
			margin-right: 10px;
			padding:0 5px;
			font-size: 13px;
		}
		span.message {
		    padding: 4px;
		    border-radius: 2px;
		    background: #4CAF50;
		    overflow-wrap: anywhere;
		    display: inline-block;
		    position: relative;
		    top: 4px;
		    font-family: sans-serif;
			font-size: 12px;
		}
		span.message:before {
		    content: "";
		    position: absolute;
		    border: 8px solid transparent;
		    border-bottom: 12px solid #4CAF50;
		    top: -13px;
		    left: 1px;
		}
		.bl{
			display: none;
		}
		@media(max-width: 600px){
			.container{
				width: 98%;
			}
			form{
			    width: 95%;
			    margin: 0 auto;
			    margin-bottom: 20px;
			    width: 90%;
			}
			input, textarea{
				width: 100%;
			}
			input[type="submit"]{
				width: 100%;
			}
		}
    span.name {
    color: #4CAF50;
    font-weight: bold;
}
	
	</style>
</head>
	<body>
		<div class="container">
			<?foreach($gb as $text) {?>
				<?=($text)?><br><br>
			<?}?>
			<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" id="form">
				<input type="text" class="form-control" name="name" placeholder="昵称" id="name"  style="width: 180px;">
				<textarea rows="5" name="text"  class="form-control" placeholder="消息内容"></textarea><br>
				<input type="submit"   name="add" value="发送">
			</form>
		</div>
		<script>
			var i2 = document.querySelector('#name');
				i2.value = localStorage.getItem('names');
			i2.oninput = function() {
    			localStorage.setItem('names', i2.value);
 			}
		</script>
	</body>
</html>
