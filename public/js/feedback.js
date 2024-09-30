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

    $.ajax({
        url: '/api/feedback',
        method: 'GET',
        success: function(feedbacks) {
            if (typeof Tabulator !== 'undefined') {
                const table = new Tabulator("#feedback-table", {
                    data: feedbacks,
                    layout: "fitColumns",
                    columns: [
                        {title: "ID", field: "id", width: 50},
                        {title: "Type", field: "type", headerFilter: 'list', headerFilterParams: {valuesLookup: true, clearable: true}},
                        {title: "Feedback", field: "content", headerFilter: 'input'},
                        {title: "Date", field: "createdAt", headerFilter: 'input'}
                    ],
                    rowFormatter: function(row) {
                        const data = row.getData();
                        if (data.type === 'positif') {
                            row.getElement().style.backgroundColor = 'lightgreen';
                        } else if (data.type === 'negatif') {
                            row.getElement().style.backgroundColor = 'lightcoral';
                        }
                    }
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
