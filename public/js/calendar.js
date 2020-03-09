document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        editable: true,
        contentHeight:"auto",
        eventSources: [
            {
                url: "/fc-load-events",
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        customButtons: {
            dateHeaderAdd: {
              text: 'Ajouter une date',
              click: function() {
                const route  = Routing.generate("date_header_add");
                window.location.href = route;
              }
            }
          },
        header: {
            left: 'prev,next, today, dateHeaderAdd',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        plugins: [ 'interaction', 'dayGrid', 'timeGrid' ], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC',
        locale: 'fr'
    });
    calendar.render();
});