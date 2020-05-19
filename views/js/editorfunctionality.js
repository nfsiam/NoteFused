function setupFuseHeight() {
    let h = $('#bar').height();
    // console.log(h);
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

let previousXpire;

$('#expire')
    .on('focus', function () {
        // Store the current value on focus and on change
        previousXpire = this.value;
    })
    .change(function () {
        let expire = $('#expire', '#noteForm').val();

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
                    throwlert(
                        0,
                        'Login or create an account for advanced features'
                    );
                } else if ('success' in data) {
                } else {
                    throwlert(0, 'Something went wrong!');

                    $(`#expire option[value='${previousXpire}']`).prop(
                        'selected',
                        'selected'
                    );
                }
            },
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
            if ('success' in data) {
                // console.log('note updated');
            } else {
                // console.log('something went wrong');
            }
        },
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
            if ('loginfirst' in data) {
                $(
                    `.privacy-radio-holder input:radio[value='${oldprivacy}']`
                ).prop('checked', true);
                throwlert(
                    0,
                    'Login or create an account for advanced features'
                );
            } else if ('success' in data) {
            } else if ('limitError' in data) {
                throwlert(
                    0,
                    'You have exceeded maximum limit of private notes. Upgrade your plan or delete some old notes'
                );

                $(
                    `.privacy-radio-holder input:radio[value='${oldprivacy}']`
                ).prop('checked', true);
            } else {
                // console.log('Something Went wrong');
                $(
                    `.privacy-radio-holder input:radio[value='${oldprivacy}']`
                ).prop('checked', true);
            }
        },
    });
});
