<?php


class QuizModel extends DB\SQL\Mapper
{

    public function __construct(DB\SQL $db){
        parent::__construct($db, 'quiz_details');
    }

    /**
 * Fetch all the records from the table
 *
 * @return [array] results
 */
    public function fetchAll(){
        $this->load();
        return $this->query;
    }

    /**
     * Fetch quiz with a specific id
     *
     * @param [int] $id
     * @return mixed - a single result of the query
     */
    public function getById($id){
        if (is_numeric($id)){
            $this->load(array("id=?", $id));
            $query = $this->query;
            return $query[0];
        }
    }




}