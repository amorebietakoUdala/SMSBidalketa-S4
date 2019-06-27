import '../../css/sending/sending_view.scss';

import $ from 'jquery';
import 'bootstrap-table';
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export'
import 'bootstrap-table/dist/extensions/multiple-selection-row/bootstrap-table-multiple-selection-row'
import 'bootstrap-table/dist/extensions/select2-filter/bootstrap-table-select2-filter'
import 'bootstrap-table/dist/locale/bootstrap-table-es-ES';
import 'bootstrap-table/dist/locale/bootstrap-table-eu-EU';
import 'tableexport.jquery.plugin/tableExport';
import 'jquery-ui';
import 'bootstrap-datepicker';
import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.es';
import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.eu';
import 'eonasdan-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker';
import '../components/select2';

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
				var form = $('#form');
				var selections = $('#taula').bootstrapTable('getSelections');
				$('#sending_selected').val(JSON.stringify(selections));
				$(form).attr('action',url);
				form.submit();
		}	
		});
	});
}

$(document).ready(function(){
    $('#sending_labels').select2();
	$('#taula').bootstrapTable({
		cache : false,
		showExport: true,
		exportTypes: ['excel'],
		exportDataType: 'all',
		exportOptions: {
			fileName: "destinatarios",
		},
		pagination: false,
		search: true,
		striped: true,
		sortStable: true,
		sortable: true,
		locale: $('html').attr('lang')+'-'+$('html').attr('lang').toUpperCase(),
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
		var message = $('#sending_message').val();
		if ( message.length === 0 ) {
			var no_message = e.currentTarget.dataset.no_message;
			var error = e.currentTarget.dataset.error;
			import('sweetalert2').then((Swal) => {
				Swal.default.fire(
					error,
					no_message,
					'error'
				  )
			});
			return;
		}
		var selections = $('#taula').bootstrapTable('getSelections');
		if ( selections.length === 0 ) {
			import('sweetalert2').then((Swal) => {
				Swal.default.fire(
					error,
					'No se han seleccionado destinatarios',
					'error'
				  )
			});
			return;
		}
		var url = e.currentTarget.dataset.url;
		var confirmation = e.currentTarget.dataset.confirmation;
		var message = e.currentTarget.dataset.message.replace('%message_count%',selections.length);
		var confirm = e.currentTarget.dataset.confirm;
		var cancel = e.currentTarget.dataset.cancel;
		fireAlert(confirmation,message,confirm,cancel,url);
	});
	$('#js-btn-search').on('click',function(e){
		e.preventDefault();
		var form = $('#form');
		$(form).attr('action',e.currentTarget.dataset.url);
		form.submit();
	});
    $('.js-datetimepicker').datetimepicker({
		format: 'YYYY-MM-DD HH:mm',
		sideBySide: true,
		locale: $('html').attr('lang'),
	});
	$('#taula').bootstrapTable('checkAll');
});
