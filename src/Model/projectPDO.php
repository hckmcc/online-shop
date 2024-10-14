<?php
class projectPDO
{
    public function returnPDO():PDO
    {
        return new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
    }
}