$(document).ready(function () {

    $(document).on('click', '.close-bloc-image', function () {
        $(this).parents('li').detach();
    });

});

function confirmDelete($msg) {

    var result = confirm($msg);

    if (result) {
        return true;
    } else {
        return false;
    }

}