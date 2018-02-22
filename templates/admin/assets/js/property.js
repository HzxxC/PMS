$(function() {
	// 日期插件
    $('#datetimepicker-end').datetimepicker({
        autoclose: true,
        todayHighlight: true,
        minView: "month", //设置只显示到月份
        startView: 2,
        todayBtn: true,
        language: "zh-CN",
        format: "yyyy-mm-dd"
    });

    $("#form-payment").bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            corp_id: {
                validators: {
                    notEmpty: {
                        message: '请选择入驻公司'
                    }
                }
            },
            pay_amount: {
                validators: {
                    notEmpty: {
                        message: '请填写缴费金额'
                    },

                }
            }
        }
    });

    $('#form-payment-submit').on('click', function() {
    	var url = $("#form-payment").attr('action');
        var bootstrapValidator = $("#form-payment").data('bootstrapValidator');
        bootstrapValidator.validate();
        if (bootstrapValidator.isValid()) {
            $.post(url, $('#form-payment').serialize(), function(data) {
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


    $('#corpSelect').on('change', function() {
        setRoomArea($(this).val());
        setRoomNo($(this).val());
    });

    function setRoomArea(id) {
        var doc = "#corpSelect option[value='" + id + "']";
        $('#room_area').val(parseFloat($(doc).data('area')).toFixed(2));
    }

    function setRoomNo(id) {
        var doc = "#corpSelect option[value='" + id + "']";
        $('#room_no').val($(doc).data('rids'));
    }

});