let notecount = (pnotecount = filecount = pfilecount = urlcount = 0);
let usedSpace = 0;
let planInUDC;
let notelimit = (filelimit = urllimit = 0);
function setLimit() {
    let planInText;
    switch (planInUDC) {
        case 0:
            notelimit = 50;
            filelimit = 10240;
            urllimit = 50;
            planInText = 'basic';
            break;
        case 1:
            notelimit = 200;
            filelimit = 20480;
            urllimit = 200;
            planInText = 'pro';

            break;
        case 2:
            notelimit = 5000;
            filelimit = 102400;
            urllimit = 5000;
            planInText = 'ultra';

            break;

        default:
            break;
    }
    if ($('.plan').text() != planInText) {
        $('.plan').text(planInText);
    }
}
function setLimitInSpans() {
    console.log(typeof planInUDC);
    $('.note-limit').text(notelimit);
    $('.file-limit').text(filelimit / 1024 + 'MB');
    $('.url-limit').text(urllimit);
}

function updateStats() {
    $.ajax({
        url: 'userdashcardhandler.php',
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
            if (planInUDC != data.currentplan) {
                planInUDC = data.currentplan;
                setLimit();
                setLimitInSpans();
            }
            let w;

            if (notecount != data.notecount) {
                $('#notecount').text(data.notecount);
                w = (100 / notelimit) * data.pnotecount;
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
                w = (100 / filelimit) * data.filecount;
                if (w > 15) {
                    $('#fileprog').text(`${w}%`);
                }
                $('#fileprog').css('width', `${w}%`);
                filecount = data.filecount;
            }
            if (pfilecount != data.pfilecount) {
                $('#pfilecount').text(data.pfilecount);
                pfilecount = data.pfilecount;
            }
            if (usedSpace != data.totalfilesize) {
                usedSpace = data.totalfilesize;
                let usedSpaceMB = usedSpace / 1024;
                usedSpaceMB =
                    Math.round((usedSpaceMB + Number.EPSILON) * 100) / 100;
                $('#usedspace').text(usedSpaceMB);

                w = (100 / filelimit) * usedSpace;
                w = Math.round((w + Number.EPSILON) * 100) / 100;
                if (w > 15) {
                    $('#fileprog').text(`${w}%`);
                } else {
                    $('#fileprog').text(``);
                }
                $('#fileprog').css('width', `${w}%`);
            }

            if (urlcount != data.urlcount) {
                $('#urlcount').text(data.urlcount);

                w = (100 / urllimit) * data.urlcount;
                if (w > 20) {
                    $('#urlprog').text(`${w}%`);
                }
                $('#urlprog').css('width', `${w}%`);
                urlcount = data.urlcount;
            }
        },
    });

    // $.ajax({
    //     url: 'settingshandler.php',
    //     method: 'POST',
    //     dataType: 'JSON',
    //     data: {
    //         fetchPersonal: 'fetchInfo',
    //     },
    //     success: function (data) {
    //         // alert(data);
    //         if ('info' in data) {
    //             if ($('.name-plate').text() != data.info.name) {
    //                 $('.name-plate').text(data.info.name);
    //             }
    //             planInUDC = data.info.plan;
    //             setLimit();
    //             setLimitInSpans();
    //             $.ajax({
    //                 url: 'userdashcardhandler.php',
    //                 method: 'POST',
    //                 dataType: 'JSON',
    //                 data: {
    //                     ustats: 'ustats',
    //                 },
    //                 success: function (data) {
    //                     // if (data.success == 'true') {
    //                     //     $(that).parents('.row-plate').fadeOut(500);
    //                     // }
    //                     console.log(data);
    //                     planInUDC = data.currentplan;
    //                     setLimit();
    //                     setLimitInSpans();
    //                     let w;

    //                     if (notecount != data.notecount) {
    //                         $('#notecount').text(data.notecount);
    //                         w = (100 / notelimit) * data.pnotecount;
    //                         if (w > 20) {
    //                             $('#noteprog').text(`${w}%`);
    //                         }
    //                         $('#noteprog').css('width', `${w}%`);
    //                         notecount = data.notecount;
    //                         console.log('mn');
    //                     }
    //                     if (pnotecount != data.pnotecount) {
    //                         $('#pnotecount').text(data.pnotecount);
    //                         pnotecount = data.pnotecount;
    //                         console.log('mpn');
    //                     }

    //                     if (filecount != data.filecount) {
    //                         $('#filecount').text(data.filecount);
    //                         w = (100 / filelimit) * data.filecount;
    //                         if (w > 15) {
    //                             $('#fileprog').text(`${w}%`);
    //                         }
    //                         $('#fileprog').css('width', `${w}%`);
    //                         filecount = data.filecount;
    //                     }
    //                     if (pfilecount != data.pfilecount) {
    //                         $('#pfilecount').text(data.pfilecount);
    //                         pfilecount = data.pfilecount;
    //                     }
    //                     if (usedSpace != data.totalfilesize) {
    //                         usedSpace = data.totalfilesize;
    //                         let usedSpaceMB = usedSpace / 1024;
    //                         usedSpaceMB =
    //                             Math.round(
    //                                 (usedSpaceMB + Number.EPSILON) * 100
    //                             ) / 100;
    //                         $('#usedspace').text(usedSpaceMB);

    //                         w = (100 / filelimit) * usedSpace;
    //                         w = Math.round((w + Number.EPSILON) * 100) / 100;
    //                         if (w > 15) {
    //                             $('#fileprog').text(`${w}%`);
    //                         } else {
    //                             $('#fileprog').text(``);
    //                         }
    //                         $('#fileprog').css('width', `${w}%`);
    //                     }

    //                     if (urlcount != data.urlcount) {
    //                         $('#urlcount').text(data.urlcount);

    //                         w = (100 / urllimit) * data.urlcount;
    //                         if (w > 20) {
    //                             $('#urlprog').text(`${w}%`);
    //                         }
    //                         $('#urlprog').css('width', `${w}%`);
    //                         urlcount = data.urlcount;
    //                     }
    //                 },
    //             });
    //         }
    //     },
    // });
}

updateStats();

setInterval(function () {
    updateStats();
}, 2000);
