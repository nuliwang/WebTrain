

$(".J_delete").click(function () {
    if (confirm("确认要删除该条数据？")) {
        var url = $(this).attr("data-url");
        var id = $(this).attr("data");
        $.ajax({
            dataType: "json",
            type: "POST",
            // async: false,
            url: url,
            data: { id: id, time: new Date().getTime() },
            success: function(data) {
                window.location.href = window.location.href;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("ajax error");
            },
            complete: function(XMLHttpRequest, textStatus) {
                this; // 调用本次AJAX请求时传递的options参数
            }
        });
    }
});










