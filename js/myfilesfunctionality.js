//handling the copy to clipboard method on copy button click
$('.col5 a').click(function (e) {
    e.preventDefault();
    let urlForClip = $(this)
        .parent()
        .parent()
        .siblings('.row3')
        .find('a')
        .text();

    var temp = $('<input>');
    $('body').append(temp);
    temp.val(urlForClip).select();
    document.execCommand('copy');
    temp.remove();
    // alert('Url copied');
    throwlert(1, 'URL copied');
});

//handling delete button functionlity
$('.col7 a').click(function (e) {
    e.preventDefault();
    let that = this;
    console.log($(this).attr('id'));
    $.ajax({
        url: 'modules/deletemodule.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            delete: 'file',
            fileID: $(this).attr('id'),
        },
        success: function (data) {
            if (data.success == 'true') {
                $(that).parents('.row-plate').fadeOut(500);
            }
        },
    });
});

//sorting row-plates
$('#sortSel').on('change', function () {
    let miniContainer = $('.mini-container');
    if (this.value == 'bydate') {
        $('.row-plate')
            .sort(sort_li) // sort elements
            .appendTo(miniContainer); // append again to the list
        // sort function callback
        function sort_li(a, b) {
            an = Date.parse($(a).find('.col2').text());
            bn = Date.parse($(b).find('.col2').text());

            return bn < an ? 1 : -1;
        }
    } else if (this.value == 'byname') {
        $('.row-plate')
            .sort(sort_li) // sort elements
            .appendTo(miniContainer); // append again to the list
        // sort function callback
        function sort_li(a, b) {
            console.log('in');
            an = Date.parse($(a).find('.col1').text());
            bn = Date.parse($(b).find('.col1').text());

            return bn < an ? 1 : -1;
        }
    }
});

//radio

$('.col3-inner input').change(function () {
    let privacy;
    let oldprivacy = this.value == 0 ? 1 : 0;
    let that = this;
    // console.log(that);

    let fileID = $(this).parents('.row-plate').attr('id');
    console.log(fileID);

    if (this.value == 0) {
        privacy = 0;
    } else {
        privacy = 1;
    }
    $.ajax({
        url: 'modules/updatemodule.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            update: 'filePrivacy',
            filePrivacy: privacy,
            fileID: fileID,
        },
        success: function (data) {
            //alert(data);
            if (data.success == 'false') {
                // console.log(data);
                $(`#${fileID}`)
                    .find(`input:radio[value='${oldprivacy}']`)
                    .prop('checked', true);
                // console.log(
                //     $(`#${fileID}`)
                //         .find(`input:radio[value='${oldprivacy}']`)
                //         .get(0)
                // );
            }
        },
    });
});
