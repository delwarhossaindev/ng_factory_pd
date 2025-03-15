<?php 

namespace App\Helpers;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Export
{   
    /**
     * Summary of query
     * @var Builder
     */
    protected Builder $query;

    /**
     * Summary of data
     * @var array
     */
    protected array $data;

    /**
     * Summary of zipFileName
     * @var string
     */
    protected string $zipFileName;

    /**
     * Summary of fileName
     * @var string
     */
    protected string $fileName;

    /**
     * Summary of chunkSize
     * @var int
     */
    public int $chunkSize;

    /**
     * Summary of storage
     * @var Filesystem
     */
    protected Filesystem $storage;

    /**
     * Summary of oldFilesDueDays
     * @var int
     */
    protected int $oldFilesDueDays = 1;

    /**
     * Summary of headers
     * @var array
     */
    public array $headers;

    /**
     * Summary of file
     * @var mixed
     */
    protected mixed $file;
    
    /**
     * Summary of exportFromQuery
     * @param Builder|null $query
     * @return StreamedResponse
     */
    public function exportFromQuery(?Builder $query = null): StreamedResponse
    {
        $this->query = $query;
        throw_if(!$this->query, new \Exception('Query has not been set.'));
        throw_if(empty($this->headers), new \Exception('Headers cannot be empty.'));

        $this->setDefaults();

        $this->openFile();

        $this->query->chunk($this->chunkSize, fn ($records) => $this->putToCSV($records));

        return $this->getDownloadStream();
    }
    
    /**
     * Summary of exportFromArray
     * @param array|null $data
     * @return StreamedResponse
     */
    public function exportFromArray(?array $data = []): StreamedResponse
    {
        $this->data = $data;
        throw_if(empty($this->data), new \Exception('Data cannot be empty.'));
        throw_if(empty($this->headers), new \Exception('Headers cannot be empty.'));

        $this->setDefaults();

        $this->openFile();
      
        $this->putToCSV($this->data);

        return $this->getDownloadStream();
    }
    
    /**
     * Summary of putToCSV
     * @param mixed $iterableData
     * @return void
     */
    public function putToCSV($iterableData)
    {
        foreach ($iterableData as $row) {
            $toArray = json_decode(json_encode($row), true);
            $res     = [];
            foreach ($this->headers as $key => $value) {
                $res[$key] = data_get($toArray, $value);
            }
            $res = array_filter($res, fn ($item) => !is_array($item));
            
            fputcsv($this->file, $res);
        }
    }
    
    /**
     * Summary of getDownloadStream
     * @return StreamedResponse
     */
    public function getDownloadStream()
    {
        fclose($this->file);
        $this->deleteOldFiles();
        return $this->storage->download($this->file);
    }
    /**
     * Summary of deleteOldFiles
     * @return void
     */
    public function deleteOldFiles()
    {   
        foreach ($this->storage->allFiles() as $old_file) {
            if($old_file == session()->get('time').'.csv') continue;
            $this->storage->delete($old_file);
        }
    }
    
    /**
     * Summary of setDefaults
     * @return Export
     */
    public function setDefaults()
    {   
        session()->put('time',time());
        $this->fileName = session()->get('time') . '.csv';
        $this->chunkSize = 500;
        $this->storage = $this->storage ?? app('filesystem')->disk(config('filesystems.default'));

        return $this;
    }
    
    /**
     * Summary of openFile
     * @return bool|resource
     */
    public function openFile()
    {
        $this->file = fopen($this->storage->path("$this->fileName"), 'a+');
        fputcsv($this->file, $this->headers);
        return $this->file;
    }
    
    /**
     * Summary of setQuery
     * @param Builder $query
     * @return Export
     */
    public function setQuery(Builder $query)
    {
        $this->query = $query;
        return $this;
    }
    
    /**
     * Summary of setData
     * @param array $data
     * @return Export
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * Summary of setHeaders
     * @param array $headers
     * @return Export
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }
    
    /**
     * Summary of setChunkSize
     * @param int $chunkSize
     * @return Export
     */
    public function setChunkSize(int $chunkSize)
    {
        $this->chunkSize = $chunkSize;
        return $this;
    }
}