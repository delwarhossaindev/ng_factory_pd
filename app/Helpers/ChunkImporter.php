<?php

namespace App\Helpers;

use App\Models\User;

class ChunkImporter
{
    /**
     * Summery of importByChunkingData
     *
     * @param [type] $model
     * @param string $updateKey
     * @param [type] $file
     * @param integer $chunkNumber
     * @return bool
     */
    public function importByChunkingData(
        $model,
        string $updateKey,
        $file,
        int $chunkNumber = 100
    ) {
        !is_dir(storage_path('temp')) ?
            mkdir(storage_path('temp')) : true;

        $csv    = file($file);
        $chunks = array_chunk($csv, $chunkNumber);
        $path   = storage_path('temp');

        foreach ($chunks as $key => $chunk) {
            $name = "/tmp{$key}.csv";
            file_put_contents($path . $name, $chunk);
        }

        $files = glob("$path/*.csv");
        $header = [];

        foreach ($files as $key => $file) {
            $data = array_map('str_getcsv', file($file));
            if ($key == 0) {
                $header = $data[0];
                unset($data[0]);
            }

            foreach ($data as $key => $value) {
                $modelData = array_combine($header, $value);
                if ($this->checkExistingDataResponse(
                    $model,
                    $modelData,
                    $updateKey
                )) {
                    $model::where(
                        $updateKey,
                        $modelData[$updateKey]
                    )->update([$header[$key] => $value[$key]]);
                    continue;
                }
                $model::create($modelData);
            }
            unlink($file);
        }

        return true;
    }

    public function checkExistingDataResponse(
        $model,
        $modelData,
        $updateKey
    ): bool {
        return $model::where(
            $updateKey,
            $modelData[$updateKey]
        )->exists();
    }
}
