$(document).ready(function(){var e=new Bloodhound({datumTokenizer:Bloodhound.tokenizers.obj.whitespace("name"),queryTokenizer:Bloodhound.tokenizers.whitespace,remote:{url:"/owner/user/search/%QUERY%",wildcard:"%QUERY%"}});$(".userPlaceholder").typeahead(null,{name:"email",display:"email",source:e})});