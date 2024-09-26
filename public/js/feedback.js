$(document).ready(function() {
    if (typeof $ === 'undefined') {
        console.error("jQuery is not loaded.");
        return;
    }
    let feedbackCount = $('.feedbacks').children().length;
    let submitButton = $('#submit-button');

    if (feedbackCount > 0) {
        submitButton.show();
    }

    $('.add-feedback').on('click', function(e) {
        e.preventDefault();
        let collectionHolder = $('.feedbacks');
        let newFeedbackForm = collectionHolder.data('prototype');

        newFeedbackForm = newFeedbackForm.replace(/__name__/g, collectionHolder.children().length);
        collectionHolder.append(newFeedbackForm);

        submitButton.show();
    });
    submitButton.click(function(e) {
        e.preventDefault();

        let feedbackData = {
            type: $('#feedbackType').val(),
            content: $('#feedbackContent').val()
        };

        $.ajax({
            url: '/api/feedback',
            method: 'POST',
            contentType: 'application/json',
            data: {feedbackData: feedbackData},
            success: function(response) {
                alert('Feedback soumis avec succès');
            },
            error: function(xhr) {
                alert('Erreur lors de la soumission du feedback');
            }
        });
    });

    $.ajax({
        url: '/api/feedback',
        method: 'GET',
        success: function(feedbacks) {
            if (feedbacks && feedbacks.length) {
                feedbacks.forEach(function(feedback) {
                    $('#feedbackList').append('<li>' + feedback.type + ': ' + feedback.content + '</li>');
                });
            } else {
                console.warn('Aucun feedback trouvé.');
            }
        },
        error: function(xhr) {
            console.error('Erreur lors de la récupération des feedbacks', xhr);
            alert('Erreur lors de la récupération des feedbacks');
        }
    });
});
