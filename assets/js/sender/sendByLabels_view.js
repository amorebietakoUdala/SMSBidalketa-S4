import '../../css/sender/sendByLabels_view.scss';

import $ from 'jquery';
import 'bootstrap-table';
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export'
import 'bootstrap-table/dist/extensions/multiple-selection-row/bootstrap-table-multiple-selection-row'
import 'bootstrap-table/dist/extensions/select2-filter/bootstrap-table-select2-filter'
import 'bootstrap-table/dist/locale/bootstrap-table-es-ES';
import 'bootstrap-table/dist/locale/bootstrap-table-eu-EU';
import 'tableexport.jquery.plugin/tableExport';
import 'jquery-ui';
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

$(document).ready(function(){
	console.log("SendByLabels view!!!!");
    $('#send_by_label_labels').select2();
	$('#taula').bootstrapTable({
//		cache : false,
//		showExport: true,
//		exportTypes: ['excel'],
//		exportDataType: 'all',
//		exportOptions: {
//			fileName: "destinatarios",
//			ignoreColumn: ['options']
//		},
//		showColumns: false,
//		pagination: true,
//		search: true,
//		striped: true,
//		sortStable: true,
//		pageSize: 10,
//		pageList: [10,25,50,100],
//		sortable: true,
		locale: $('html').attr('lang'),
		multipleSelectRow: true,
	});
	var $table = $('#taula');
	$(function () {
		$('#toolbar').find('select').change(function () {
			$table.bootstrapTable('destroy').bootstrapTable({
			exportDataType: $(this).val(),
			});
		});
	});
	$('#js-btn-send').on('click',function(e){
		e.preventDefault();
		console.log('send clicked!!!');
		var form = $('#form');
		var selections = $('#taula').bootstrapTable('getSelections');
		console.log(selections);
//		var ids = selections.map(function (x) {
//			return  { 'id': x.id, 'telephone': x.telephone };
//		});
//		console.log(ids);
//		$('#send_by_label_selected').val(JSON.stringify(ids));
		$('#send_by_label_selected').val(JSON.stringify(selections));
		console.log($('#send_by_label_selected').val());
		$(form).attr('action',e.currentTarget.dataset.url);
		form.submit();
	});
	$('#js-btn-search').on('click',function(e){
		e.preventDefault();
		console.log('search clicked!!!');
		var form = $('#form');
		$(form).attr('action',e.currentTarget.dataset.url);
		form.submit();
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

});
