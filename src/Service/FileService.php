<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class FileService
{

    public function createCsvFile($list){

        $fp = fopen('php://output', 'w');

        foreach ($list as $fields) {
            $line = $fields["name"].",".$fields['email'].",".$fields['startTime']->format('Y-m-d H:i:s').",".$fields['endTime']->format('Y-m-d H:i:s');
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