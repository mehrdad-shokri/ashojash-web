$(document).ready(function () {
    var ashjshUsers = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/owner/user/search/%QUERY%',
            wildcard: '%QUERY%'
        }
    });

    $(".userPlaceholder").typeahead(null, {
        name: 'email',
        display: 'email',
        source: ashjshUsers,
    });

    /*  $(".userPlaceholder").bind('typeahead:select', function (ev, suggestion) {
     console.log(suggestion.username);
     $("input.userPlaceholder").val(suggestion.username);
     });*/
});