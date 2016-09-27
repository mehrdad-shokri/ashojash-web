function startEmailSuggestion() {
    jQuery(document).ready(function ($) {
        var engine = new Bloodhound({
            remote: {
                url: '/owner/user/search/email/%QUERY',
                wildcard: '%QUERY',
            },

            // '...' = displayKey: '...'
            datumTokenizer: Bloodhound.tokenizers.whitespace('email'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        engine.initialize();

        $("#user-email").typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        }, {
            source: engine.ttAdapter(),
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'email',
            // the key from the array we want to display (name,id,email,etc...)
            displayKey: 'email',
            templates: {
                empty: [
                    '<div class="empty-message">unable to find any</div>'
                ]
            }
        });
    });
}
$(".assignVenueOwner").on("click", function (e) {
    e.stopPropagation();
    var venueId = $(this).data("venue-id");
    $("#assignVenueId").val(venueId);
    startEmailSuggestion();
    $("#assignOwnerModal").modal("toggle");
    return false;
});
$(".assignVenueStatus").on("click", function (e) {
    e.stopPropagation();
    var venueId = $(this).data("venue-id");
    var status = $(this).data("venue-status");
    $("#statusVenueId").val(venueId);
    $("#changeVenueStatus").modal("toggle");
    var select = $("#venueStatus");
    var option = select.find("option[value=" + status + "]").prop('selected', true);
    return false;
});
