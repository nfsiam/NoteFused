function setupFuseHeight() {
    let h = $('#bar').height();
    console.log(h);
    document.documentElement.style.setProperty('--edsetH', `${h}px`);
}
$(window).ready(function() {
    setupFuseHeight();
    $('#editSettings').slideDown(700, function() {
        setupFuseHeight();
    });
    $('#editSettings').slideUp(700, function() {
        setupFuseHeight();
    });
    $('#optionToggler').slideDown(700, function() {
        setupFuseHeight();
    });
    $('#optionToggler').slideUp(700, function() {
        setupFuseHeight();
    });
});
$(window).resize(function() {
    setupFuseHeight();
});

$('#expand').on('click', function() {
    if ($('#editSettings').is(':visible')) {
        $('#editSettings').slideUp(function() {
            setupFuseHeight();
        });
    } else {
        $('#editSettings').slideDown(function() {
            setupFuseHeight();
        });
    }
});

function onNoteChange() {
    let priv =
        $('input[name=privacy]:checked', '#noteForm').val() == 'public' ? 0 : 1;
    let author = $('#author', '#noteForm').val();
    let expire = $('#expire', '#noteForm').val();
    let padtext = $('#pad').val();

    let noteID = noteid;

    //console.log(padtext);

    $.ajax({
        url: 'updatenote.php',
        method: 'POST',
        data: {
            submit: 'submit',
            noteText: padtext,
            noteOwner: author,
            notePrivacy: priv,
            xpire: expire,
            noteID: noteID
        },
        success: function(response) {
            console.log('3');
        }
    });
}

$('#noteForm input').on('change', function() {
    $('#author', '#noteForm').val(loggedUser == '' ? 'guest' : `${loggedUser}`);
    onNoteChange();
});

$('#expire').on('change', function() {
    $('#author', '#noteForm').val(loggedUser == '' ? 'guest' : `${loggedUser}`);
    onNoteChange();
});

$('#pad').bind('change keyup input', function() {
    console.log(loggedUser);

    $('#author', '#noteForm').val(loggedUser == '' ? 'guest' : `${loggedUser}`);
    onNoteChange();
});
