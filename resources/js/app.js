import './bootstrap';
import.meta.glob(['../images/**']);

$(document).ready(function() {
    var altura = $('.bg-login').height($(window).height());
    console.log(altura);
});