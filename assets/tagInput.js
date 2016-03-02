$(document).ready(function () {

	localStorage.clear();

	$('input[data-tagInput]').each(function () {

		var settings = jQuery.parseJSON($(this).attr('data-tagInput'));

		var data = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace(settings.labelPropertyName),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: {
				url: settings.url
			}
		});

		data.initialize();

		$(this).tagsinput({
			itemValue: settings.valuePropertyName,
			itemText: settings.labelPropertyName,
			maxTags: settings.maxTags,
			typeaheadjs: {
				name: 'data',
				displayKey: settings.labelPropertyName,
				source: data.ttAdapter()
			}
		});

	});

});
