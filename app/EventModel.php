<?php
namespace App;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
class EventModel extends Eloquent implements \MaddHatter\LaravelFullcalendar\IdentifiableEvent
{
  protected $table = 'events'; // you may change this to your name table
  public $timestamps = true; // set true if you are using created_at and updated_at
  protected $primaryKey = 'id'; // the default is id
  protected $all_day = 'full_day';
  protected $dates = ['start_time', 'end_time'];


    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return (bool)$this->all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start_time;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end_time;
    }
    public function eventClick(){
      
    }
}
