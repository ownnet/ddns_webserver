<?php 
	$this->title = 'Register';
?>
<link href="css/chosen.min.css" rel="stylesheet">
<link href="css/charisma-app.css" rel="stylesheet">
<script type="text/javascript">
var csrfToken = "<?php echo Yii::$app->getRequest()->getCsrfToken();?>"

function checkuser(){
	var username=window.document.forms['reg'].elements['username'].value;
	$.post("user/checkunique",
	{
		_csrf:csrfToken,
		type:"user",
		str:username,
	},
	function(data,status){
		if(data==0){
			$("#info").html('');
			$("#btn").removeAttr("disabled");
		}else{
			$("#info").html('用户名已存在');
			$("#btn").attr({"disabled":"disabled"});
		}
	});
}
function checkemail(){
	var email=window.document.forms['reg'].elements['email'].value;
	//邮箱正则检查
	var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	if(reg.test(email)){
		if($("#info").html()=='邮箱格式错误'){
			$("#info").html('');
			$("#btn").removeAttr("disabled");
		}
	}else{
		$("#info").html('邮箱格式错误');
		$("#btn").attr({"disabled":"disabled"});
	}
	//邮箱唯一性检查
	$.post("user/checkunique",
	{
		"_csrf":csrfToken,
		type:"email",
		str:email,
	},
	function(data,status){
		if(data==0){
			if($("#info").html()=='邮箱已存在'){
				$("#info").html('');
				$("#btn").removeAttr("disabled");
			}
		}else{
			$("#info").html('邮箱已存在');
			$("#btn").attr({"disabled":"disabled"});
		}
	});
}
function checkpwd(){
	var password=window.document.forms['reg'].elements['password'].value;
	var confirm=window.document.forms['reg'].elements['confirm'].value;
	if(confirm!=""){
		if(password == confirm){
			$("#info").html('');
			$("#btn").removeAttr("disabled");
		}else{
			$("#info").html('密码不一致');
			$("#btn").attr({"disabled":"disabled"});
		}
	}
}
function sub(){
	var username=window.document.forms['reg'].elements['username'].value;
	var email=window.document.forms['reg'].elements['email'].value;
	var password=window.document.forms['reg'].elements['password'].value;
	var confirm=window.document.forms['reg'].elements['confirm'].value;
	if(username!=''&email!=''&password!=''&confirm!=''){
		//submit
		$.ajax({url:"user/doregister",
			type:"POST",
			data:{
				"_csrf":csrfToken,
				"username":username,
				"email":email,
				"password":password,
				"confirm":confirm
			},
			success:function(data){
				if(data==1){
					alert("success!");
				}else{
					alert("error!");
				}
			}
		});
		//document.getElementById('reg').submit();
	}else{
		$("#info").html('用户名，邮箱及密码均为必填项目');
	}

	//alert(1);
}
</script>
<div class="ch-container">
    <div class="row">
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2> </h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div  class="well col-md-5 center login-box">
            <form id="reg" class="form-horizontal" action="user/doregister" method="post" >
            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Username" onblur="checkuser()">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope red"></i></span>
                        <input id="email" name="email" type="text" class="form-control" placeholder="Email" onblur="checkemail()">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Password" onblur="checkpwd()">
                    </div>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input id="confirm" name="confirm" type="password" class="form-control" placeholder="Password Confirm" onblur="checkpwd()">
                    </div>

                    <div class="clearfix"></div>
                    
                    <span id="info" style="color:red"></span>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button id="btn" type="button" class="btn btn-primary" onclick="sub()">注册</button>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->