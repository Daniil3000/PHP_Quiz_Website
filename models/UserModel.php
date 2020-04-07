<?php


class UserModel extends DB\SQL\Mapper
{
    public function __construct(DB\SQL $db){
        parent::__construct($db, 'quiz_users');
    }

    /**
     * Add a record to DB
     */
    public function add(){
        $this->copyfrom("POST");
        $this->save();
    }

    /**
     * Fetch a user with a specific id
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

    /**
     * Fetch a user with a specific email
     *
     * @param [string] $email
     * @return mixed array
     */
    public function getByEmail($email){

            $this->load(array("email=?", $email));
            $query = $this->query;
            return $query[0];

    }



}