/**
* Simple wrapper for the built in confirm()
*
*/
function confirmAction() {
	if (confirm("Are you sure?")) {
		return true;
	}
	return false;
}

/**
* Parse the system output from the HTML returned after an AJAX POST and pop it into the active DOM
*
**/
function updateSystemOutput(data) {
	$(".sysMsg").html($($(data).filter("#systemBar").find(".sysMsg")).html());
	setTimeout("$(\".sysMsg h4\").fadeOut(\"slow\")",6000);
}

/**
* POSTs a form data update to the server, then updates .do-results with a fresh copy of its contents
*
* To keep a modal open and updated after form submission, add a modal_context input field to the modal form. 
* Its value should be the query string of the content with which you want to update the modal.
*
**/

function formUpdate(theForm) {
	var isModal = (theForm.parents("#theModal").length != 0) ? true:false;
	
	return $.ajax({
				type: "POST",
				url: app_http,
				data: theForm.serialize()
			}).done(function(data) {
				updateSystemOutput(data);
				if (isModal) {
					var $modalContextField = theForm.children("input[name=modal_context]");
					if ($modalContextField) {
						var modalContext = $modalContextField.val();
					}
					if (!modalContext) {
						closeModal();
					} else {
						$("#theModal .do-results").load(app_http+"?"+modalContext+" #modalContent .do-results > *");
					}
				}
				$("#modalContent .do-results").load(app_http+" #modalContent .do-results > *");
			});
}

/**
* Requests results from the server and updates .do-results with the results
**/

function formGet(theForm) {
	$("#modalContent .do-results").load(app_http+" #modalContent .do-results > *",theForm.serialize());
}

/** Form Validation functions **/

function showErrorMessage($formInput) {
  $parentGroup = $formInput.closest(".form-group");
  $parentGroup.addClass("do-error");
  if ($parentGroup.find(".alert").length == 0) {
    $formLabel = $parentGroup.children("label");
    $formLabel.after('<div class="alert alert-danger">Please enter a value for '+$formLabel.text()+'</div>');
  }
  var inputType = $formInput[0].type;
  if (inputType == 'radio') {
    $radios = $formInput.closest("form").find("input[name='"+$formInput.attr("name")+"']");
    $radios[0].focus();
    $radios.change(function() {
      if ($(this).is(":checked")) {
        $parentGroup.removeClass("do-error");
      }
    });
  } else {
    $formInput.focus();
    $formInput.change(function() {
      if ($formInput.val()) {
        $parentGroup.removeClass("do-error");
      }
    });
  }
}

function validateText($formInput) {
  if ($formInput.val()) {
    return true;
  }
  showErrorMessage($formInput);
  return false;
}

function validateRadio($formInput,checkedRadios) {
  if ((checkedRadios.indexOf($formInput.attr("name")) > -1) || $formInput.parents("form").find("input[name='"+$formInput.attr("name")+"']:checked").length > 0) {
    return true;
  }
  showErrorMessage($formInput);
  return false;
}

function validateSelect($formInput) {
  if ($formInput.children("option:selected").length > 0) {
    return true;
  }
  showErrorMessage($formInput);
  return false;
}

function validateNumeric($formInput) {
  if ($.isNumeric($formInput.val()) && $formInput.val() >= 1) {
    return true;
  }
  showErrorMessage($formInput);
  return false;
}

function validateForm($form) {
	var errorFlag = false;
	var checkedRadios = [];
	//gather all form-group elements that also have the do-validate class
	$form.find("div.form-group.do-validate").each(function() {
		//find any input or select elements within the form-group
		$validateInput = $(this).find("input,select");
		//only validate if the element is visible to the user
		if ($(this).is(":visible")) {
			//check for custom validation function referenced in the data-validator attribute
			var validator = $(this).data("validator");
			if (validator && typeof window[validator] == 'function') {
				if (!window[validator]($validateInput)) {
					errorFlag = true;
					return false;
				}
			// if no custom validator is defined, fall back to the generic validation functions
			} else {
				var inputType = $validateInput[0].type;
				switch (inputType) {
					case 'text':
						if (!validateText($validateInput)) {
							errorFlag = true;
							return false;
						}
					break;
					case 'radio':
						if (!validateRadio($validateInput,checkedRadios)) {
							errorFlag = true;
							return false;
						}
						checkedRadios.push($validateInput.attr("name"));
					break;
					case 'select-multiple':
						if (!validateSelect($validateInput)) {
							errorFlag = true;
							return false;
						}
					break;
					case 'select-one':
						if (!validateSelect($validateInput)) {
							errorFlag = true;
							return false;
						}
					break;
				}
			}
		}
	});
	if (errorFlag) {
		return false;
	}
	return true;
}

/** End form validation functions **/