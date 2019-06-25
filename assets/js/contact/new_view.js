import '../../css/contact/new_view.scss';

import $ from 'jquery';
import 'devbridge-autocomplete';

$(document).ready(function(){
	var wrapper = $('.js-labels-wrapper');
	wrapper.on('click','.js-label-remove', function (e) {
		e.preventDefault();
		console.log("Remove label clicked!!!");
		$(this).closest('.js-label-item').remove();
	});
	
	wrapper.on('click','.js-label-add', function (e) {
		e.preventDefault();
		var prototype = wrapper.data('prototype');
		var index = wrapper.data('index');
		var newForm = prototype;
		newForm = newForm.replace(/__name__/g, index);
		wrapper.data('index', index + 1);
		$(this).before(newForm);
		$('.js-autocomplete').autocomplete({
			minChars: 2,
			serviceUrl: '/smsbidalketa/api/labels',
			paramName: "name",
			transformResult: function(response) {
				var json_data = JSON.parse(response);
				return {
					suggestions: $.map(json_data.labels, function(dataItem) {
						// console.log(dataItem);
						return { value: dataItem.name, data: dataItem.id };
					})
				};
			},
		onSelect: function (suggestion) {
			var input_name = $(this).attr('id');
			var input_id = input_name.replace('name','id');
			$(document).find('#'+input_id).val(suggestion.data);
			
		}
		});
	});
});
