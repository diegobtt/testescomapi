<?php

namespace app\traits;

use PDOException;

trait Delete {
    public function delete ($field,$value){

        try {
            $prepared = $this->connection->prepare("delete from $this->table where {$field} = :{$field}");
            $prepared->bindValue($field,$value);
            return $prepared->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

}