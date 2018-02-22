$(function() {
	// 日期插件
    $('#datetimepicker-start, #datetimepicker-end').datetimepicker({
        autoclose: true,
        todayHighlight: true,
        minView: "month", //设置只显示到月份
        startView: 2,
        todayBtn: true,
        language: "zh-CN",
        format: "yyyy-mm-dd"
    });

    $("#form-settled").bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            cid: {
                validators: {
                    notEmpty: {
                        message: '请选择入驻公司'
                    }
                }
            },
            rids: {
                validators: {
                    notEmpty: {
                        message: '请选择申请房间号码'
                    },

                }
            }
        }
    });

    $('#form-settled-submit').on('click', function() {
    	var url = $("#form-settled").attr('action');
        var bootstrapValidator = $("#form-settled").data('bootstrapValidator');
        bootstrapValidator.validate();
        if (bootstrapValidator.isValid()) {
            $.post(url, $('#form-settled').serialize(), function(data) {
                if (data.code == 200) {
                    $('.ajax-err-msg p').text(data.message);
                    $('.ajax-err-msg').addClass('in success').show();
                    setTimeout(function() {
                        $('.ajax-err-msg').removeClass('in success').hide();
						var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						parent.layer.close(index); //再执行关闭
						window.location.href = '';
                    }, 3000);
                }
                if (data.code == 400) {
                    $('.ajax-err-msg p').text(data.message);
                    $('.ajax-err-msg').addClass('in warning').show();
                    setTimeout(function() {
                        $('.ajax-err-msg').removeClass('in warning').hide();
                    }, 3000);
                }
            }, 'JSON');
        }
    });

    $('input[type="file"]').on('change', function() {
        var _this = $(this);
        _this.attr('name', 'file');
        fileUpload(_this, 'form-settled', window.GV.UPLOAD);
    });

    $('#roomSelect').on('change', function() {
        sumRoomArea($(this).val());
        sumRoomRent($(this).val());
    });

    function sumRoomArea(ids) {
        var total = 0;
        for (var i = ids.length - 1; i >= 0; i--) {
            var doc = "#roomSelect option[value='" + ids[i] + "']";
            total += parseFloat($(doc).data('area'));
        }
        $('#room_area').val(total.toFixed(2));
    }

    function sumRoomRent(ids) {
        var total = 0;
        for (var i = ids.length - 1; i >= 0; i--) {
            var doc = "#roomSelect option[value='" + ids[i] + "']";
            total += parseFloat($(doc).data('rent'));
        }
        $('#rent').val(total.toFixed(2));
    }

    function fileUpload(e, form, url) {
    	$('#' + form).ajaxSubmit({
            url: url,
            type: "POST",
            dataType: "json",
            success: function(data) {
                if (data.code == 200) {
                    e.removeAttr('name');
                    e.next().val(data.data);
                }
            }
        });
    }


});