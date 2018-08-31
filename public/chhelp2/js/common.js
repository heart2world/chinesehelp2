
/**设置图标层的高度及添加图片层的背景图**/
/**
 obj  需设置图片层的class
 h    需设置图片层高的比例(比例的计算方式为UI图片的 高度/宽度)
 **/
function bgImg(obj, h) {
    var width = $('.' + obj).width();
    $('.' + obj).height(width * h);
    $('.' + obj).each(function() {
        var src = $(this).find('img').attr('src');
        $(this).css('background', 'url(' + src + ') center no-repeat');
        $(this).css('background-size', 'cover');
    });
}

//获取验证码
var bj = 0;
var countdown = 60;
function settime(val) {
	if(countdown == 0) {
		$('.getCode').text('获取验证码').addClass('on');
		$('.getCode').removeClass("active");
		countdown = 60;
		bj = 0;
		return;
	} else {
		$('.getCode').text(countdown + 's后重新发送');
		$('.getCode').addClass("active");
		countdown--;
	}
	setTimeout(function() {
		settime(val)
	}, 1000)
}
function getCode(obj,phone){
	console.log(11);
	console.log(phone);
	if($(obj).hasClass("on")){
        var phone=$('#telInput').val();
        settime(countdown);
		$(obj).removeClass('on').addClass('active');
    }
}
