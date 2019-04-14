<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 22.04.2017
 * Time: 20:55
 */
include_once __DIR__.DIRECTORY_SEPARATOR."Crypo.php";

class EncryptedFile
{

    public $filename;
    public $storage;
    public $fullname;

    const SECTION_SIZE = 1048576; // 1Mb
    const BLOCK_SIZE = 8192;

    function __construct($file)
    {
        $this->fullname = $file;
        $this->filename = basename($file);
        $this->storage = dirname($file).DIRECTORY_SEPARATOR;
    }

    // Распаковывает переменную из двоичных данных
    private function long($bin)
    {
        $val = unpack('L', $bin);
        return $val[1];
    }

    // Возвращает 4 байтное занчение из файла
    private function get32Long($pos)
    {
        $marker = file_get_contents($this->fullname , false, null, $pos, 4);
        return $this->long($marker);
    }

    // Возвращает секцию без заголовка
    public function getSection($number){
        $blocksCount = $this->get32Long(0);
        $headerSize = (1 + $blocksCount) * 4;
        $blockOffset = $this->get32Long(( 1 + $number ) * 4 ) + $headerSize;
        $dataSize = $this->get32Long($blockOffset);
        $data = file_get_contents($this->fullname , false, null, $blockOffset + 8, $dataSize);
        return $data;
    }

    // Возвращает блок данных, содержащий количество секций в файле
    // и их изначальный размер в байтах
    public function getFileInfo()
    {
        // Первое значение в файле - количество секций в файле
        $sectionsCount = $this->get32Long(0);
        // Размер заголовка файла
        $headerSize = (1 + $sectionsCount) * 4;
        // Записываем количество секций;
        $header = pack('L', $sectionsCount);

        // Проходим по всем секциям и записываем их изначальную длину
        for($i = 0; $i < $sectionsCount; $i++)
        {
            $offset = (1 + $i)*4;
            $sectionsOffset = $this->get32Long($offset) + $headerSize;
            // размер секции, без заголовка
            // $blockSize = $this->get32Long($this->filename, $sectionsOffset);
            // размер изначальных данных
            $blockOriginSize = $this->get32Long($sectionsOffset + 4);

            // Записываем изначальный размер данных
            $header .= pack('L', $blockOriginSize);
        }

        return $header;
    }


    /**
     * Шифрует новую секцию и записывает ее в файл, дописывая в конец
     *
     * @param $source
     */
    public function uploadSection($source)
    {
        // Читаем весь загруженный файл целиком
        $sourceData = file_get_contents($source , false, null, 0);
        // удаляем с диска
        unlink($source);

        // Добавляем к файлу
        $this->addSection($sourceData);

    }

    public function addSection($sourceData)
    {
        // Создаем шифрованную секцию
        $section = $this->createSection($sourceData);
        // Записываем в файл на сервере зашифрованную секцию.
        file_put_contents( $this->fullname, $section, FILE_APPEND);
    }


    /**
     * Создает новую секцию, шифрует ее и возвращает
     *
     * @param $data исходные данные
     * @return string шифрованные данные
     */
    public function createSection($data)
    {
        $sectionOriginLength = strlen($data);
        $binSectOrigLength = pack('L', $sectionOriginLength);

        // Нужно разбить его на части по BLOCK_SIZE байт.

        // Массив для отдельных блоков
        $encBlocks = array();
        // Начинаем читать с начала файла
        $start = 0;
        // while будет возвращать подстроки длиной не более BLOCK_SIZE.
        // Когда $start будет больше длины строки, функция возвратит false и цикл закончится
        while($block = substr($data, $start, self::BLOCK_SIZE))
        {
            // Шифруем блок.
            $encryptedData = Crypo::encrypt($block);

            // Сохраним длину блока, она потом понадобится
            $encryptedLength = strlen($encryptedData);
            // Перевод в двоичные данные
            $binLength = pack('L', $encryptedLength);

            $encryptedBlock = $binLength . $encryptedData;

            // Все блоки нужно будет записать последовательно, временно помещаем в массив
            $encBlocks[] = $encryptedBlock;

            $start += self::BLOCK_SIZE;
        }

        // Соединяем все части в "секцию"
        $sectionData = implode('', $encBlocks);

        // Длина секции
        $sectionLength = strlen($sectionData);
        $binSectLength = pack('L', $sectionLength);

        // Объединяем заголовок и секцию
        $Section = $binSectLength.$binSectOrigLength.$sectionData;

        return $Section;

    }

