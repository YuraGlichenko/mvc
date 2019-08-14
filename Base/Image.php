<?php
namespace Base;

class Image
{
    private $_fileName;
    private $_fileType;
    private $_fileSize;
    private $_fileTmp;
    private $_filePath;

    public function copyImage()
    {
        if (!strpos($this->_fileType, 'jpeg')) {
            echo "загрузите формат jpeg";
            return false;
        }
        $this->_filePath = '../image/' . $this->_fileName . '.jpeg';
        $fd = file_get_contents($this->_fileTmp);
        $ret = file_put_contents($this->_filePath, $fd);
        if (!$ret) {
            header("HTTP/1.0 404 Not Found");
            return false;
        }
        return true;
    }

    public function loadFile($dataFile)
    {
        $this->_fileSize = $dataFile['photo']['size'];
        $this->_fileType = $dataFile['photo']['type'];
        $this->_fileName = $dataFile['photo']['name'];
        $this->_fileTmp = $dataFile['photo']['tmp_name'];

    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->_filePath;
    }
}