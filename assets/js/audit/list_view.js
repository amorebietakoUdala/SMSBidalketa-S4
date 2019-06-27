import '../../css/audit/list_view.scss';

import $ from 'jquery';
import 'bootstrap-table';
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export'
import 'bootstrap-table/dist/locale/bootstrap-table-es-ES';
import 'bootstrap-table/dist/locale/bootstrap-table-eu-EU';
import 'tableexport.jquery.plugin/tableExport';
import 'jquery-ui';
import 'bootstrap-datepicker';
import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.es';
import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.eu';
import 'eonasdan-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker';
import 'select2';

// import Swal from 'sweetalert2';

function fireAlert (title,html,confirmationButtonText, cancelButtonText, url) {
	import('sweetalert2').then((Swal) => {
		Swal.default.fire({
		  title: title,
		  html: html,
		  type: 'warning',
		  showCancelButton: true,
		  cancelButtonText: cancelButtonText,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: confirmationButtonText,
		}).then((result) => {
		if (result.value) {
			console.log(url);
			document.location.href=url;
		}
		});
	});
}

function createContactListHtml (contacts) {
	var html = '<ul class="list-group">';
	var elements = '';
	var i;
	for (i=0; i < contacts.length; i++) {
		elements += '<li class="list-group-item">'+contacts[i]['telephone']+'</li>';
	}
	return html+elements+'</ul>';
}

$(document).ready(function(){
	console.log("Audit list view!!!!");
    $('#audit_search_contacts').select2();
	$('#audit_search_user').select2();
	$('#taula').bootstrapTable({
		cache : false,
		showExport: true,
		exportTypes: ['excel'],
		exportDataType: 'all',
		exportOptions: {
			fileName: "concepts",
			ignoreColumn: ['options']
		},
		showColumns: false,
		pagination: true,
		search: true,
		striped: true,
		sortStable: true,
		pageSize: 10,
		pageList: [10,25,50,100],
		sortable: true,
		locale: $('html').attr('lang')+'-'+$('html').attr('lang').toUpperCase(),
	});
	var $table = $('#taula');
	$(function () {
		$('#toolbar').find('select').change(function () {
			$table.bootstrapTable('destroy').bootstrapTable({
			exportDataType: $(this).val(),
			});
		});
	});
    $('.js-datetimepicker').datetimepicker({
		format: 'YYYY-MM-DD HH:mm',
		sideBySide: true,
		locale: $('html').attr('lang'),
	});
//	$('.js-delete').on('click',function(e){
//		e.preventDefault();
//		var url = e.currentTarget.dataset.url;
//		var confirmation = e.currentTarget.dataset.confirmation;
//		var message = e.currentTarget.dataset.message;
//		var confirm = e.currentTarget.dataset.confirm;
//		var cancel = e.currentTarget.dataset.cancel;
//		fireAlert(confirmation,message,confirm,cancel,url);
//	});
	$('#taula').on('click','.js-fireAlert',function(e){
		e.preventDefault();
		console.log('Contacts Clicked!!!');
		console.log($(e.currentTarget));
		var url = e.currentTarget.dataset.url;
		var title = e.currentTarget.dataset.title;
		console.log(url);
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			success: function (json) {
				var html = createContactListHtml(json);
				console.log(html);
				import('sweetalert2').then((Swal) => {
					Swal.default.fire({
						title: title,
						html: html,
//						type: 'success',
//						confirmButtonColor: '#3085d6',
//						confirmButtonText: 'Ok',
					});
				});
			}
		});
		
//		import('sweetalert2').then((Swal) => {
//			Swal.default.fire({
//			  title: title,
//			  html: html,
//			  type: 'warning',
//			  showCancelButton: true,
//			  cancelButtonText: cancelButtonText,
//			  confirmButtonColor: '#3085d6',
//			  cancelButtonColor: '#d33',
//			  confirmButtonText: confirmationButtonText,
//			}).then((result) => {
//			if (result.value) {
//				console.log(url);
//				document.location.href=url;
//			}
//			});
		});
	});

