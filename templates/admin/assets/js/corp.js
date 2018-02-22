$(function() {

    $("#form-corpinfo").bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            corp_name: {
                validators: {
                    notEmpty: {
                        message: '公司名称不能为空'
                    }
                }
            },
            corp_person: {
                validators: {
                    notEmpty: {
                        message: '公司法人不能为空'
                    },

                }
            },
            corp_contact: {
                validators: {
                    notEmpty: {
                        message: '联系方式不能为空'
                    }
                }
            },
            corp_idcard: {
                validators: {
                    notEmpty: {
                        message: '身份证号不能为空'
                    },
                    regexp: {
                        regexp: /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/,
                        message: '请输入正确的身份证号码'
                    }
                }
            }
        }
    });

    $('#form-corp-submit').on('click', function() {
    	var url = $("#form-corpinfo").attr('action');
        var bootstrapValidator = $("#form-corpinfo").data('bootstrapValidator');
        bootstrapValidator.validate();
        if (bootstrapValidator.isValid()) {
            $.post(url, $('#form-corpinfo').serialize(), function(data) {
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
                    $('.ajax-err-msg').addClass('in error').show();
                    setTimeout(function() {
                        $('.ajax-err-msg').removeClass('in error').hide();
                    }, 3000);
                }
            }, 'JSON');
        }
    });

    $('input[type="file"]').on('change', function() {
        var _this = $(this);
        _this.attr('name', 'file');
        fileUpload(_this, 'form-corpinfo', window.GV.UPLOAD);
    });

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