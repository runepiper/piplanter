
(function() {
    'use strict';

    var $forms = document.querySelectorAll('.form');

    var initForms = function($form) {
        var $submitButton = $form.querySelector('.form__button');

        $submitButton.addEventListener('click', function(e) {
            // Add spinner
            if(this.classList.contains('form__button--will-load')) {
                this.classList.add('form__button--loading');
            }
        });
    };

    Array.prototype.forEach.call($forms, function($currentElement) {
        initForms($currentElement);
    });

}());
