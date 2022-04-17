// On filtre les suites en Ajax
const $etablissement = $("#reservation_etablissements");
$etablissement.change(function (){
    let $form = $(this).closest("form");
    let data = {};
    data[$etablissement.attr('name')] = $etablissement.val();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        complete: function (html) {
            $('#reservation_suites').replaceWith(
                $(html.responseText).find('#reservation_suites')
            );
        }
    });
});

// Vérification de la dispo d'une suite
const $form = $('#form_reservation');
$form.submit(function (e){
    e.preventDefault();
    let data = $form.serialize();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        complete: function (html){
            $('#result').replaceWith(
                $(html.responseText).find('#result'));
        }
    });
});