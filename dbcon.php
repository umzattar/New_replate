<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'dbfoods');

class Conn
{
        private $conn;
		
        public function getConnection()
		{
            $this->conn = null;
            $conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
			if (mysqli_connect_errno()) 
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
              exit();
            }
			
			$this->conn=$conn;
		}
		
		public function insert($query)
        {
         $ret=mysqli_query($this->conn,$query);
         return $ret;
        }
		public function update($query)
        {
         $ret=mysqli_query($this->conn,$query);
         return $ret;
        }
		public function deletedb($query)
        {
         $ret=mysqli_query($this->conn,$query);
         return $ret;
        }
		public function SelectQuery($query)
        {
         $ret=mysqli_query($this->conn,$query);
		 $row = mysqli_fetch_array($ret);
         return $row;
		}
		public function getData($query)
        {
         $result=mysqli_query($this->conn,$query);
         return $result;
		}
	    public function getRows($query)
        {
         $ret=mysqli_query($this->conn,$query);
		 $count = mysqli_num_rows($ret);
         return $count;
        }
		public function chckEndSubmission($EndSubmission)
        {
	      $today = date("Y-m-d");
	      $diff = strtotime($EndSubmission) - strtotime($today);
          $days = (round($diff / (60 * 60 * 24)));
		  return $days;
        }
		
}

?>