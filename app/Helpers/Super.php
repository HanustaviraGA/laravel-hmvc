<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\DataTables;
use GuzzleHttp\Client;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Image;

/**
 * Display a table based on given module or query.
 * @return Renderable
 */
function select_table($queryOrModel)
{
    if (is_string($queryOrModel)) {
        // Execute the raw SQL query and convert the result to a collection
        $results = DB::select($queryOrModel);
        $results = collect($results)->map(function ($item, $key) {
            $item->id = $key + 1; // Add auto-increment ID
            return $item;
        });
        $query = $results;
    } elseif ($queryOrModel instanceof \Illuminate\Database\Eloquent\Model) {
        $query = $queryOrModel->newQuery();
    } elseif ($queryOrModel instanceof \Illuminate\Database\Eloquent\Builder) {
        $query = $queryOrModel;
    } elseif ($queryOrModel instanceof \Illuminate\Support\Collection) {
        if ($queryOrModel->isEmpty()) {
            return DataTables::of($queryOrModel)->make(true);
        }
        // Assuming all items in the collection are instances of the same model
        $model = $queryOrModel->first();
        $query = $model->newQuery()->whereIn($model->getKeyName(), $queryOrModel->pluck($model->getKeyName()));
    } else {
        throw new \InvalidArgumentException('Invalid query or model provided.');
    }

    return DataTables::of($query)
        ->addColumn('no', function ($data) {
            static $count = 1; // Initialize a static counter variable

            // Determine the primary key value
            $primaryKeyValue = null;
            if (method_exists($data, 'getKey')) {
                $primaryKeyValue = $data->getKey();
            } else if (property_exists($data, 'id')) {
                $primaryKeyValue = $data->id;
            }
            $primaryKeyValueEncoded = base64_encode(json_encode($primaryKeyValue));

            return '<td><span style="margin-left: 20px !important;">' . $count++ . '.</span><input type="checkbox" name="checkbox" data-record="' . $primaryKeyValueEncoded . '" style="display: none;"></td>';
        })
        ->rawColumns(['no']) // Include the new 'no' column in rawColumns
        ->make(true);
}

function imageUploader($data = []){
    // Attributes
    $file = $data['file'];
    if(isset($data['base64']) && $data['base64'] == TRUE){
        $img = ImageManager::gd()->read($file, [
            DataUriImageDecoder::class,
            Base64ImageDecoder::class,
        ]);
    }else{
        $img = ImageManager::gd()->read($file);
    }
    $setimg = md5(base64_encode(rand(0, 100).generateCode())).'.jpg';
    if(isset($data['filename']) && $data['filename'] !== ''){
        $setimg = $data['filename'].'.jpg';
    }
    // Save the original
    $ori = $img;
    if(isset($data['to_base64']) && $data['to_base64'] == TRUE){
        $stat = $ori->toJpeg(50)->toDataUri();
    }else{
        $stat = true;
        if(isset($data['filepath']) && $data['filepath'] !== ''){
            $stat = $ori->toJpeg(50)->save($data['filepath'].$setimg);
        }else{
            $ori->toJpeg(50)->save(public_path('uploads/').$setimg);
        }
    }
    return [
        'filename' => $setimg,
        'status' => $stat
    ];
}

/**
 * Display an encoded view of a page.
 * @return Renderable
 */
function loadPage($page, $data = []){
    $view = view($page, $data)->render(); // Render the view as a string
    $base64 = base64_encode($view); // Encode the view as base64
    return response()->json(['page' => $base64]);
}

/**
 * Generate unique code.
 */
function generateCode() {
    $prefix = 'MRP';
    $date = date('ymd');
    $suffix = generateSuffix();
    return $prefix . '.' . $date . '.' . $suffix;
}

/**
 * Generate unique suffix.
 */
function generateSuffix() {
    $suffix = '';
    $length = 5; // Desired length of the suffix (5 characters)

    while (strlen($suffix) < $length) {
        $randType = rand(0, 2); // Randomly choose 0 for letter, 1 for number, 2 for alphanumeric

        if ($randType === 0) {
            $suffix .= chr(rand(65, 90)); // Random letter from A to Z
        } elseif ($randType === 1) {
            $suffix .= rand(0, 9); // Random number from 0 to 9
        } else {
            $suffix .= chr(rand(65, 90)) . rand(0, 9); // Random alphanumeric combination
        }
    }

    // Trim or pad the suffix to ensure it has exactly 5 characters
    $suffix = substr($suffix, 0, $length);

    return $suffix;
}

/**
 * Unix Epoch Conversion.
 */
function ts_conv($ts){
    $timestamp_sec = $ts / 1000;
    $date = date("Y-m-d H:i:s", $timestamp_sec);
    return $date;
}

/**
 * Create a PDF based on HTML given.
 * @return Renderable
 */
function viewPDF($data, $config) {
    $pdf = \PDF::loadView('production.pdf', $data, [], $config);
    $pdf->save($config['filepath']);
}

function dateformat($tgl) {
    try {
        if ($tgl != null && $tgl != "" && $tgl != "0000-00-00") {
            // Create a DateTime object
            $date = new DateTime($tgl);

            // Get day name in Indonesian
            $day_names = array(
                "Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu",
                "Thursday" => "Kamis", "Friday" => "Jumat", "Saturday" => "Sabtu",
                "Sunday" => "Minggu"
            );
            $day_name = $day_names[$date->format('l')];

            // Get month name in Indonesian
            $month_names = array(
                "", "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            );
            $month_name = $month_names[intval($date->format('m'))];

            // Format date
            $tanggal = $date->format('d');
            $tahun = $date->format('Y');

            return $day_name . ", " . $tanggal . " " . $month_name . " " . $tahun;
        }
    } catch (Exception $e) {
        // Handle invalid date format
        return "Senin, 0 Januari 2024"; // Default date value
    }
    return ""; // Return an empty string if the input date is invalid
}

function truncateDescription($description, $maxLength = 65) {
    if (strlen($description) > $maxLength) {
        return substr($description, 0, $maxLength) . '...';
    }
    return $description;
}

function sanitizeTitle($title){
    $sanitized = rtrim(strtolower(str_replace(" ", "-", preg_replace("/[^a-zA-Z0-9\s]/", "", $title))));
    return $sanitized;
}
