$('#expandOptions').on('click', function(e) {
    e.preventDefault();

    if (!$('#optionToggler').is(':visible')) {
        $('#optionToggler').slideDown();
    } else {
        $('#optionToggler').slideUp();
    }
});
$('#expandOptions').on('focusout', function(e) {
    e.preventDefault();

    if ($('#optionToggler').is(':visible')) {
        $('#optionToggler').slideUp();
    }
});

$('#urlBox,#resultUrlBox', '.mini-container').focus(function() {
    $('.alter-options').fadeOut();
});
$('#urlBox,#resultUrlBox', '.mini-container').focusout(function() {
    $('.alter-options').fadeIn();
});
