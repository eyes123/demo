require.config({
    paths: {
        "jquery": "jquery-1.11.1.min",
        
        "jquery.lazyload": "jquery.lazyload-1.9.1.min",
    },
    shim: {
        'jquery.lazyload': {
            deps: ['jquery'],
            exports: 'lazyload'
        },
    },
    waitSeconds: 0
});

//公共
require(['jquery', 'jquery.lazyload'], function($, lazyload) {
	//预加载
    lazyFn();
	// 切换输入框
	$(".inputUserBox .phone-block").on('click', function() {
		
		$('#phone').val('').show().focus();
	});
	
	$(".inputUserBox .veryCodeInput").on('click', function() {
		$('#veryCode').val('').show().focus();
	});
	
	$('#phone, #veryCode').on('blur',function(){
		if( ($(this).val()).length == 0 )
			$(this).hide();
	});
	
	$(".openBuyFrom").on('click', function() {
		window.location.href = 'http://'+ document.domain +'/index.php/Mobile/wx/buy';
		
	});
	
	$(".openInvitationFrom").on('click', function() {
		window.location.href = 'http://'+ document.domain +'/index.php/Mobile/wx/send_share';
	});
	
	$(".openShare").on('click', function() {
		window.location.href = 'http://'+ document.domain +'/index.php/Mobile/wx/send_share';
	});
	
	$(".invitationSendBtn").on('click', function() {
		 layer.open({content: '点击右上角发送至朋友或朋友圈即可获取500元艺术基金！', time: 0});
	});
	// 发送验证码
	function sendSms(){
		
		$(".sendSmsBtn").on('click', function() {
			var RegPhone = /^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0-9]|17[0-9])\d{8}$/;
			var $phoneNum = $("#phone").val();
			if( $phoneNum.length  < 1 ){
				 layer.open({content: '请输入手机号',style: 'background-color:rgba(0,0,0,0.5); color:#fff; border:none;', time: 1});
				 return;
			}
			else if( !RegPhone.test($phoneNum) ){
				layer.open({content: '请输入正确的手机号',style: 'background-color:rgba(0,0,0,0.5); color:#fff; border:none;', time: 1});
				return;
			};
			var url = 'http://wx.miaobihantang.com/Mobile/Index/send_yzm?phone=' + $phoneNum;
			//发送验证码
			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'json'
			})
			.done(function(resp) {
				
				if( resp.state == 2 ){
				
					layer.open({content: '暗号发送成功', style: 'background-color:rgba(0,0,0,0.5); color:#fff; border:none;', time: 1});
					//发送成功
					 var wait = 30;
					(function time(elem) {
						if (wait == 0) {
							elem.removeAttr("disabled");
							elem.text('获取暗号');
							sendSms();							
							wait = 30;
						} else {
							$('.sendSmsBtn').unbind();
							elem.attr("disabled", true);
							elem.text(wait+'s后获取');
							wait--;
							setTimeout(function() {
								time(elem)
							},
							1000)
						}
					})($(".sendSmsBtn"));
					return;
				}else{
					layer.open({content: resp.message,style: 'background-color:rgba(0,0,0,0.5); color:#fff; border:none;', time: 1});
				}
			});
		});
	}

	sendSms();
	// 检查验证码是否正确
	$("#veryCode,#phone").bind("input propertychange",function(){
		var _phone = $("#phone").val();
		var _val = $(this).val();
		
		var regNumber = /^[0-9]{5}$/;
		var regPhone = /^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0-9]|17[0-9])\d{8}$/;
		if(!regPhone.test(_phone) || !regNumber.test(_val) ){
			$(".yueBtnActive").addClass("yueBtndisabled").removeClass("yueBtnActive");	
			$('#openDetail').unbind();
			return;
		}
		var url = 'http://wx.miaobihantang.com/Mobile/Index/yz_py';
		//验证验证码
		$.ajax({
			url: url,
			type: 'POST',
			data:{phone: _phone, yzm: _val},
			dataType: 'json'
		})
		.done(function(resp) {
			if( resp.code != 0 ){
				//验证失败
				 layer.open({content: resp.message,style: 'background-color:rgba(0,0,0,0.5); color:#fff; border:none;', time: 1});
				return;
			}
			else{
				$(".yueBtndisabled").addClass("yueBtnActive").removeClass("yueBtndisabled");
				
				// 绑定打开活动详情页
				$("#openDetail").bind("click",function(){
					window.location.href = resp.url;
				});
			}
		});
	});
});

//给手机端添加active
document.addEventListener("touchstart", function() {}, false);
(function(root) {
	var docEl = document.documentElement,
        timer = null,
        isfirstin = true;

    function changeview() {
        document.getElementById("container").style.visibility = "visible";
        document.getElementById("myloading").style.display = "none";
    }

    function changeRem() {
        root.rem = Math.min(20, docEl.getBoundingClientRect().width / 32 * 1.2);
        docEl.style.fontSize = root.rem + 'px';
        if (isfirstin) {
            setTimeout(changeview, 100);
            isfirstin = false;
        }
    }

    function tChangeRem() {
        timer && clearTimeout(timer);
        timer = setTimeout(changeRem, 300);
    }
    root.addEventListener('resize', tChangeRem);
    changeRem();
    setInterval(function() {
        changeview();
    }, 3000);
})(window);

function lazyFn() {
    $("img.lazy").lazyload({
        placeholder: 'images/png.png',
        effect: "fadeIn",
        skip_invisible: false,
        threshold: 200
    });
}