$(function() {

});

function openIframeLayer(url, title, options) {

    var params = {
        type: 2,
        title: title,
        shadeClose: true,
        shade: 0.8,
        area: ['776px', '795px'],
        move: false,
        content: url,
        yes: function (index, layero) {
            //do something
            layer.close(index); //如果设定了yes回调，需进行手工关闭
        }
    };
    params     = options ? $.extend(params, options) : params;

    Wind.css('layer');

    Wind.use("layer", function () {
        layer.open(params);
    });

}

function openIframeButtonLayer(url, title, options) {

    var params = {
        type: 2,
        title: title,
        shadeClose: true,
        shade: 0.8,
        area: ['776px', '795px'],
        btn: ['关闭'],
        move: false,
        content: url,
        yes: function (index, layero) {
            //do something
            layer.close(index); //如果设定了yes回调，需进行手工关闭
        }
    };
    params     = options ? $.extend(params, options) : params;

    Wind.css('layer');

    Wind.use("layer", function () {
        layer.open(params);
    });

}

function openDialogLayer(url, options) {

    var params = {
        type: 1
        ,title: false //不显示标题栏
        ,closeBtn: false
        ,area: '400px;'
        ,shade: 0.8
        ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
        ,btn: ['删除', '取消']
        ,btnAlign: 'c'
        ,moveType: 1 //拖拽模式，0或者1
        ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">你现在的操作是<b style="color:#F00;">删除</b>公司信息<p style="font-size:12px; margin-top: 10px;">执行此操作，将注销该公司的所有信息，包括入驻信息</p></div>'
        ,yes: function (index, layero) {
            $.post(url, function(data) {
                if (data.code == 200) {
                    layer.close(index);
                    window.location.href = '';
                }
            }, 'JSON');
        }
    };
    params     = options ? $.extend(params, options) : params;

    Wind.css('layer');

    Wind.use("layer", function () {
        layer.open(params);
    });

}