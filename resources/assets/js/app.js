$(function () {
  $("[data-toggle='tooltip']").tooltip()
})

$('.btn-korona-generate-slug').click(function () {
    var source = $(this).data('source')
    var target = $(this).data('target')
    var url    = $(this).data('url')
    var input  = $("[name='" + source + "']").val()
    $.get(url, { input: input })
        .done(function (data) {
            $("[name='" + target + "']").val(data)
        })
})
