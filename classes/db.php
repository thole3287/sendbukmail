<?php

/**
 * 
 */
class DataBase
{
	private $dbhost_active = 'localhost',
            $dbname_active = 'trumthev_test',
            $dbuser_active = 'trumthev_test',
            $dbpassword_active = ''; // Kqy+m3DJ86Sp //Qo#OwxeeUupH

	public $conn = NULL;

	public function Connect()
	{
		$this->conn = mysqli_connect($this->dbhost_active, $this->dbuser_active, $this->dbpassword_active, $this->dbname_active);
		@mysqli_query($this->conn, "SET NAMES 'UTF8'");
        @mysqli_set_charset($this->conn, 'UTF8');
	}

	public function Close()
    {
        if ($this->conn)
        {
            mysqli_close($this->conn);
        }
    }

	public function Query($sql = null) 
    {       
        if ($this->conn)
        {
            return @mysqli_query($this->conn, $sql);
        }
    }

    public function Num_Rows($sql = null) 
    {
        if ($this->conn)
        {
            $query = @mysqli_query($this->conn, $sql); //?? SỐ DÒNG TRONG DỮ LIỆU
            if ($query)
            {
                return @mysqli_num_rows($query);
            }   
        }       
    }

    public function Fetch_Array($sql = null) // GỌI 1 DỮ LIỆU HOẶC 1 BẢNG RA
    {
        if ($this->conn)
        {
            $query = @mysqli_query($this->conn, $sql);
            if ($query)
            {
                return @mysqli_fetch_array($query, MYSQLI_ASSOC);
            }
        }       
    }

    public function Fetch_Assoc($sql = null) 
    {
        if ($this->conn)
        {
            $query = @mysqli_query($this->conn, $sql);
            if ($query)
            {
                $return = array();
                while ($row = mysqli_fetch_assoc($query))
                {
                    $return[] = $row;
                }
                mysqli_free_result($query);
                return $return;
            }
        }       
    }


    public function Real_Escape_String($sql = null)
    {
        return mysqli_real_escape_string($this->conn, $sql);
    }

    public function Insert_Id()
    {
        if ($this->conn)
        {
            $count = mysqli_insert_id($this->conn);
            if ($count == '0')
            {
                $count = '1';
            }
            else
            {
                $count = $count;
            }
            return $count;
        }
    }
}
