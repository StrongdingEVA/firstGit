@extends("Home.foot")

@extends("Home.header")

@section('content')
	<style>
		.record-div{height: 400px;border: 1px solid #ccc;}
		.record-all{height: 330px;margin: 0px;overflow-y: scroll}
		.record{width:96%;margin:5px 2% 5px 2%;}
		.record h4{height: 30px;line-height: 30px;margin: 3px 0px 3px}
		.record p{text-indent: 30px}
		.user_one{color: #00a0e9}
		.user_two{color: #01C675}
		.show-tip{width: 100%;margin: 10px 0px 20px;text-align: center;height: 40px;line-height: 40px}
	</style>
<div class="main-body" style="width: 800px;margin: 0px auto">
	<div class="form-group record-div">
		<div class="record-all">

		</div>
		<div class="show-tip">
			<span>以上是历史消息</span>
		</div>
	</div>

	<form action="/doSendMsg" method="post" id="sendForm">
		<input type="hidden" type="text" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="toUserId" value="{{$userInfo->id}}">
		<input type="hidden" name="messageType" value="1">
		<input type="hidden" name="pubserType" value="2">
	  	<div class="form-group">
        	<div class="input-group">
            	<input type="text" name="message" required="required" class="form-control">
            	<span class="input-group-btn">
                	<input type="button" class="btn btn-default sendmsg" value="发送">
            	</span>
        	</div>
	  	</div>
	</form>
</div>
	<script>
		$(function(){
			$('.sendmsg').click(function(){
			    var message = $('[name="message"]').val();
				if(!message){
				    alert("消息不能为空");return false;
				}
			    var form_ = $("#sendForm").serialize();
				$.phpajax("/doSendMsg","post",form_,true,"json",function(data){
				    if(data){
				        var t = new Date();
				        var year = t.getFullYear()
						var month = t.getMonth();
				        var date = t.getDate();
				        var H = t.getHours();
				        var i = t.getMinutes();
				        var s = t.getSeconds();
				        var timeStr = year + '/' + month + '/' + date + ' ' + H + ':' + i + ':' + s;
				        $('[name="message"]').val("");
                        var htmlStr = "";
						htmlStr += '<div class="record">';
						htmlStr += '<h4 class="user_one">{{\Illuminate\Support\Facades\Auth::user()->username}}&nbsp;'+ timeStr +'</h4>';
						htmlStr += '<p>'+ message +'</p>';
						htmlStr += '</div>';
                        $(".record-all").append(htmlStr);
                        var hei = 0;
                        $(".record").map(function(e){
                            hei += $(this).height() + 10;
						});
                        $(".record-all").scrollTop(hei);
					}
				})
			})
		})

        //连接socket服务器
        var socket = io('http://192.168.200.90:6001');
        socket.on('connection', function (data) {
            console.log(data,1111111);
        });

        socket.on('{{@\Illuminate\Support\Facades\Auth::user()->id ? @\Illuminate\Support\Facades\Auth::user()->id : 'all'}}:App\\Events\\SomeEvent', function(data){
        	console.log(data);
			var htmlStr = "";
			var userInfo = data.userInfo;
            if(data.messageType == 1){//文字
            	htmlStr += '<div class="record">';
                htmlStr += '<h4 class="user_one">'+ userInfo.username +'&nbsp;'+ data.sendTime +'</h4>';
                htmlStr += '<p>'+ data.message +'</p>';
                htmlStr += '</div>';
			}
			$(".record-all").append(htmlStr);
            $(".record-all").append(htmlStr);
            var hei = 0;
            $(".record").map(function(e){
                hei += $(this).height() + 10;
            });
            $(".record-all").scrollTop(hei);
        });
	</script>
@endsection