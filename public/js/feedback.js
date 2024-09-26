document.addEventListener('DOMContentLoaded', function() {
    let feedbackCount = document.querySelector('.feedbacks').children.length;
    let submitButton = document.getElementById('submit-button');

    if (feedbackCount > 0) {
        submitButton.style.display = 'block';
    }

    document.querySelector('.add-feedback').addEventListener('click', function(e) {
        e.preventDefault();
        let collectionHolder = document.querySelector('.feedbacks');
        let newFeedbackForm = collectionHolder.dataset.prototype;

        newFeedbackForm = newFeedbackForm.replace(/__name__/g, collectionHolder.children.length);
        collectionHolder.insertAdjacentHTML('beforeend', newFeedbackForm);

        submitButton.style.display = 'block';
    });
});