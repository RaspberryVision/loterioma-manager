/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

require('jquery');

require('./collection-form');

$(function () {
    $(document).on('click', '.combination-field-trigger', function () {
        $(this).addClass('selected');
        let fields = [];
        $($(this).data('box')).find('.selected').each(function (index, element) {
            fields.push(JSON.parse("[" + $(this).data('index') + "]"));
        });
        $('#' + $(this).data('target')).val(JSON.stringify(fields));
    });
})