    public function createFileHeader()
    {
        $parts = array();

        $offset = 0;

        // Пробегаем по всем секциям, и записываем их смещения и оригинальную длину

        while($marker = file_get_contents($this->fullname , false, null, $offset, 4))
        {
            $sectionSize = $this->long($marker);
            $parts[] = array( 'offset' => $offset);
            $offset += 8 + $sectionSize;   // заголовок секции = 8
        }

        $blocksCount = count($parts);

        $blocksCountData = pack('L', $blocksCount);
        $headerData = $blocksCountData;

        foreach($parts as $partOffset)
        {
            $partOffsetData = pack('L', $partOffset['offset']);
            $headerData .= $partOffsetData;
        }

        $headerLength = strlen($headerData);

        do{
            $tempFile = $this->storage . "temp". rand(100000,999999);
        } while(file_exists($tempFile));


        file_put_contents($tempFile,$headerData);

        $offset = 0;


        while($marker = file_get_contents($this->fullname , false, null, $offset, 4))
        {
            $blocksize = $this->long($marker);
            $blocksize += 8;

            $transitData = file_get_contents($this->fullname , false, null, $offset, $blocksize);
            $offset += $blocksize;
            $written = file_put_contents( $tempFile, $transitData, FILE_APPEND);
        }


        unlink($this->fullname);
        rename($tempFile, $this->fullname);
    }

    public function decryptFile($to)
    {
        $decryptedFilename = $to;

        if(file_exists($decryptedFilename))
            unlink($decryptedFilename);

        $sectionsCount = $this->get32Long(0);
        $headLength = ($sectionsCount + 1) * 4;

        for( $i = 0; $i < $sectionsCount; $i++ ) {

            $offset = ($i + 1) * 4;
            $sectionHeaderOffset = $this->get32Long($offset) + $headLength;
            $sectionLength = $this->get32Long($sectionHeaderOffset);
            $sectionOriginLength = $this->get32Long($sectionHeaderOffset + 4);;  // может использоваться для проверки
            $sectionOffset = $sectionHeaderOffset + 8;

            $section = file_get_contents($this->fullname, false, null, $sectionOffset, $sectionLength);

            $dectyptedSection = $this->decryptSection($section);

            if($sectionOriginLength != strlen($dectyptedSection)){
                $error = "не совпадают размеры исходных данных и расшифрованных!!!";
            }

            file_put_contents($decryptedFilename, $dectyptedSection, FILE_APPEND);
        }
    }

    private function decryptSection($section)
    {
        $out = '';

        $length = strlen($section);
        $offset = 0;

        while($offset < $length)
        {
            $blockLength = $this->long(substr($section, $offset, 4));
            $block = substr($section, $offset + 4, $blockLength);
            $encryptedBlock = Crypo::decrypt($block);
            $out .= $encryptedBlock;
            $offset += 4 + $blockLength;
        }

        return $out;
    }


    public static function createFrom($source, $dest)
    {
        $encryptedFile = new self($dest);

        $fileData = file_get_contents($source);
        $offset = 0;  $length = strlen($fileData);

        while($offset < $length)
        {
            $sectionData = substr($fileData, $offset, EncryptedFile::SECTION_SIZE);
            $encryptedFile->addSection($sectionData);
            $offset += EncryptedFile::SECTION_SIZE;
        }

        $encryptedFile->createFileHeader();

        return $encryptedFile;
    }
}