function flashMessage(type, message) {
    var flashContainer = $('#flash-message');
    var flash = null;
    if (message.title) {
        flash = $('<div class="alert alert-block alert-' + type + '"><h4 class="alert-heading">' + message.title + '</h4><p>' + message.message + '</p></div>');
    }
    else {
        flash = $('<div class="alert alert-block alert-' + type + '"><p>' + message + '</p></div>');
    }

    flashContainer.append(flash);

    setupFlash.call(flash);
}

function setupFlash()
{
    var flash = $(this);
    if (flash.html() != '') {
        var timeout = flash.data('timeout');
        if (timeout) {
            clearTimeout(timeout);
        }

        if (!flash.hasClass('alert-danger')) {
            flash.data('timeout', setTimeout(function() { flash.fadeOut(400, function() { $(this).remove(); }); }, 5000));
        }

        flash.fadeIn();
    }
}

function showFlashMessage() {
    var flashes = $('#flash-message .alert');
    flashes.each(setupFlash);
}

function initFlashMessage(){
    $('#flash-message').on('click', '.alert', function() { $(this).fadeOut(400, function() { $(this).remove(); }) ; });
    showFlashMessage();
}
