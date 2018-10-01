<?php
class usersOnline {

    var $timeout = 600;
    var $count = 0;
    
    function usersOnline () {
        $this->timestamp = time();
        $this->ip = $this->ipCheck();
        $this->new_user();
        $this->delete_user();
        $this->count_users();
    }
    
    function ipCheck() {

        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    function new_user() {
        $insert = mysql_query ("INSERT INTO useronline(timestamp, ip) VALUES ('$this->timestamp', '$this->ip')");
    }
    
    function delete_user() {
        $delete = mysql_query ("DELETE FROM useronline WHERE timestamp < ($this->timestamp - $this->timeout)");
    }
    
    function count_users() {
        //$count = mysql_num_rows ( mysql_query("SELECT DISTINCT ip FROM useronline"));
        $count = mysql_num_rows ( do_db_query("SELECT DISTINCT ip FROM useronline"));
        return $count;
    }

}
?>