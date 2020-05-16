function setupFuseHeight() {
    let h = $('#bar').height();
    console.log(h);
    document.documentElement.style.setProperty('--edsetH', `${h}px`);
}
$(window).ready(function () {
    setupFuseHeight();
    $('#editSettings').slideDown(700, function () {
        setupFuseHeight();
    });
    $('#editSettings').slideUp(700, function () {
        setupFuseHeight();
    });
    $('#optionToggler').slideDown(700, function () {
        setupFuseHeight();
    });
    $('#optionToggler').slideUp(700, function () {
        setupFuseHeight();
    });
});
$(window).resize(function () {
    setupFuseHeight();
});

$('#expand').on('click', function () {
    // window.location.href = 'http://192.168.137.1/webtech/notefused/myfiles.php';
    if ($('#editSettings').is(':visible')) {
        $('#editSettings').slideUp(function () {
            setupFuseHeight();
        });
    } else {
        $('#editSettings').slideDown(function () {
            setupFuseHeight();
        });
    }
});

// function onNoteChange() {
//     let priv =
//         $('input[name=privacy]:checked', '#noteForm').val() == 'public' ? 0 : 1;
//     let author = $('#author', '#noteForm').val();
//     let expire = $('#expire', '#noteForm').val();
//     let padtext = $('#pad').val();

//     let noteID = noteid;

//     //console.log(padtext);

//     $.ajax({
//         url: 'modules/updatemodule.php',
//         method: 'POST',
//         dataType: 'JSON',

//         data: {
//             update: 'note',
//             noteText: padtext,
//             notePrivacy: priv,
//             xpire: expire,
//             noteID: noteID,
//         },
//         success: function (response) {
//             if (response.success == 'true') {
//                 console.log('note updated');
//             }
//         },
//     });
// }

// $('#noteForm input').on('change', function () {
//     onNoteChange();
// });

// $('#expire').on('change', function () {
//     let expire = $('#expire', '#noteForm').val();

//     $.ajax({
//         url: 'handlers/editorhandler.php',
//         method: 'POST',
//         dataType: 'JSON',
//         data: {
//             updateNoteExpiration: expire,
//             noteID: noteid,
//         },
//         success: function (data) {
//             if ('success' in data) {
//                 console.log('Expire dtae updated');
//             } else {
//                 alert();
//             }
//         },
//     });
// });

let previousXpire;

$('#expire')
    .on('focus', function () {
        // Store the current value on focus and on change
        previousXpire = this.value;
        console.log(previousXpire);
    })
    .change(function () {
        let expire = $('#expire', '#noteForm').val();
        console.log(expire);

        $.ajax({
            url: 'controllers/editorhandler.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
                updateNoteExpiration: expire,
                noteID: noteid,
            },
            success: function (data) {
                if ('loginfirst' in data) {
                    $(`#expire option[value='${previousXpire}']`).prop(
                        'selected',
                        'selected'
                    );
                    // alert('Login or create an account for advanced features');
                    throwlert(
                        0,
                        'Login or create an account for advanced features'
                    );
                } else if ('success' in data) {
                    console.log('Expire dtae updated');
                } else {
                    console.log('ddd ' + previousXpire);
                    // alert('Something went wrong');
                    throwlert(0, 'Something went wrong!');

                    $(`#expire option[value='${previousXpire}']`).prop(
                        'selected',
                        'selected'
                    );
                }
            },
            // fail: function (xhr, textStatus, errorThrown) {
            //     console.log(textStatus);
            //     console.log(errorThrown);
            //     alert('Something went wrong');
            //     $(`#expire option[value='${previousXpire}']`).attr(
            //         'selected',
            //         'selected'
            //     );
            // },
        });
    });

$('#pad').bind('change keyup input', function () {
    let expire = $('#expire', '#noteForm').val();
    let padtext = $('#pad').val();
    $.ajax({
        url: 'controllers/editorhandler.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            updateNoteText: padtext,
            noteID: noteid,
            xpire: expire,
        },
        success: function (data) {
            // alert(data);
            if ('success' in data) {
                console.log('note updated');
            } else {
                console.log('something went wrong');
            }
        },
        // fail: function (xhr, textStatus, errorThrown) {
        //     console.log(textStatus);
        //     console.log(errorThrown);
        //     alert('Something went wrong');
        //     $(`#expire option[value='${previousXpire}']`).attr(
        //         'selected',
        //         'selected'
        //     );
        // },
    });
});

$('.privacy-radio-holder input').change(function () {
    let privacy;
    let oldprivacy;
    let that = this;

    let expire = $('#expire', '#noteForm').val();

    if (this.value == 'public') {
        privacy = 0;
        oldprivacy = 'private';
    } else {
        privacy = 1;
        oldprivacy = 'public';
    }
    console.log(privacy);
    $.ajax({
        url: 'controllers/editorhandler.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            updateNotePrivacy: privacy,
            noteID: noteid,
            xpire: expire,
        },
        success: function (data) {
            // alert(data);
            if ('loginfirst' in data) {
                $(
                    `.privacy-radio-holder input:radio[value='${oldprivacy}']`
                ).prop('checked', true);
                // alert('Login or create an account for advanced features');
                throwlert(
                    0,
                    'Login or create an account for advanced features'
                );
            } else if ('success' in data) {
                console.log('privacy updated');
            } else if ('limitError' in data) {
                // alert(
                //     'You have exceeded maximum limit of private notes. Upgrade your plan or delete some old notes'
                // );
                throwlert(
                    0,
                    'You have exceeded maximum limit of private notes. Upgrade your plan or delete some old notes'
                );

                $(
                    `.privacy-radio-holder input:radio[value='${oldprivacy}']`
                ).prop('checked', true);
            } else {
                console.log('Something Went wrong');
                $(
                    `.privacy-radio-holder input:radio[value='${oldprivacy}']`
                ).prop('checked', true);
            }
        },
    });
});
