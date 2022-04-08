<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class FileService
{

    public function createCsvFile($list){

        $fp = fopen('php://output', 'w');

        foreach ($list as $fields) {
            $line = $fields[0]->getStartTime()->format('Y-m-d H:i:s').",".$fields[0]->getEndTime()->format('Y-m-d H:i:s').",".$fields['email'];
            $linesArray = explode(",", $line);
            fputcsv($fp, $linesArray);
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="testing.csv"');
        return $response;

    }

    public function extractData(){

    }
}