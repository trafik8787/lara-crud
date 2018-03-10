$(document).ready(function () {

    $(document).on('click', '.close-bloc-image', function () {
        $(this).parents('li').detach();
    });

});