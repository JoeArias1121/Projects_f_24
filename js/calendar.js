document.addEventListener('DOMContentLoaded', function() {
    var calendarElmt = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarElmt, {
      initialView: 'dayGridMonth',

      events: [
	      {
	        title: 'Service Estimate',
	        start: '2022-05-16'
	      },
	      {
	        title: 'Project Proposal',
	        start: '2022-05-20',
	        end: '2022-05-21'
	      },
	      {
	        groupId: '999',
	        title: 'Projects Report Documentation',
	        start: '2022-05-18 12:00:00'
	      }
            ]
    });
    calendar.render();
  });