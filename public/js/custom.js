//  alert("cia");

/*ANCHOR - Select2*/


$(function() {
    $('select').each(function() {
        $(this).select2({
            theme: 'bootstrap4',
            width: 'style',
            placeholder: $(this).attr('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    });
});


AOS.init();








// $(document).ready(function() {
//     $('#telaio').select2({
//         multiple: true
//     });
// });

// $(document).ready(function() {
//     $('#telaio').select2({
//         multiple: true
//     });
// });


// $(document).ready(function() {
//     $('#cerca').click(function() {
//         $('.cardGeneral').animate({
//             'left': '-=200px'
//         }, 500);
//         $('.cardRisultatiRicerca').show();
//     });
// });


// $(document).ready(function() {
//     $("#cerca").click(function() {
//         $("cardRisultatiRicerca").show();
//     });
// });



// $(document).ready(function() {
//     $('#cerca').click(function() {
//         if ($('#targa').val() == '' && $('#telaio').val() == '') {
//             alert('Inserisci almeno uno dei due campi!');
//             return false;
//         }
//     });
// });