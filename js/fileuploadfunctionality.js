let formData,
    fileList,
    totalFiles = 0,
    totalSize = 0;
let fileInfo = [];
let info = [];
let fileInfoAsElem = '';
$('#choose').click(function() {
    $(this)[0].value = null;
});

$('#choose').change(function() {
    fileInfoAsElem = '';
    $('.row4').html(fileInfoAsElem);
    formData = new FormData();
    fileList = $(this)[0].files;
    totalFiles = fileList.length;

    for (const file of fileList) {
        totalSize = totalSize + file.size;
        formData.append('file[]', file);
        fileInfo.push(file.name);
        fileInfoAsElem += `<div>${file.name}</div>`;
    }
    totalSize = Math.ceil(totalSize / 1024);
    console.log(totalSize);
    console.log(fileInfo);
    if (totalSize > 1024) {
        alert('You can not upload file more than 1MB');
        formData = null;
        fileInfo = [];
        fileInfoAsElem = '';
        return;
    }

    //let fileInfoAsText = fileInfo.join(', ');
    $('.row4').html(fileInfoAsElem);
    return;

    console.log(formData);
});

$('#uploadButton').click(function() {
    if (formData == null || formData == undefined) {
        alert('Choose Files First');
        return;
    } else {
        $('#prog').show();
        if (totalFiles > 0 && totalSize <= 1024) {
            $.ajax({
                // Your server script to process the upload
                url: 'upload.php',
                type: 'POST',

                // Form data
                data: formData,

                // Tell jQuery not to process data or worry about content-type
                // You *must* include these options!
                cache: false,
                contentType: false,
                processData: false,
                /* dataType: 'JSON', */

                // Custom XMLHttpRequest
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        // For handling the progress of the upload
                        myXhr.upload.addEventListener(
                            'progress',
                            function(e) {
                                if (e.lengthComputable) {
                                    $('progress').attr({
                                        value: e.loaded,
                                        max: e.total
                                    });
                                }
                            },
                            false
                        );
                    }
                    return myXhr;
                },
                success: function(data) {
                    $('.res').html(data);
                    $('#prog').fadeOut();

                    formData = null;
                    fileInfo = [];
                    fileInfoAsElem = '';
                    $('.row4').html(fileInfoAsElem);
                }
            });
        } else {
            alert('You can not upload file more than 1MB');
            formData = null;
            fileInfo = [];
            fileInfoAsElem = '';
            $('.res').html(fileInfoAsElem);
            return;
        }
    }
});
