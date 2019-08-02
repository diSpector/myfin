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
    $(".table-row").click(function () {
        window.document.location = $(this).data("href");
    });

    // обработка нажатия на кнопку "Загрузить еще" (операции)
    $('.buttons-load-more .btn').click(function (event) {
        // newStopDate = event.target.dataset.date;
        // newStartDate = getNewStartDate(newStopDate);
        var offset = Number($('.btn-success').attr('data-offset'));
        var count = Number($('.btn-success').attr('data-count'));
        // $('.buttons-load-more .btn').remove();


        $.ajax({
            url: '/operation/view',
            type: 'post',
            dataType: 'html',
            // data: {
            //     newStopDate: newStopDate,
            //     newStartDate: newStartDate
            // },

            data: {
                offset: offset,
                count: count
            },

            cache: false,
            beforeSend: function () {
                $('.operations-area').append("<div class = 'loading'><img src='/img/load.gif' /></div>").show();
            },
            success: function (data) {
                $('.loading').hide();
                $('.operations-area').append(data);
                // $('.btn-success').attr('data-date', newStartDate)
                // $('.buttons-load-more').append('<p class = "btn btn-success">Загрузить еще</p>')
                // $('.btn-success').attr('data-offset', offset + count)
                // $('.btn-success').attr('data-count', count)


            },
        });

        // function getNewStartDate(stopDate){
        //     splitDate = stopDate.split('-');
        //     year = splitDate[0];
        //     month = splitDate[1];
        //     date = splitDate[2];
    
        //     prevYear = year;
        //     prevMonth = month - 1;
    
        //     if (prevMonth == 0){
        //         prevMonth = 12;
        //         prevYear = prevYear-1;
        //     } 
    
        //     if (prevMonth < 10){
        //         prevMonth = '0' + prevMonth;
        //     }
    
        //     return newStartDate = [prevYear, prevMonth, date].join('-');
        // }

    });
});