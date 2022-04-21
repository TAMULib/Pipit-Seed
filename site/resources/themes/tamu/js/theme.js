//this function is called by pipit functions when they need to close an open modal
function closeModal() {
    $('#theModal').modal('hide');
}

$(document).ready(function() {
    //Loads the bootstrap modal box
    //Any anchor tag with a .do-loadmodal class will have the contents of its href loaded into the modal box
    $(".container,#theModal").on("click",".do-loadmodal",function(e) {
        e.preventDefault();
        $clicked = $(this);
        $(".container").addClass("blur");
        $("#theModal").fadeIn("fast",function() {
            $("#theModal .modal-body").load($clicked.attr("href")+" #modalContent > *",function() {
                $('#theModal').modal('show');
            });
        });
    });
});
