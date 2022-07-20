<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\Color;
use App\Models\Monitoring;

class ContentController extends Controller
{
    public function peta()
    {
        $ijo    = Color::where('color', '#00FF00')->count();
        $merah  = Color::where('color', '#FF0000')->count();
        $coklat = Color::where('color', '#FFB300')->count();
        $kuning = Color::where('color', '#FFFF00')->count();
        $putih  = Color::where('color', '#FFFFFF')->count();

        return view('peta', compact('ijo','merah','coklat', 'kuning', 'putih'));
    }

    public function petaUpload(Request $request) 
    {
        // return request()->file('upload_file')->store('tmp');
        Storage::deleteDirectory('tmp');

        $path = storage_path() . '/app/' . request()->file('upload_file')->store('tmp');

        $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet       = $spreadsheet->getSheetByName("Peta");

        if (empty($sheet)) {
            return redirect()->back()->with('message_error', "Tidak ada sheet dengan nama Peta");
        }

        $totalRow = $sheet->getHighestRow();
        $startRow = 2;

        $resultId = [];
        for ($row = $startRow; $row <= $totalRow; $row++) { 
            $code   = $sheet->getCell("A" .$row)->getValue();
            $color  = $sheet->getCell("B" .$row)->getValue();

            if (!empty($code)) {
                $data = Color::create([
                    'code'   => $code,
                    'color'  => $color,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Berhasil import data');
    }

    public function petaDelete()
    {
        Color::truncate();

        return redirect()->back()->with('message', 'Berhasil delete data');
    }

    public function monitoring()
    {
        $tanggal  = Monitoring::get()->pluck('tanggal')->toArray();
        $actual   = Monitoring::get()->pluck('actual')->toArray();
        $target   = Monitoring::get()->pluck('target');
        $bbc      = Monitoring::get()->pluck('bbc');
        $average_actual = Monitoring::get()->pluck('average_actual');

        // return $average_actual;
        return view('monitoring', compact('tanggal','actual','target', 'bbc', 'average_actual'));
    }

    public function monitoringUpload(Request $request) 
    {
        // return request()->file('upload_file')->store('tmp');
        Storage::deleteDirectory('tmp');

        $path = storage_path() . '/app/' . request()->file('upload_file')->store('tmp');

        $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet       = $spreadsheet->getSheetByName("monitoring panen harian");

        if (empty($sheet)) {
            return redirect()->back()->with('message_error', "Tidak ada sheet dengan nama monitoring panen harian");
        }

        $totalRow = $sheet->getHighestRow();
        $startRow = 2;

        $resultId = [];
        for ($row = $startRow; $row <= $totalRow; $row++) { 
            $code_ba        = $sheet->getCell("A" .$row)->getValue();
            $tanggal        = $sheet->getCell("B" .$row)->getValue();
            $actual         = !empty($sheet->getCell("C" .$row)->getValue()) ? $this->replace($sheet->getCell("C" .$row)->getValue()) : 0;
            $target         = $this->replace($sheet->getCell("D" .$row)->getValue());
            $bbc            = $this->replace($sheet->getCell("E" .$row)->getValue());
            $average_actual = $this->replace($sheet->getCell("F" .$row)->getValue());

            if (!empty($code_ba)) {
                $data = Monitoring::create([
                    'code_ba'   => $code_ba,
                    'tanggal'   => $tanggal,
                    'actual'    => $actual,
                    'target'    => $target,
                    'bbc'       => $bbc,
                    'average_actual' => $average_actual,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Berhasil import data');
    }

    public function monitoringDelete()
    {
        Monitoring::truncate();

        return redirect()->back()->with('message', 'Berhasil delete data');
    }

    public function replace($char)
    {
        return str_replace(',', '.', $char);
    }

    public function replaceSpecialChar($char)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $char);
    }

    public function readDateExcel($date)
    {
        if (!empty($date)) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($date);
            return date('Y-m-d', $date);
        } else {
            return $date;
        }
    }
}
