function openForm() {
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('loginForm').style.display = 'block';
}

function closeForm() {
    document.getElementById('unamebox').value = '';
    document.getElementById('passbox').value = '';
    document.getElementById('errProfile').innerHTML = '';
    document.getElementById('errUname').innerHTML = '';
    document.getElementById('errPass').innerHTML = '';
    $('.input-sec input').removeClass('focus');
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('loginForm').style.display = 'none';
}

function showChildButtons(element) {
    if (element.id == 'p1') {
        $('#drp2').slideUp(200);
        $('#drp1').slideDown();
    } else if (element.id == 'p2') {
        $('#drp1').slideUp(200);
        $('#drp2').slideDown();
    }
}

$('#p1').click(function() {
    showChildButtons(this);
});
$('#p2').click(function() {
    showChildButtons(this);
});

$('#close').click(function() {
    closeForm();
});
$('#loginButton').click(function() {
    openForm();
});
