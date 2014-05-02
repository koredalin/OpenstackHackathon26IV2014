$(document).ready(function() {
    getQuizData();
});

var globalQuizArray = [];

function getQuizData() {
    var baseDirectory = $('.baseDirectory').val();
    if ($('.elementsToRender').val() === 'main') {
        var ajaxUrl = baseDirectory + 'quiz/getData';
        $('.mainQuoteBtn').css('background', '#fdd');
    }
    else {
        var ajaxUrl = baseDirectory + 'quiz/getAllData';
        $('.quoteQuizBtn').css('background', '#fdd');
    }
    $.post(ajaxUrl)
            .done(function(data) {
                // console.debug(data);
                if (data.length === 0) {
                    alert("No quotes added!");
                    return;
                }
                globalQuizArray = data;
                renderAllQuotes(0, 0);
            })
            .fail(function() {
                alert("AJAX error!");
            });
}

function renderAllQuotes(renderingQuoteNumber, rightAnswers) {
//    console.log('renderingQuoteNumber: ' + renderingQuoteNumber);
//    console.log('rightAnswers: ' + rightAnswers);
    var quizData = globalQuizArray;
    console.log(quizData);
    var resultQuote = false;
    renderQuote(renderingQuoteNumber);
    if (quizData[renderingQuoteNumber]['possible_answers'].length === 1) {
        $('.yesBtn').show();
        $('.noBtn').show();
    }
    else {
        $('.getResultBtn').show();
    }

    $('.btn').unbind('click');
    $('.getResultBtn').on('click', function() {
        resultQuote = checkMultipleResult(renderingQuoteNumber);
        resultQuote ? rightAnswers++ : rightAnswers;
        quoteResultRender(quizData[renderingQuoteNumber]['right_answer'], !!resultQuote);
        $('.nextBtn').show();
    });
    $('.yesBtn').on('click', function() {
        resultQuote = checkResult(renderingQuoteNumber, true);
        resultQuote ? rightAnswers++ : rightAnswers;
        quoteResultRender(quizData[renderingQuoteNumber]['right_answer'], !!resultQuote);
        $('.nextBtn').show();
    });
    $('.noBtn').on('click', function() {
        resultQuote = checkResult(renderingQuoteNumber, false);
        resultQuote ? rightAnswers++ : rightAnswers;
        quoteResultRender(quizData[renderingQuoteNumber]['right_answer'], !!resultQuote);
        $('.nextBtn').show();
    });

    $('.nextBtn').on('click', function() {
        renderingQuoteNumber++;
        if (renderingQuoteNumber === quizData.length || renderingQuoteNumber === 30) {
            endQuizRender(rightAnswers, quizData.length);
            return;
        }
        renderAllQuotes(renderingQuoteNumber, rightAnswers);
    });

}

function renderQuote(renderingQuoteNumber) {
    var quote = globalQuizArray[renderingQuoteNumber];
//    console.log('renderingQuoteNumber: ' + renderingQuoteNumber);
//    console.log(quote);
    clearQuoteRender();
    $('.question, .description, .answers').show();
    // console.log(quote['possible_answers'].length);
    if (quote['possible_answers'].length > 1) {
        var possibleAnswers = '<table class="display-inline-block text-left">';
        for (i = 0; i < quote['possible_answers'].length; i++) {
            if (i === 0) {
                possibleAnswers += '<tr><td><input type="radio" name="quoteAnswers" value="' + quote['possible_answers'][i] + '" checked></td>' +
                        '<td>' + quote['possible_answers'][i] + '</td></tr>';
            }
            else {
                possibleAnswers += '<tr><td><input type="radio" name="quoteAnswers" value="' + quote['possible_answers'][i] + '"></td>' +
                        '<td>' + quote['possible_answers'][i] + '</td></tr>';
            }
        }
        possibleAnswers += '</table>';
        $('.question').html('<p>' + quote['question'] + '</p>');
        $('.description').html('<p>' + quote['description'] + '</p>');
        $('.answers').html(possibleAnswers);
        return true;
    }
    else if (quote['possible_answers'].length === 1) {
        // console.log('lenght 1 execute');
        $('.question').html('<p>' + quote['question'] + '</p>');
        $('.description').html('<p>' + quote['description'] + '</p>');
        $('.answers').html('<p>' + quote['possible_answers'][0] + '</p>');
        return true;
    }
    else {
        alert('Not enough possible answers!');
        return false;
    }
}

function checkResult(renderingQuoteNumber, userSelection) {
    var quoteData = globalQuizArray[renderingQuoteNumber];
//    console.log(quoteData);
    console.log('quoteData[right_answer]: '+quoteData['right_answer']);
    var answer = false;
    if (quoteData['possible_answers'][0] === quoteData['right_answer']) {
        answer = true;
    }
    if (userSelection === answer) {
        return true;
    }
    else {
        return false;
    }
}

function checkMultipleResult(renderingQuoteNumber) {
    var quoteData = globalQuizArray[renderingQuoteNumber];
    var userChoice = $('input[name="quoteAnswers"]:checked').val();
    console.log('radio selected: ' + userChoice);
    console.log('quoteData[right_answer]: '+quoteData['right_answer']);
    if (userChoice === quoteData['right_answer']) {
        return true;
    }
    else {
        return false;
    }
}

function clearQuoteRender() {
    $('.question').html('');
    $('.description').html('');
    $('.answers').html('');
    $('.question, .description, .answers').hide();
    $('.result-true').html('');
    $('.result-false').html('');
    $('.result-final').html('');
    $('.result-true, .result-false, .result-final').hide();
    $('.yesBtn, .noBtn, .getResultBtn, .nextBtn').hide();
}

function quoteResultRender(right_answer, resultQuote) {
    clearQuoteRender();
    console.log('quoteResultRender()');
    if (resultQuote) {
        $('.result-true').html('<p>Right answer</p>' +
                '<p>' + right_answer + '</p>');
        $('.result-true').show();
    }
    else {
        $('.result-false').html('<p>Wrong answer</p>' +
                '<p>' + right_answer + '</p>');
        $('.result-false').show();
    }
    return true;
}

function endQuizRender(rightAnswers, totalAnswers) {
    clearQuoteRender();
    if (totalAnswers === 1) {
        $('.result-final').html('<p>Try the Quiz</p>');
        $('.result-final').show();
        return true;
    }
    var successPercent = 0;
    successPercent = rightAnswers / totalAnswers * 100;
    $('.result-final').html('<p>The Quiz finished.</p>' +
            '<p>Right answers: ' + rightAnswers + ' - ' + successPercent + '%</p>' +
            '<p>Total answers: ' + totalAnswers + '</p>');
    $('.result-final').show();
    return true;
}