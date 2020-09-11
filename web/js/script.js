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
            // url: '/operation/create',
            url: '/operation/create_test',
            type: 'post',
            dataType: 'html',
            data: operation,
            cache: false,
            beforeSend: function () {
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
    $('.operations-area').on('click', '.table-row', function () {
        window.document.location = $(this).data("href");
    });

    // обработка нажатия на кнопку "Загрузить еще" (операции)
    $('.buttons-load-more .btn').click(function (event) {

        var attrs = $(".buttons-load-more input[name = 'attrs']");

        var offset = Number(attrs.attr('data-offset'));
        var total = Number(attrs.attr('data-total'));
        var count = Number(attrs.attr('data-count'));

        if (total <= offset + count) {
            $('.buttons-load-more').hide();
        }

        $.ajax({
            url: '/operation/view',
            type: 'post',
            dataType: 'html',
            data: {
                offset: offset,
            },

            cache: false,
            beforeSend: function () {
                $('.operations-area').append("<div class = 'loading'><img src='/img/load.gif' /></div>").show();
            },
            success: function (data) {
                $('.loading').hide();
                $('.operations-area').append(data);
                attrs.attr('data-offset', offset + count);
            },
        });
    });

    // обработка формы выбора периода операций
    $(document).on("beforeSubmit", "#operation-daterange-form", function () {
        var dates = $(".kv-drp-dropdown .range-value").val();

        $.ajax({
            url: '/operation/index',
            type: 'post',
            dataType: 'html',
            data: {
                dates: dates,
            },

            cache: false,
            beforeSend: function () {
                // $('.dashboard-area').append("<div class = 'loading'><img src='/img/load.gif' /></div>").show();
                $('.operations-area').addClass("block-is-loading");

            },
            success: function (data) {
                // $('.loading').hide();
                $('.operations-area').removeClass("block-is-loading");
                $('.operations-area').html(data);
                $('.buttons-load-more').hide();
            },
        });
        return false; 
    });

    // обработка клика на строку в таблице отчетов (dashboard)
    $('.dashboard-area').on('click', '.table-row', function () {
        window.document.location = $(this).data("href");
    });

    // обработка нажатия на кнопку "Показать" в Dashboard
    $('.dashboard-ajax-buttons .btn').click(function (event) {
        var dates = $(".kv-drp-dropdown .range-value").val();
        var period = $("select[name='period']").val();

        $.ajax({
            url: '/dashboard/view_test',
            type: 'post',
            dataType: 'html',
            data: {
                dates: dates,
                period: period,
            },

            cache: false,
            beforeSend: function () {
                // $('.dashboard-area').append("<div class = 'loading'><img src='/img/load.gif' /></div>").show();
                $('.dashboard-area').addClass("block-is-loading");

            },
            success: function (data) {
                // $('.loading').hide();
                $('.dashboard-area').removeClass("block-is-loading");
                $('.dashboard-area').html(data);
            },
        });
    });
});