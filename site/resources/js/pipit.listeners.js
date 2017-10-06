$(document).ready(function() {
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