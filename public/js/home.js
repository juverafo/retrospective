import {Tabulator} from "tabulator-tables";

$(document).ready(function() {
    const feedbackData = JSON.parse($('#feedback-data').text());

    if (typeof Tabulator !== 'undefined') {
        const table = new Tabulator("#feedback-table", {
            data: feedbackData,
            layout: "fitColumns",
            columns: [
                {
                    title: "ID",
                    field: "id",
                    width: 50
                },
                {
                    title: "Type",
                    field: "type",
                    headerFilter: 'list',
                    headerFilterPlaceholder: "Filtrer par type",
                    headerFilterParams: {
                        valuesLookup: true,
                        clearable: true,
                    },
                },
                {
                    title: "Feedback",
                    field: "content",
                    headerFilter: 'input',
                    headerFilterPlaceholder: "Filtrer par feedback",
                },
                {
                    title: "Date",
                    field: "createdAt",
                    headerFilter: 'input',
                    headerFilterPlaceholder: "Filtrer par date"
                }
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
        console.error("Tabulator is not defined.");
    }
});