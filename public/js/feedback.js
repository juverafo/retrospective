$(document).ready(function() {
    let feedbackCount = $('.feedbacks').children().length;
    let $submitButton = $('#submit-button');

    if (feedbackCount > 0) {
        $submitButton.show();
    }

    $('.add-feedback').on('click', function(e) {
        e.preventDefault();
        let $collectionHolder = $('.feedbacks');
        let newFeedbackForm = $collectionHolder.data('prototype');

        newFeedbackForm = newFeedbackForm.replace(/__name__/g, $collectionHolder.children().length);
        $collectionHolder.append(newFeedbackForm);

        $submitButton.show();
    });
});
