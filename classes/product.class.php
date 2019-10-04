<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

class Product extends Model
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

    public function getPrijs()
    {
      return $this->data['prijs'] ?? "";

    }

    public function setPrijs($value)
    {
        $this->data['prijs'] = $value;
    }
    public function getId_rubriek()
    {
        return $this->data['id_rubriek'] ?? "";

    }

    public function setId_rubriek($value)
    {
        $this->data['id_rubriek'] = $value;
    }
    public function getRubriek()
    {
        return $this->data['rubriek'] ?? "";

    }

    public function setRubriek($value)
    {
        $this->data['rubriek'] = $value;
    }


    public function setId($value)
    {
        $this->data['id'] = $value;
    }

    private function setNaam($value)
    {
        $this->data['naam'] = $value;
    }

    public function make($data = [])
    {
        $this->setId($data['id'] ?? $this->getId());
        $this->setNaam($data['naam'] ?? '');
        $this->setPrijs($data['prijs'] ?? '');
        $this->setId_rubriek($data['id_rubriek'] ?? '');
    }

    public function load()
    {
        $query = '
            SELECT * 
            FROM producten
            WHERE id = :id 
        ';
        $statement = $this->pdo->prepare($query);
       // var_dump($this->getId());
        $statement->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);
      //  var_dump($record);
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
            INTO producten(naam,prijs,id_rubriek)
            VALUES (:naam,:prijs,:id_rubriek)
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':naam', $this->getNaam(), PDO::PARAM_STR);
        $statement->bindValue(':prijs', $this->getPrijs(), PDO::PARAM_INT);
        $statement->bindValue(':id_rubriek', $this->getId_rubriek(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $this->setId($this->pdo->lastInsertId());
    }

    public function update(&$updated)
    {
        $query = '
            UPDATE producten 
            SET naam = :naam, prijs = :prijs, id_rubriek = :id_rubriek
            WHERE id = :id
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':naam', $this->getNaam(), PDO::PARAM_STR);
        $statement->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $statement->bindValue(':prijs', $this->getPrijs(), PDO::PARAM_STR);
        $statement->bindValue(':id_rubriek', $this->getId_rubriek(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $updated = $statement->rowCount() == 1;
    }

    public function delete(&$deleted)
    {
        $query = '
            DELETE FROM producten
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
        $prijs = $this->getPrijs();
        if ($prijs > 100)
        {
            $this->setError('prijs','mag niet hoger zijn dan 100 euro!');
        }
        return $this->hasNoErrors();
    }
    public function getRubrieken()
    {
        $query = "SELECT *
                  FROM rubrieken";
        $statement = $this->pdo->prepare($query);
        $ok = $statement->execute();
        $contents = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $contents;

    }
  
    
    
    
    
    
    
    
    public function getId_rubrieken(MyPDO $pdo){
        $query = '
            SELECT producten.id_rubriek 
            FROM producten
        ';
        $statement = $this->pdo->prepare($query);
        $ok = $statement->execute();

        $record = $statement->fetchAll(PDO::FETCH_COLUMN);
     //   var_dump($record);

        return $record;
        
    }
    
    public function deletable()
    {
        $query = '
            SELECT id_product 
            FROM bestelling_product
            WHERE id_product = :id_product 
        ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id_product', $this->getId(), PDO::PARAM_INT);
        $ok = $statement->execute();
        $aantal = $statement->fetch(PDO::FETCH_COLUMN);
        return ($aantal == 0);
    }

    private function naamExists($ignore_id)
    {
        $query = '
            SELECT count(*)
            FROM producten
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
            SELECT producten.id, producten.naam, producten.prijs, rubrieken.naam as id_rubriek
            FROM producten
            LEFT JOIN rubrieken ON producten.id_rubriek = rubrieken.id
        ';
        $statement = $pdo->prepare($query);
        $ok = $statement->execute();
        $objects = [];
        while ($record = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $product = new Product($pdo);
            $product->make($record);
            $objects[] = $product;
        }

        return $objects;
    }

}