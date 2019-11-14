<?php
/**
 * Author : Taranpreet Singh
 * PHPCLASSES Profile : https://www.phpclasses.org/browse/author/1466924.html
 * Want to get something developed ? Let's make it email at : taranpreet@taranpreetsingh.com 
 */
class User{

    private $db = null;

    function __construct(){
        $this->db = new DB;
        $this->db->setTbl('users');
    }

    /**
     * Add new user.
     */
    public function add(array $data) : bool{
        if($this->db->add($data)){
            return true;
        }
        return false;
    }
    
    /**
     * Update user deatails using id and [<items>]
     */
    public function update(int $id, array $data) : bool{
        if(!is_null($id) && is_int($id) && !empty($data)){
            if($this->db->update($id,$data)){
                return true;
            }
        }
        return false;
    }

    /**
     * Delete user using id
     */
    public function delete(int $id) : bool{
        if(!is_null($id) && is_int($id) && !empty($data)){
            if($this->db->delete($id)){
                return true;
            }
        }
        return false;
    }

    /**
     * 
     */
    public function find($user) : bool{
        if($user){
            if (is_numeric($user)) {
                $sqlQuery = "select * from {$this->db->getTbl()} where id = :user";
            } elseif (filter_var($user, FILTER_VALIDATE_EMAIL)) {
                $sqlQuery = "select * from {$this->db->getTbl()} where email = :user";
            } else {
                $sqlQuery = "select * from {$this->db->getTbl()} where username = :user";
            }
            $result = $this->db->querySingle($sqlQuery,[':user' => $user]);
            if(!empty($result)){
                return true;
            }
        }
        return false;
    }

    /**
     * 
     */
    public function login(string $user,string $password) : bool{
        if ($user && $password) {
            $findUser = $this->find($user);
            if ($findUser) {
                if(senatize($user,'email')){
                    $sqlQuery = "select * from {$this->db->getTbl()} where email = :user";
                }else{
                    $sqlQuery = "select * from {$this->db->getTbl()} where username = :user";
                }
                
                $result = $this->db->querySingle($sqlQuery,[':user' => $user]);
                if ($result->password == encrypt($password)) {
                    //add here
                    if ($result->status == 1) {
                        Session::insert('email', $result->email);
                        Session::insert('U_ID', $result->id);
                        Session::insert('isLoggedIn', true);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 
     */
    public function createLog(int $id,string $msg) : bool{
        $oldMessagesQuery = $this->db->querySingle("select logs from {$this->db->getTbl()} where id = :user",[':user' => $id]);
        $oldMessages = json_decode($oldMessagesQuery->logs,true);
        array_push($oldMessages,[timestamp() => $msg]);
        $update = $this->db->update($id,['logs' => json_encode($oldMessages)]);
        if($update){
            return true;
        }
        return false;
    }

    /**
     * 
     */

     public function logout() : bool{
        Session::del('email');
        Session::del('isLoggedIn');
        $this->db->update(Session::get('U_ID'), ['ip' => getIP()]);
        Session::del('U_ID');
        if (Session::exists('admin')) {
            Session::del('admin');
        }
        return true;
     }

    /**
     * 
     */
     public function getLogs($user){
         $result = $this->db->querySingle("select logs from {$this->db->getTbl()} where id = :user",[':user' => $user]);
         if(!empty($result)){
             return json_decode($result->logs,true);
         }
         return false;
     }

     /**
      * 
      */

      public function get($user){
         $result = $this->db->querySingle("select * from {$this->db->getTbl()} where id = :user",[':user' => $user]);
         if(!empty($result)){
             return $result;
         }
         return false;
      }

      /**
       * 
       */

       public function getByAccountKey(int $key){
            $result = $this->db->querySingle("select * from {$this->db->getTbl()} where _key = :key",[':key' => $key]);
            if(!empty($result)){
                return $result->id;
            }
            return false;
       }

}