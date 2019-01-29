$(document).ready(function(){
	buildList();
	//submit the formular
	$('#oc_calendar_import__edit').click(function() {
		const form = $('form#oc_calendar_import');
		const data = formCollect(form)
		const index = form.data('index') > -1 ? form.data('index') : oc_calendar_settings.calendars.length;

		oc_calendar_settings.calendars[index] = data;
		//var arrData = Array(formCollect($('form#oc_calendar_import')));
		submitFormular()
	});
})



function buildList(){
	$('ul.oc_calendar_list button.oc_calendar__edit').off('click');
	//Init the calendars
	var list = oc_calendar_settings.calendars.map((calendar,index) => {
		return `<li>
					<b>${calendar.oc_calendar_name}</b>
					<span>${oc_calendar_settings.baseUrl}${encodeURIComponent(calendar.oc_calendar_name)}</span>
					<button class="oc_calendar__edit" data-index="${index}" type="button">
						<span class="fi-pencil"></span>
					</button>
					<button class="oc_calendar__delete" data-index="${index}" type="button">
						<span class="fi-trash"></span>
					</button>
				</li>`
	}).join('');
	//append to list
	$('ul.oc_calendar_list').html(list.trim());
	$('ul.oc_calendar_list button.oc_calendar__edit').on('click',function(){
		const i = $(this).data('index')
		const form = $('#oc_calendar_import')
		const item = {...oc_calendar_settings.calendars[i]}
		form.data('index',i);
		form.find('input[name="oc_calendar_name"]').val(item.oc_calendar_name)
		form.find('input[name="oc_calendar_user"]').val(item.oc_calendar_user)
		form.find('input[name="oc_calendar_password"]').val(item.oc_calendar_password)
		form.find('input[name="oc_calendar_url"]').val(item.oc_calendar_url)
	})

	$('ul.oc_calendar_list .oc_calendar__delete').on('click',function() {
		const parent = $(this).parent()
		const index = parent.data('index')
		oc_calendar_settings.calendars.splice(index-1,1);
		parent.fadeOut(500,function(){
								submitFormular()
								parent.remove()
								buildList()
						})
	})
}


function submitFormular(){
	$.post('setConfigValueAjax.php', {
		'key' : 'oc_calendars',
		'value' : JSON.stringify(oc_calendar_settings.calendars) })
	.done(function() { 
		resetForm();
		buildList();
		$('#ok').show(30, function() {
			$(this).hide('slow');
		})
	})
}

function resetForm(){
	const form = $('#oc_calendar_import')
	form.data('index',null);
	form.find('input.oc_calendar_change').val('')
}


function formCollect(form) {
	var objParams = {};
	var input = form.find('input, textarea:enabled,button:focus').toArray();
	var select = form.find('select').toArray();
	//input & textarea
	$.each(input, function(i, item) {
		var obj = {};
		var name = $(this).attr('name');

		if ($(this).attr('type') == 'radio') {
			var value = form.find('input[name="' + name + '"]:checked').val();
			obj[name] = value;
			$.extend(objParams, obj);
		} else if ($(this).attr('type') == 'checkbox') {
			if($(this).prop('checked') == false || !$(this).is(':checked')){
				var value = 0;
			} else {
				var value = $(this).val();
			}
			var arrSplit = name.split("[");
			if (arrSplit.length > 1) {
				if (value != 0){
					name = arrSplit[0];
					if (objParams[name] == undefined){
						value = Array(value);
					} else {
						var oldval = objParams[name];
						var newval = value;
						var value = oldval.concat(newval);
					}
					obj[name] = value;
					$.extend(objParams, obj);
				}
			} else {

				obj[name] = value;
				$.extend(objParams, obj);
			}
		} else if (!$(this).is(":button" ) || ($(this).is( ":button" ) && $(this).attr('type') == 'submit' && name)){
			obj[name] = $(this).val();
			$.extend(objParams, obj);
		}
	});
	//select
	$.each(select, function(i, item) {
		var obj = {};
		var name = $(this).attr('name');
		var value = $(this).val();
		obj[name] = value;
		$.extend(objParams, obj);
	});
	return objParams;
}