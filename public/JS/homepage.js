var holidays = ["12/25/2018", "05/01/2019", "11/01/2019", "12/25/2019", "05/01/2020", "11/01/2020", "12/25/2020"];

$( function() {
    $( "#booking_bookingday" ).datepicker({
        minDate : '0',
        maxDate : '+1Y',
        dateFormat : "dd/mm/yy",
        dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
        dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
        dayNamesShort: [ "Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam" ],
        firstDay : 1,
        monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre" ],
        monthNamesShort: [ "Jan", "Fev", "Mars", "Avr", "Mai", "Juin", "Jul", "Août", "Sep", "Oct", "Nov", "Dec" ],
        beforeShowDay: function(date){
            show = true;
            if(date.getDay() == 0)
            {
                show = false;
            }
            for (var i = 0; i < holidays.length; i++) {
                if (new Date(holidays[i]).toString() == date.toString())
                {
                    show = false;
                }
            }
            var display = [show,'',(show)?'':'Hors dimanche et jours fériés'];
            return display;
        },
        onSelect : function () {
            var date = document.getElementById('booking_bookingday').value;
            choiceTypeTicket(date);
            var field = date;
            var url = 'http://127.0.0.1:8000/ajax';
            $(document).ready(function () {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: 'field='+field,
                    success: function () {
                        document.getElementById('submitBooking').style.display ="block";
                        document.getElementById('messageSold').style.display="none";

                    },
                    error: function () {
                        document.getElementById('submitBooking').style.display ="none";
                        document.getElementById('messageSold').style.display="block";
                    }
                })});


        }

    });
} );

function choiceTypeTicket(date)
{

    var today = new Date();

    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var currentDate = dd + '/' + mm + '/' + yyyy;

    var UTChours = today.getUTCHours();
    var currentHour = UTChours + 1;

    if ((date === currentDate) && (currentHour >= 13))
    {
        document.getElementById('booking_type_1').checked = true;
        document.getElementById('booking_type').style.display = "none";
        document.getElementById('halfDay').style.display = 'block';
    }
    else
    {
        document.getElementById('booking_type').style.display = 'block';
        document.getElementById('halfDay').style.display = 'none';
    }

}

//scroll
$(document).ready(function() {
    $('a[href^="#"]').click(function (evt) {
        evt.preventDefault();
        var target = $(this).attr('href');
        $('html, body')
            .stop()
            .animate({scrollTop: $(target).offset().top}, 1000);
    });
});

