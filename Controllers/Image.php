<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;


class Image extends BaseController
{
    public function index()
    {
        helper('form');
        return view('formUpload');
    }

    public function upload()
    {
        $file = $this->request->getFile('file');
        $this->validateImage($file);

        $store = $file->store('png');
        $this->convert($store);
    }

    public function download()
    {
        return $this->response->download(WRITEPATH . 'uploads/jpg/' . $this->request->uri->getSegments()[2],null);
    }

    private function convert($store)
    {
        $extentionNew = ".JPEG";
        $jpgFile = WRITEPATH . 'uploads/' . $store;
        $convert = Services::image()
            ->withFile($jpgFile)
            ->convert(IMAGETYPE_PNG)
            ->save(WRITEPATH . 'uploads/jpg/' . str_replace(["png/", ".PNG", ".png"], '', $store) . $extentionNew);

        if ($convert) {
            echo json_encode([
                'success' => true,
                'message' => str_replace(["png/", ".PNG", ".png"], '', $store) . $extentionNew
            ]);
        } else {
            @unlink($jpgFile);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to convert'
            ]);
        }
    }

    private function validateImage($file)
    {

        if (!$file->isValid()) {
            echo json_encode([
                'success' => false,
                'message' => $file->getErrorString() . '(' . $file->getError() . ')'
            ]);
            // throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')' . PHP_EOL);
        }

        if (!in_array($file->getClientMimeType(), ['image/png', 'image/PNG'])) {
            echo json_encode([
                'success' => false,
                'message' => 'File Type Must Be PNG'
            ]);
            // throw new \RuntimeException('File Type Must Be PNG' . PHP_EOL);
        }
    }
}
