<?php 
namespace App;
class myCalendar{
  	public function create()
	    {

	       $events = \App\EventModel::all(); //EventModel implements MaddHatter\LaravelFullcalendar\Event
	       $calendar = \Calendar::addEvents($events, [ //set custom color fo this event
	      'backgroundColor' => '#800','textColor'=> 'black','source'=>'/events/feeds'
	      ])->setOptions([ //set fullcalendar options
	       'firstDay' => 1, 'droppable'=> true,'editable'=> true, 'dropAccept'=>'.draggable-box','rendering' => 'background',
	      ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
	      
	      'eventAfterAllRender' => 'function() {
	       $(\'.fc-content\').css(\'height\', \'80px\');
	       $(\'.fc-content\').css("background","url(\'http://static.food2fork.com/Buffalo2BChicken2BChowder2B5002B0075c131caa8.jpg\') no-repeat");
	       $(\'.fc-content\').css("background-size", \'cont\');
	       $(\'.fc-view-container .fc-day-grid-container\').css(\'height\',\'100px\');
	       $("div[id^=\'calendar\']").fullCalendar(\'changeView\', \'basicWeek\');
	     }',
	   //Add event click to delete callback
	    'eventClick' => 'function(event) {
	       
			if (!confirm(\'Are you sure about this change?\')) {
				revertFunc();
			}else{
				
				$.ajax({
				type:\'POST\',
				url:\'events/delete\',
				data: {
				\'id\': event.id
				},
				success: function(response){
			    event.id = response.eventid;
			    $("div[id^=\'calendar\']").fullCalendar( \'refetchEvents\' );
			   // $(\"div[id^=\'calendar\']\").fullCalendar(\'refetchEventSources\',\'/events/feeds\');
			    },
			    error: function(e){ 
			    	alert(event.id);
			    }
				});
			}

	      }',
			'drop' => 'function(date) {
			// render the event on the calendar
				alert("droped");
			image =  $(this).children(\'img\').attr(\'src\');
			title = $(this).children(\'h3\').text();
			start = date.format();
			end = date.format();
			// the last \'true\' argument determines if the event \"sticks\"
			if (!confirm(\'Are you sure you want to add recipe?\')) {
				revertFunc();
			}else{
				
				$.ajax({
				type:\'POST\',
				url:\'events/create\',
				data: {
				\'title\': title,
				\'start_time\': start,
				\'end_time\': end,
				},
				success: function(response){
			    

			    $("div[id^=\'calendar\']").fullCalendar(\'removeEvents\');
			     $("div[id^=\'calendar\']").fullCalendar( \'refetchEvents\' )
			   	//$("div[id^=\'calendar\']").fullCalendar(\'addEventSource\', response.events);         
                $("div[id^=\'calendar\']").fullCalendar(\'rerenderEvents\' );
			    },
			    error: function(e){ 
			    }
				});
			}
			     
    		}',
			//Add event drop callback
			'eventDrop' => 'function(event){

			// the last true argument determines if the event sticks
			if (!confirm("Are you sure about this change?")) {
				revertFunc();
			}else{
				$.ajax({
				type:\'POST\',
				url:\'events/update\',
				data: {\'id\': event.id,
				\'title\': event.title,
				\'start_time\': event.start.format(),
				\'end_time\': event.start.format(),
				},
				});
			}
			}'
	 ]);
	  return $calendar;
	    }

}


