/**
* Rebinds the datepickers. Use when a datepicker element may have been loaded asynchronously
*
**/
function runDatePicker() {
    $(".date-input-db").datepicker({ dateFormat: 'yy-mm-dd' });
}

function closeModal() {
    $("#theModal .do-close").click();
}

$(document).ready(function() {
    //bind datepickers on page load
    runDatePicker();

    //rebind datepickers after any AJAX calls complete
    $(document).ajaxComplete(function() {
        runDatePicker();
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
