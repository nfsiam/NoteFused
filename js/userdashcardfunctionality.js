let notecount = (pnotecount = filecount = pfilecount = urlcount = 0);

function updateStats() {
    $.ajax({
        url: 'getuserstats.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            ustats: 'ustats',
        },
        success: function (data) {
            // if (data.success == 'true') {
            //     $(that).parents('.row-plate').fadeOut(500);
            // }
            console.log(data);
            let w;

            if (notecount != data.notecount) {
                $('#notecount').text(data.notecount);
                w = (100 / 50) * data.pnotecount;
                if (w > 20) {
                    $('#noteprog').text(`${w}%`);
                }
                $('#noteprog').css('width', `${w}%`);
                notecount = data.notecount;
                console.log('mn');
            }
            if (pnotecount != data.pnotecount) {
                $('#pnotecount').text(data.pnotecount);
                pnotecount = data.pnotecount;
                console.log('mpn');
            }

            if (filecount != data.filecount) {
                $('#filecount').text(data.filecount);
                w = (100 / 50) * data.filecount;
                if (w > 15) {
                    $('#fileprog').text(`${w}%`);
                }
                $('#fileprog').css('width', `${w}%`);
                filecount = data.filecount;
            }
            if (pfilecount != data.pfilecount) {
                $('#pfilecount').text(data.pfilecount);
                pfilecount = data.pfilecount;
                console.log('mpf');
            }

            if (urlcount != data.urlcount) {
                $('#urlcount').text(data.urlcount);

                w = (100 / 50) * data.urlcount;
                if (w > 20) {
                    $('#urlprog').text(`${w}%`);
                }
                $('#urlprog').css('width', `${w}%`);
                urlcount = data.urlcount;
            }
        },
    });
}

updateStats();

setInterval(function () {
    //updateStats();
}, 2000);
