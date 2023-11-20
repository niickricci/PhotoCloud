<?php

/*
    This class purpose is to generalize model class. Each derived class must respect the following rules :

    - Each member must have a read and a write accessor

    example :

        private $member;

        public function Member() 
        {
            return $this->member;
        }
        public function setMember($value) 
        {
            // eventually apply some validation on $value
            $this->membre = $value;
        }
    - The compare method must be overriden

    example :

        public static function compare($data_a, $data_b)
        {
            return strcmp($data_a->Member(), $data_b->Member());
        }
*/
abstract class Record
{
    protected $id;
    public function __construct($recordData = null)
    {
        if ($recordData != null)
            $this->bind($recordData);
    }
    protected function bind($recordData)
    {
        foreach ($recordData as $fieldName => $fieldValue) {
            $method = 'set' . ucfirst($fieldName);
            if (method_exists($this, $method))
                $this->$method(sanitizeString($fieldValue));
        }
    }
    public function setId($id)
    {
        $id = (int) $id;
        if ($id >= 0)
            $this->id = $id;
    }
    public function Id()
    {
        return $this->id;
    }
    abstract protected static function compare($record_a, $record_b);
    abstract protected static function keyCompare($record_a, $record_b);
}

class Records
{
    protected $_records;
    private $_filePath;

    public function __construct($filePath)
    {
        $this->_filePath = $filePath;
        $this->_records = [];
        $this->read();
    }

    private function read()
    {
        if (file_exists($this->_filePath)) {
            $recordsFile = fopen($this->_filePath, "r");
            try {
                $this->_records = [];
                while (!feof($recordsFile)) {
                    $record = unserialize(fgets($recordsFile));
                    if ($record) {
                        $this->_records[] = $record;
                    }
                }
                $this->sort();
            } catch (Exception $e) {
                echo 'Exception: ', $e->getMessage();
            } finally {
                fclose($recordsFile);
            }
        }
    }

    private function write()
    {
        $recordsFile = fopen($this->_filePath, "w");
        if (flock($recordsFile, LOCK_EX)) {
            try {
                foreach ($this->_records as $record) {
                    fwrite($recordsFile, serialize($record) . "\n");
                }
                fflush($recordsFile);
            } catch (Exception $e) {
                echo 'Exception: ', $e->getMessage();
            } finally {
                flock($recordsFile, LOCK_UN);
                fclose($recordsFile);
            }
        } else {
            echo "Impossible de verrouiller le fichier " . $this->_filePath . " !";
        }
        $this->read();
    }
    public function sort()
    {
        if (count($this->_records) > 0) {
            $className = get_class($this->_records[0]);
            usort($this->_records, $className . '::compare');
        }
    }
    private function maxId()
    {
        $max = 0;
        foreach ($this->_records as $record) {
            if ($record->id() > $max)
                $max = $record->Id();
        }
        return ($max + 1);
    }

    public function add($record)
    {
        $record->setId($this->maxId());
        $this->_records[] = $record;
        $this->write();
    }

    public function get($id)
    {
        foreach ($this->_records as $record) {
            if ($record->Id() === $id)
                return $record;
        }
        return null;
    }

    public function indexOf($id)
    {
        $index = 0;
        foreach ($this->_records as $record) {
            if ($record->Id() === $id)
                return $index;
            $index++;
        }
        return -1;
    }
    public function update($record)
    {
        $index = $this->indexOf($record->Id());
        if ($index > -1) {
            $this->_records[$index] = $record;
            $this->write();
        }
    }

    public function remove($id)
    {
        $index = 0;
        foreach ($this->_records as $record) {
            if ($record->Id() === $id) {
                unset($this->_records[$index]);
                $this->write();
                array_unshift($this->_records);
                return true;
            }
            $index++;
        }
        return false;
    }
    public function toArray()
    {
        $records = [];
        foreach ($this->_records as $record) {
            $records[] = clone $record;
        }
        return $records;
    }

    public function conflict($recordToFind)
    {
        if (count($this->_records) > 0) {
            $className = get_class($this->_records[0]);
            foreach ($this->_records as $record) {
                if (
                    $className::keyCompare($record, $recordToFind) == 0 &&
                    $record->Id() != $recordToFind->Id()
                )
                    return true;
            }
        }
        return false;
    }
    public function findByKey($keyName, $value)
    {
        if (count($this->_records) > 0) {
            foreach ($this->_records as $record) {
                if ($record->$keyName() == $value)
                    return $record;
            }
        }
        return null;
    }
}
