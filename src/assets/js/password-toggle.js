$(function() {

    $('.password-toggle-label input[type="checkbox"]').on('click', function (e) {
        var $input = $(this).closest('.input-group').find('input[type="text"], input[type="password"]');
        $input.replaceWith($input.clone().attr('type', $input.attr('type') === 'text' ? 'password' : 'text'));
    });
});
