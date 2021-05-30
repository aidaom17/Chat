<?php 

class Message
{
    protected $id, $id_user, $id_channel, $content, $thumbs_up, $date;

    public function __construct( $id, $id_user, $id_channel, $content, $thumbs_up, $date)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_channel = $id_channel;
        $this->content = $content;
        $this->thumbs_up = $thumbs_up;
        $this->date = $date;

    }
    public function __get( $property) 
    {
        if ( property_exists( $this, $property))
            return $this->$property;  
    }
    public function __set( $property, $value)
    {
        if ( property_exists( $this, $property))
            $this->$property = value;
        return $this;
    }

}

?>