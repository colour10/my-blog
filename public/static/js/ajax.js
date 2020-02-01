/**
 * 获得form表单的formdata值
 * @param formname
 * @returns {FormData}
 */
function getFormData(formname) {
    var form = document.getElementsByName(formname)[0];
    return new FormData(form);
}

// 封装的ajax-post方法
// 几乎每个页面都要用，所以进行了封装
// type: 数据请求的方式(get或者post)
// url：数据接收的地址
// fd：当前表单的FormData对象
// successUrl：页面执行成功后跳转的url地址，如果不填写则默认是当前页面的地址
// second：设置几秒后页面跳转，默认是3秒
function ajax(type, url, fd, successUrl = window.location.href, second = 3) {
    // 处理逻辑
    $.ajax({
        type: type,
        url: url,
        data: fd,
        dataType: 'json',
        timeout: 99999,
        // 下面两个和delete方法冲突，但是post还是需要的
        // processData只对post有效
        processData: false,
        contentType: false,
        beforeSend: function () {
            index = layer.load(1, {
                shade: [0.5, '#fff'] //0.1透明度的白色背景
            });
        },
        complete: function () {
            layer.close(index);
        },
        success: function (data) {
            // 判断逻辑
            if (data.code === 0) {
                layer.msg(data.msg, {icon: 1});
                // 3000毫秒后跳转
                setTimeout("window.location.href = '" + successUrl + "'", second * 1000);
            } else {
                // 返回错误
                layer.msg(data.msg, {icon: 2});
                // 3000毫秒后跳转
                // setTimeout("document.location.reload()", second*1000);
            }
        },
        error: function (data) {
            // 判断逻辑
            if (data.status === 422) {
                var jsonObj = JSON.parse(data.responseText);
                var errors = jsonObj.errors;
                for (var item in errors) {
                    for (var i = 0, len = errors[item].length; i < len; i++) {
                        layer.msg(errors[item][i], {icon: 2});
                        return;
                    }
                }
            } else {
                // 提示
                layer.msg('程序内部错误，请联系管理员！', {icon: 2});
                return;
            }
        },
    });
    // 返回假，禁止自动跳转
    return false;
}

// 封装的ajax-default方法
// 几乎每个页面都要用，所以进行了封装
// type: 数据请求的方式(使用post)
// url：数据接收的地址
// fd：当前表单的FormData对象
// successUrl：页面执行成功后跳转的url地址，如果不填写则默认是当前页面的地址
// second：设置几秒后页面跳转，默认是3秒
function defaultajax(type, url, fd, successUrl = window.location.href, second = 3) {
    // 处理逻辑
    $.ajax({
        type: type,
        url: url,
        data: fd,
        dataType: 'json',
        timeout: 99999,
        beforeSend: function () {
            index = layer.load(1, {
                shade: [0.5, '#fff'] //0.1透明度的白色背景
            });
        },
        complete: function () {
            layer.close(index);
        },
        success: function (data) {
            // 判断逻辑
            if (data.code === 0) {
                layer.msg(data.msg, {icon: 1});
                // 3000毫秒后跳转
                setTimeout("window.location.href = '" + successUrl + "'", second * 1000);
            } else {
                // 返回错误
                layer.msg(data.msg, {icon: 2});
                // 3000毫秒后跳转
                // setTimeout("document.location.reload()", second*1000);
            }
        },
        error: function (data) {
            // 打印返回值
            console.log(data);
            // 判断逻辑
            if (data.status === 422) {
                var jsonObj = JSON.parse(data.responseText);
                var errors = jsonObj.errors;
                for (var item in errors) {
                    for (var i = 0, len = errors[item].length; i < len; i++) {
                        layer.msg(errors[item][i], {icon: 2});
                        return;
                    }
                }
            } else {
                // 提示
                layer.msg('程序内部错误，请联系管理员！', {icon: 2});
                return;
            }
        },
    });
    // 返回假，禁止自动跳转
    return false;
}

// 采用正则表达式获取地址栏参数，并且解决了当参数中有中文的时候， 就出现乱码的问题
/**
 * @return {string}
 */
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]);
    return null;
}
