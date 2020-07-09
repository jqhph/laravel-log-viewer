<?php

namespace Dcat\LogViewer;

use Illuminate\Support\Str;

class LogController
{
    public function index($file = null)
    {
        $dir = trim(request('dir'));
        $filename = trim(request('filename'));
        $offset = request('offset');
        $keyword = trim(request('keyword'));
        $lines = $keyword ? (config('dcat-log-viewer.search_page_items') ?: 500) : (config('dcat-log-viewer.page_items') ?: 30);

        $viewer = new LogViewer($this->getDirectory(), $dir, $file);

        $viewer->setKeyword($keyword);
        $viewer->setFilename($filename);

        return view('dcat-log-viewer::log', [
            'dir'       => $dir,
            'logs'      => $viewer->fetch($offset, $lines),
            'logFiles'  => $this->formatLogFiles($viewer, $dir),
            'logDirs'   => $viewer->getLogDirectories(),
            'fileName'  => $viewer->file,
            'end'       => $viewer->getFilesize(),
            'prevUrl'   => $viewer->getPrevPageUrl(),
            'nextUrl'   => $viewer->getNextPageUrl(),
            'filePath'  => $viewer->getFilePath(),
            'size'      => static::bytesToHuman($viewer->getFilesize()),
        ]);
    }

    public function download($file = null)
    {
        $viewer = new LogViewer($this->getDirectory(), request('dir'), $file);

        return response()->download($viewer->getFilePath());
    }

    protected function getDirectory()
    {
        return config('dcat-log-viewer.directory') ?: storage_path('logs');
    }

    protected function formatLogFiles(LogViewer $logViewer, $currentDir)
    {
        return array_map(function ($value) use ($logViewer, $currentDir) {
            $file = $value;
            $dir = $currentDir;

            if (Str::contains($value, '/')) {
                $array = explode('/', $value);
                $file = end($array);

                array_pop($array);
                $dir = implode('/', $array);
            }

            return [
                'file' => $value,
                'url' => route('dcat-log-viewer.file', ['file' => $file, 'dir' => $dir]),
                'active' => $logViewer->isCurrentFile($value),
            ];
        }, $logViewer->getLogFiles());
    }

    protected static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
