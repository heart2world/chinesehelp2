// common.js created by Kevin

;(function(_$){
	var CommonJS = {
		_$tips:_$(".js_tooltips"),
		_$toast:$("#loadingToast"),
		_phoneRegExp:/^1[3|4|5|7|8|9][0-9]{9}$/,
		_pwdRegExp:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,21}$/,
		_getUrlParam:function(){
			var json = {};
			if(location.search != null){
				var loc = location.search.substr(1);
				var res = loc.split("&");

				console.log(res);
				var res2 = null;
				for(var i in res){
					res2 = (res[i].split("="));
					console.log(res2);
				}
			}
			json.brand_name = decodeURI(res2[1]);
			return json.brand_name;
		},
		_validateIsPhoneNum:function(str){
			return this._phoneRegExp.test(str);
		},
		_popupErrorTips:function(msg){
			this._$tips.html(msg);
			this._$tips
				.fadeIn()
				.delay(1000)
				.fadeOut();
		},
		_popSuccessToast:function(msg){
			var _self = this;
			this._$toast.find(".weui-toast__content").html(msg);
			this._$toast.find(".weui-icon_toast").removeClass("weui-loading weui-icon-warn weui-icon_msg").addClass("weui-icon-success-no-circle");
			this._$toast.css({"opacity":1,"display":"block"});

			setTimeout(function(){
				_self._hideToast();
			},1500);
		},
		_popErrorToast:function(msg){
			var _self = this;
			this._$toast.find(".weui-toast__content").html(msg);
			this._$toast.find(".weui-icon_toast").removeClass("weui-loading weui-icon-success-no-circle").addClass("weui-icon-warn weui-icon_msg");
			this._$toast.css({"opacity":1,"display":"block"});

			setTimeout(function(){
				_self._hideToast();
			},1500);
		},
		_toast:function(msg,callback){
			this._$toast.find(".weui-icon_toast").removeClass("weui-icon-success-no-circle weui-icon-warn weui-icon_msg").addClass("weui-loading");
			this._$toast.find(".weui-toast__content").html(msg) && this._$toast.css({"opacity":1,"display":"block"});
			if(callback)callback();
		},

		_hideToast:function(){
			this._$toast.css({"opacity":0,"display":"none"});
		},
		_sending:function(obj,s,b,max){
			var _self = this;
			if(s <= 0){
				b = true;
				$(obj).removeClass("sending").removeClass("disabled").html("获取验证码");
				s = max;
				return;
			}else{
				b = false;
				$(obj).addClass("sending").addClass("disabled").html(s+"s后再发送");
				s--;
			}

			setTimeout(function(){
				_self._sending(obj,s,b,max);
				console.log(b);
			},1000);
		},
		_detect_content_length:function(evt,callback){
			evt.preventDefault();
			var maxlen = _$(evt.target).attr("maxlength");
			var _txt = $.trim(_$(evt.target).val()).replace(/\s/g,'');
			_$(evt.target).val(_txt);
			console.log(_txt);
			console.log(_txt.length);

			if(_txt.length >= maxlen){
				_txt.length = 200;
				_$(evt.target).val(_txt.substr(0,200));
				callback && callback(200);
				this._popupErrorTips("最多可输入200个字哦！");
				return false;
			}

			callback && callback(_txt.length);
		},

		//侦测流加载 依赖于layui流加载
		/*
			@param flow加载模块
		*/

		_loadMore:function(config,callback){
			layui.use('flow', function(){
		    var flow = layui.flow;

			  flow.load({
			    elem:config.container,
			    scrollElem:config.scrollElem || document,
			    isAuto:config.auto || true,
				isLazyimg:config.lazyImg || true,
				end:config.end || "没有更多了",
				mb:config.threhold || 50,
			    done:function(page,next){
		       	 if(callback)callback(page,next);
				}
			  });
			})
		}
		//end

	}
	window.comJs = CommonJS;
})(jQuery);
