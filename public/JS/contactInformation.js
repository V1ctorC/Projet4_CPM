$( function () {
    $(".information_birthdate").datepicker({
        maxDate : '0' ,
        changeMonth : true ,
        changeYear : true ,
        yearRange : '1900:+0' ,
        dateFormat : "dd-mm-yy",
        dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
        dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
        dayNamesShort: [ "Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam" ],
        firstDay : 1,
        monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre" ],
        monthNamesShort: [ "Jan", "Fev", "Mars", "Avr", "Mai", "Juin", "Jul", "Août", "Sep", "Oct", "Nov", "Dec" ],
    });
});