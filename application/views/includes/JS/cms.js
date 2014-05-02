var fileNames = [];
var globalTextArray = [];

$(document).ready(function() {
    getFileList();
    $('.file_select').unbind('change');
    $('.file_select').on('change', function() {
        getJsonText();
    });
//    $('.getFileListBtn').on('click', function() {
//        getFileList();
//    });
    $('.newTextBtn').on('click', function() {
        if (globalTextArray.length == 0) {
            getJsonText();
        }
        else {
            showNewText();
        }
    });
    $(this).unbind('keydown');
    $(this).one('keydown', function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == 13) {
            console.log(keycode);
            showNewText();
        }
    });
});

function getFileList() {
    var ajaxUrl = $('.baseDirectory').val() + 'application/views/includes/JS/json/';
    fileNames=[];
    $.ajax({
        url: ajaxUrl,
        success: function(data) {
            // console.log(data);
            $(data).find("li > a").each(function() {
                // will loop through 
                var fileName = '';
                fileName = $(this).attr("href");
                if (fileName.toLowerCase().indexOf(".json") >= 0) {
                    fileNames.push(fileName);
                }
            });
            renderFileSelect();
//            console.debug(fileNames);
        }
    });
}

function renderFileSelect() {
    var selectStr = '';
    if (fileNames.length == 0) {
        $('.file-select').html('<p class="x-large">No JSON files found!</p>');
    }
    var names = 0;
    selectStr += '<option value="' + fileNames[names] + '">' + fileNames[names] + '</option>';
    if (fileNames.length > 1) {
        for (names = 1; names < fileNames.length; names++) {
            selectStr += '<option value="' + fileNames[names] + '">' + fileNames[names] + '</option>';
        }
    }
    $('.file_select').html('');
    $('.file_select').html(selectStr);
}

function getJsonText() {
    var fileName = '';
    fileName = $('.file_select').val();
    console.log('fileName: ' + fileName);
    var ajaxUrl = $('.baseDirectory').val() + 'application/views/includes/JS/json/' + fileName;
    // console.log(ajaxUrl);
    $.getJSON(ajaxUrl, function() {
    }).done(function(data) {
        console.debug(data);
        globalTextArray = data;
        showNewText();
    });
}

function showNewText() {
    var textArray = [];
    /*
     textArray = ["12564", "325667", "3237574", "2344", "257543", "4266754", "245663", "23564357", "426543", "243563", "76886", "23862", "544823", "346476",
     "according", "Malaysian", "Prime", "Minister", "events", "time", "those", "words", "were", "spoken", "someone", "had", "likely", "already", "taken",
     "steps", "alter", "flight", "path", "intentionally", "346436", "5365435", "4577543", "34077", "324066", "23824", "722477", "investigators", "ruling",
     "hijacking", "other", "actors", "But", "they", "have", "searched", "homes", "pilot"];
     /**/
    textArray = globalTextArray;
    var text = $('.text').html();
//    console.log('textArray: ');
//    console.debug(textArray);
//    console.log('text: '+text);

    var textKey = -1;
    if (text == '') {
        textKey = 0;
        printText(textArray[textKey]);
    }
    else if (text === textArray[textArray.length - 1]) {
        textKey = 0;
        printText(textArray[textKey]);
    }
    else {
        textKey = jQuery.inArray(text, textArray);
        textKey++;
        printText(textArray[textKey]);
    }
    console.log('textKey: ' + textKey);
    console.log('text: ' + textArray[textKey]);
}

function printText(text) {
    $('.text').html('');
    $('.text').html(text);
    $('.text').fadeIn(50).delay(130).slideUp(50);
}