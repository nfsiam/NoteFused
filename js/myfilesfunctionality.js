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
    alert('Url copied');
});

//handling delete button functionlity
$('.col7 a').click(function (e) {
    e.preventDefault();
    let that = this;
    console.log($(this).attr('id'));
    $.ajax({
        url: 'deleteop.php',
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
