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
* Rebinds the datepickers. Use when a datepicker element may have been loaded asynchronously
*
**/
function runDatePicker() {
	$(".date-input-db").datepicker({ dateFormat: 'yy-mm-dd' });
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
						$("#theModal .do-close").click();
					} else {
						$("#theModal .do-results").load(app_http+"?"+modalContext+" #modalContent .do-results > *");
					}
				}
				$("#modalContent .do-results").load(app_http+" #modalContent .do-results > *");
			});
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

/**
* Requests results from the server and updates .do-results with the results
**/

function formGet(theForm) {
	$("#modalContent .do-results").load(app_http+" #modalContent .do-results > *",theForm.serialize());
}

$(document).ready(function() {
	//bind datepickers on page load
	runDatePicker();

	//rebind datepickers after any AJAX calls complete
	$(document).ajaxComplete(function() {
		runDatePicker();
	});

	//remove system messages when clicked on by user
	$("#systemBar").on("click",".sysMsg .alert",function() {
		$(this).fadeOut("slow",function() {
			$(this).remove();
		});
	});

	//show the clear search option when a search is active
	$("#searchResults").click(function() {
		$("#searchStatus a.hidden").fadeIn("fast");
	});

	//reset the search results and UI
	$("#searchStatus a").click(function(e) {
		e.preventDefault();
		$("#searchTerm").val("");
		$("#doSearch").submit();
		$(this).fadeOut("fast");
	});

	//AJAX form submission with confirmation
	//Listens for submission of any form with a .do-submit-confirm class
	$(".container,#theModal").on("submit",".do-submit-confirm",function() {
		if (confirmAction()) {
			formUpdate($(this));
		}
		return false;
	});

	//AJAX form submission for updating app data
	//Listens for submission of any form with a .do-submit class
	$(".container,#theModal").on("submit",".do-submit",function() {
		formUpdate($(this));
		return false;
	});

	//AJAX validated form submission for updating app data
	//Listens for submission of any form with a .do-submit-validate class
	$(".container,#theModal").on("submit",".do-submit-validate",function() {
		if (validateForm($(this))) {
			formUpdate($(this));
		}
		return false;
	});

	//AJAX form submission for getting app data
	//Listens for submission of any form with a .do-get class
	$(".container,#theModal").on("submit",".do-get",function() {
		formGet($(this));
		return false;
	});

	//AJAX form submission for file uploads
	//Listens for submission of any form with a .do-upload class
	$(".container,#theModal").on("submit",".do-upload",function() {
		var $form = $(this);
		var $fileInput = $form.children("input[type=file]");
		var $restorableFileInput = $fileInput.clone(true);
		var newFile = $fileInput[0].files[0];
		var fileName = newFile.name;
		$fileInput.remove();

		var fileReader = new FileReader();

		fileReader.addEventListener("load", function() {
			var $inputNewFile = $("<input>")
			               .attr("type", "hidden")
			               .attr("name", "newFile").val(fileReader.result);
			$(".do-file-gloss").val(fileName);
			$form.append($inputNewFile);
			formUpdate($form).done(function() {
				$restorableFileInput.val("");
				$form[0].reset();
				$(".do-file-preview").css("backgroundImage","none");
				$restorableFileInput.insertBefore($form.find("input[type=submit]"));
			});
		});

		if (newFile) {
			fileReader.readAsDataURL(newFile);
		}

		return false;
	});

	$(".container,#theModal").on("change",".do-upload input[type=file]",function() {
		var $fileInput = $(this);
		var newFile = $fileInput[0].files[0];
		var fileName = newFile.name;
		var previewableTypes = ['jpg', 'jpeg', 'png', 'gif'];
		if (previewableTypes.indexOf(fileName.split('.').pop().toLowerCase()) > -1) {
			var fileReader = new FileReader();

			fileReader.addEventListener("load", function() {
				$(".do-file-preview").css("backgroundImage","url("+fileReader.result+")");
			});

			if (newFile) {
				fileReader.readAsDataURL(newFile);
			}

		}
	});

	//Confirmation interceptor
	//Makes a click on any element with a .do-confirm class cancellable by the user
	$(".container,#theModal").on("click",".do-confirm",function() {
		return confirmAction();
	});

	//Loads the modal box
	//Any anchor tag with a .do-loadmodal class will have the contents of its href loaded into the modal box
	$(".container,#theModal").on("click",".do-loadmodal",function(e) {
		e.preventDefault();
		$clicked = $(this);
		$(".container").addClass("blur");
		$("#theModal .loader").fadeIn("fast",function() {
			$("#theOverlay").fadeIn("fast",function() {
				$("#theModal").fadeIn("fast",function() {
					$("#theModal .content").load($clicked.attr("href")+" #modalContent > *",function() {
						$("#theModal .loader").fadeOut("fast",function() {
							$("#theModal .content").fadeIn("fast");
						});
					});
				});
			});
		});
	});

	//Closes the modal box
	$("#theModal .do-close").click(function(e) {
		e.preventDefault();
		$("#theModal").fadeOut("fast",function() {
			$(".container").removeClass("blur");
			$("#theOverlay").fadeOut("fast");
			$("#theModal .content").hide();
		});
	});
});