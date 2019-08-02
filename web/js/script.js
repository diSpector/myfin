$(document).ready(function () {

    // при клике на стандартную категорию добавить ее в поле 
    $('.link-default-category').click(function (e) {
        e.preventDefault();
        elementText = $(this).text();
        $('#category-name').val(elementText);
    });


    $('#operation-type').change(function () {
        $categories = $('#operation-category_id');
        $categories.empty(); // удалить предыдущие категории
        operationId = $(this).val();
        operation = {
            id: operationId,
        };
        $.ajax({
            url: '/operation/create',
            type: 'post',
            dataType: 'html',
            data: operation,
            cache: false,
            beforeSend: function(){
                $("#operation_info").html("<div class = 'loading'><img src='/img/load.gif' /></div>").show();
            },
            success: function (data) {
                // newData = JSON.parse(data)
                // console.log(newData)

                $('#operation_info').html(data)
                // рабочий код
                // if (!newData.error) {
                //     $('#selected-operation-type').val(newData.type)
                //     // добавить в выпадающий список полученные категории
                //     $.each(newData.categories, function (key, value) {
                //         $categories.append($("<option></option>")
                //             .attr("value", key).text(value));
                //     });
                //     $('#operation_info').show();
                // } else {
                //     $('#operation_info').hide();
                // }
            },
        });
    });

    // обработка клика на строку в таблице операций
    $(".table-row").click(function() {
        console.log('Click');
        window.document.location = $(this).data("href");
    });
});