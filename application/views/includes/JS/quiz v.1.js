$(document).ready(function() {
    getQuizData();
});

function getQuizData() {
    var baseDirectory = $('.baseDirectory').val();
    var ajaxUrl = baseDirectory + 'quiz/getData';
    $.post(ajaxUrl)
            .done(function(data) {
                // console.debug(data);
                if (data.length == 0) {
                    alert("No quotes added!");
                    return;
                }
                renderQuiz(data);
            })
            .fail(function() {
                alert("AJAX error!");
            });
}

function renderQuiz(data) {
    console.debug(data);
    var renderingQuoteNumber = 0;
    var rightAnswers = 0;
    var mainQuote = [];
    mainQuote[0] = data[0];
    if ($('.question').val() == '') {
        renderAllQuotes(mainQuote, renderingQuoteNumber, rightAnswers);
    }
    $('.mainQuoteBtn').on('click', function() {
        renderAllQuotes(mainQuote, renderingQuoteNumber, rightAnswers);
    });
    $('.quoteQuizBtn').on('click', function() {
        renderAllQuotes(data, renderingQuoteNumber, rightAnswers);
        // console.log('rightAnswers: ' + rightAnswers);
    });
}

function renderAllQuotes(quizData, renderingQuoteNumber, rightAnswers) {
//    console.log('renderingQuoteNumber: ' + renderingQuoteNumber);
//    console.log('rightAnswers: ' + rightAnswers);
//    console.log(quizData);
    var resultQuote = false;
    renderQuote(quizData[renderingQuoteNumber]);
    if (quizData[renderingQuoteNumber]['possible_answers'].length == 1) {
        $('.yesBtn').show();
        $('.noBtn').show();
    }
    else {
        $('.getResultBtn').show();
    }
    
    $('.getResultBtn').on('click', function() {
        
        resultQuote = checkMultipleResult(quizData[renderingQuoteNumber]);
        if (resultQuote) {
            rightAnswers++;
            quoteResultTrueRender(quizData[renderingQuoteNumber]['right_answer']);
        }
        else {
            quoteResultFalseRender(quizData[renderingQuoteNumber]['right_answer']);
        }
        $('.nextBtn').show();
    });
    $('.yesBtn').on('click', function() {
        // console.log('result checked');
//        console.log(quizData[renderingQuoteNumber]);
        resultQuote = checkResult(quizData[renderingQuoteNumber], true);
        if (resultQuote) {
            rightAnswers++;
            quoteResultTrueRender(quizData[renderingQuoteNumber]['right_answer']);
        }
        else {
            quoteResultFalseRender(quizData[renderingQuoteNumber]['right_answer']);
        }
        $('.nextBtn').show();
    });
    $('.noBtn').on('click', function() {
        resultQuote = checkResult(quizData[renderingQuoteNumber], false);
        if (resultQuote) {
            rightAnswers++;
            quoteResultTrueRender(quizData[renderingQuoteNumber]['right_answer']);
        }
        else {
            quoteResultFalseRender(quizData[renderingQuoteNumber]['right_answer']);
        }
        $('.nextBtn').show();
    });

    $('.nextBtn').on('click', function() {
        renderingQuoteNumber++;
        if (renderingQuoteNumber == quizData.length || renderingQuoteNumber == 30) {
            endQuizRender(rightAnswers, quizData.length);
            return;
        }
        renderAllQuotes(quizData, renderingQuoteNumber, rightAnswers);
    });

}

function renderQuote(quote) {
    // console.log(quote);
    clearQuoteRender();
    $('.question, .description, .answers').show();
    // console.log(quote['possible_answers'].length);
    if (quote['possible_answers'].length > 1) {
        var possibleAnswers = '<table class="display-inline-block text-left">';
        for (i = 0; i < quote['possible_answers'].length; i++) {
            if (i == 0) {
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
        //return true;
    }
    else if (quote['possible_answers'].length === 1) {
        // console.log('lenght 1 execute');
        $('.question').html('<p>' + quote['question'] + '</p>');
        $('.description').html('<p>' + quote['description'] + '</p>');
        $('.answers').html('<p>' + quote['possible_answers'][0] + '</p>');
        // return true;
    }
    else {
        alert('Not enough possible answers!');
        //return false;
    }
}

function checkResult(quoteData, userSelection) {
    console.log(quoteData);
//    console.log(userSelection);
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

function checkMultipleResult(quoteData) {
    var userChoice = $("input[name='quoteAnswers']:checked").val();
//    console.log('radio selected: ' + userChoice);
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
    $('.result-true, .result-false').hide();
    $('.yesBtn, .noBtn, .getResultBtn, .nextBtn').hide();
}

function quoteResultFalseRender(right_answer) {
    clearQuoteRender();
    $('.result-false').html('<p>Wrong answer</p>' +
            '<p>' + right_answer + '</p>');
    $('.result-false').show();
}

function quoteResultTrueRender(right_answer) {
    clearQuoteRender();
    $('.result-true').html('<p>Right answer</p>' +
            '<p>' + right_answer + '</p>');
    $('.result-true').show();
}

function endQuizRender(rightAnswers, totalAnswers) {
    clearQuoteRender();
    if (totalAnswers == 1) {
        $('.result-true').html('<p>Try the Quiz</p>');
        $('.result-true').show();
        return true;
    }
    var successPercent = 0;
    successPercent = rightAnswers / totalAnswers * 100;
    $('.result-true').html('<p>The Quiz finished.</p>' +
            '<p>Right answers: ' + rightAnswers + ' - ' + successPercent + '%</p>' +
            '<p>Total answers: ' + totalAnswers + '</p>');
    $('.result-true').show();
    return true;
}
