$(document).ready(function(){
	buildList();
	const form = $('form#oc_calendar_import');

	if(oc_calendar_settings.calendars.length > 0){
		$("#oc_calendar_import").hide();
	} else {
    $(".oc_calendar_list").hide();
  }

	//show the formular
	$('.oc_calendar_import__add').click(function() {
		resetForm()
		form.show()
			.find("h4.add")
			.removeClass('hidden')
		$('.oc_calendar_list').hide()
	});

	$('.oc_calendar_import__reset').click(function() {
    resetForm()
    if(oc_calendar_settings.calendars.length > 0){
      form.hide()
      $('.oc_calendar_list').show()
    }
	})
  

	form.on('submit',event => {
		event.preventDefault()
		const data = formCollect(form)
		const index = form.data('index') > -1 ? form.data('index') : oc_calendar_settings.calendars.length;
		oc_calendar_settings.calendars[index] = data;
		submitFormular()
		form.hide();
	})

})

function buildList(){
	$('#oc_calendar_list button.oc_calendar__edit').off('click');
	//Init the calendars
	var list = oc_calendar_settings.calendars.map((calendar,index) => {
		return `<li>
					<b>${calendar.name}</b>
					<span>${oc_calendar_settings.baseUrl}${encodeURIComponent(calendar.name)}</span>
					<button class="oc_calendar__edit" data-index="${index}" type="button">
						<span class="fi-pencil"></span>
					</button>
					<button class="oc_calendar__delete" data-index="${index}" type="button">
						<span class="fi-trash"></span>
					</button>
				</li>`
	}).join('');
	//append to list
	$('#oc_calendar_list').html(list.trim());
	$('#oc_calendar_list button.oc_calendar__edit').on('click',function(){
    resetForm()
    
    const form = $('#oc_calendar_import')
		const i = $(this).data('index')
    const item = {...oc_calendar_settings.calendars[i]}
		form.find("h4.edit").removeClass('hidden')
		form.data('index',i);
		form.find('input[name="name"]').val(item.name)
		form.find('input[name="user"]').val(item.user)
		form.find('input[name="password"]').val(item.password)
		form.find('input[name="url"]').val(item.url)
    form.show()
    $('.oc_calendar_list').hide()
	})

	$('#oc_calendar_list .oc_calendar__delete').on('click',function() {
		const parent = $(this).parent()
		const index = parent.data('index')
		oc_calendar_settings.calendars.splice(index-1,1);
		parent.fadeOut(500,function(){
								submitFormular()
								parent.remove()
								buildList()
						})
	})
	$('.oc_calendar_list').show();
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
	form.find('h4').addClass('hidden')
	form.data('index',-1)
	form.find('input').val('')
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
