$(document).ready(function () {
    var ashjshVenues = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/search/venue/%QUERY%',
            wildcard: '%QUERY%'
        }
    });

    $(".venueName").typeahead(null, {
        name: 'name',
        display: 'name',
        source: ashjshVenues,
    });

    $(".venueName").bind('typeahead:select', function (ev, suggestion) {
        $("input[name='venue-slug']").val(suggestion.slug);
    });
});

// Search City
$(document).ready(function () {
    var ashjshCity = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/search/city/%QUERY%',
            wildcard: '%QUERY%'
        }
    });

    $(".cityName").typeahead(null, {
        name: 'name',
        display: 'name',
        source: ashjshCity,
    });

    $(".cityName").bind('typeahead:select', function (ev, suggestion) {
        $("input[name='city-slug']").val(suggestion.slug);
    });
});