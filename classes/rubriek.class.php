<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

class Rubriek extends Model
{
    const MAX_NAAM_LENGTH = 50;
    
    
    public function getId()
    {
        return $this->data['id'] ?? 0;
    }
    
    public function getNaam()
    {
       return $this->data['naam'] ?? ''; 
    }
    
    public function getAantalProducten()
    {
       return $this->data['aantal_producten'] ?? 0; 
    }
    
    public function setId($value)
    {
        $this->data['id'] = $value;
    }
    
    private function setNaam($value)
    {
        $this->data['naam'] = $value;
    }
    
    private function setAantalProducten($value)
    {
        $this->data['aantal_producten'] = $value;
    }
    
    public function make($data = [])
    {
        $this->setId($data['id'] ?? $this->getId());
        $this->setNaam($data['naam'] ?? '');
        $this->setAantalProducten($data['aantal_producten'] ?? 0);
    }
    
    public function load()
    {
        $query = '
            SELECT * 
            FROM rubrieken
            WHERE id = :id 
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setLoaded($record !== false);
        if ($this->getLoaded())
        {
            $this->make($record);
        }       
    }
    
    public function save()
    {
        $query = '
            INSERT 
            INTO rubrieken (naam)
            VALUES (:naam)
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':naam', $this->getNaam(), PDO::PARAM_STR);
        $ok = $statement->execute();
        $this->setId($this->pdo->lastInsertId());
    }
    
    public function update(&$updated)
    {
        $query = '
            UPDATE rubrieken
            SET naam = :naam
            WHERE id = :id
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':naam', $this->getNaam(), PDO::PARAM_STR);
        $statement->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $updated = $statement->rowCount() == 1;
    }
    
    public function delete(&$deleted)
    {
        $query = '
            DELETE FROM rubrieken
            WHERE id = :id
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $deleted = $statement->rowCount() == 1;
    }
    
    public function isValid($ignore_id = false)
    {
        $naam = $this->getNaam();
        if ($naam == '')
        {
            $this->setError('naam', 'mag niet leeg zijn!');
        }
        elseif (strlen($naam) > self::MAX_NAAM_LENGTH)
        {
            $this->setError('naam', 'mag niet langer zijn dan ' . self::MAX_NAAM_LENGTH . 'tekens!');
        }
        elseif ($this->naamExists($ignore_id))
        {
            $this->setError('naam', 'bestaat al!');
        }
        return $this->hasNoErrors();
    }
    
    public function deletable()
    {
        $query = '
            SELECT count(*) 
            FROM producten
            WHERE id_rubriek = :id_rubriek 
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id_rubriek', $this->getId(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $aantal = $statement->fetch(PDO::FETCH_COLUMN);
        return ($aantal == 0);
    }
    public function getIdByName(){
        $query = "SELECT id
                  FROM rubrieken
                  WHERE naam = :naam";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $contents = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $contents;
    }
    private function naamExists($ignore_id)
    {
        $query = '
            SELECT count(*)
            FROM rubrieken
            WHERE naam = :naam
        ';
        if ($ignore_id)
        {
            $query .= 'AND id <> :id';
        }
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':naam', $this->getNaam(), PDO::PARAM_STR);
        if ($ignore_id)
        {
            $statement->bindValue(':id', $this->getId(), PDO::PARAM_INT);            
        }
        $ok = $statement->execute();
        $aantal = $statement->fetch(PDO::FETCH_COLUMN);
        return $aantal != 0;
    }
    
    static public function index(MyPDO $pdo)
    {
        $query = '
            SELECT rubrieken.id, rubrieken.naam, count(producten.id) AS aantal_producten 
            FROM rubrieken
            LEFT JOIN producten ON rubrieken.id=producten.id_rubriek
            GROUP BY rubrieken.id
            ORDER BY rubrieken.naam
        ';
        $statement = $pdo->prepare($query);
        $ok = $statement->execute();
        $objects = [];
        while ($record = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $rubriek = new Rubriek($pdo);
            $rubriek->make($record);
            $objects[] = $rubriek;
        }
        return $objects;
    }
    
}