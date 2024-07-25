<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\Alternative;

class DashboardController extends Controller
{
    public function index()
    {
        $criterias = Criteria::select('id', 'name', 'type', 'weight')->get();
        $alternatives = Alternative::select('id', 'name', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10')->get();

        // $results didapatkan dari perhitungan pada function moora
        $results = $this->moora($criterias, $alternatives);

        return view('dashboard', compact('criterias', 'alternatives', 'results'));
    }

    public function moora($criterias, $alternatives) {
        // mengambil nilai alternative dan disimpan dalam $temp
        $temp = $this->get_alternatives($alternatives);

        // menghitung kuadrat setiap value
        foreach ($temp as $t) {
            $t->c1 = $t->c1 ** 2;
            $t->c2 = $t->c2 ** 2;
            $t->c3 = $t->c3 ** 2;
            $t->c4 = $t->c4 ** 2;
            $t->c5 = $t->c5 ** 2;
            $t->c6 = $t->c6 ** 2;
            $t->c7 = $t->c7 ** 2;
            $t->c8 = $t->c8 ** 2;
            $t->c9 = $t->c9 ** 2;
            $t->c10 = $t->c10 ** 2;
        }

        // menambahkan setiap value pada alternative berdasarkan criteria
        $c = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($temp as $t) {
            $c[1] += $t->c1;
            $c[2] += $t->c2;
            $c[3] += $t->c3;
            $c[4] += $t->c4;
            $c[5] += $t->c5;
            $c[6] += $t->c6;
            $c[7] += $t->c7;
            $c[8] += $t->c8;
            $c[9] += $t->c9;
            $c[10] += $t->c10;
        }

        // hasil penjumlahan nilai setiap value criteria pada alternative selanjutnya akan di akar kan
        for ($i = 1; $i <= 10; $i++) {
            $c[$i] = sqrt($c[$i]);
        }

        // mengambil nilai alternative dan disimpan dalam $temp2 untuk mendapatkan value asli setiap alternative
        $temp2 = $this->get_alternatives($alternatives);

        // menghitung normalisasi
        foreach ($temp2 as $t) {
            $t->c1 = ($t->c1 / $c[1]) * $criterias[0]->weight;
            $t->c2 = ($t->c2 / $c[2]) * $criterias[1]->weight;
            $t->c3 = ($t->c3 / $c[3]) * $criterias[2]->weight;
            $t->c4 = ($t->c4 / $c[4]) * $criterias[3]->weight;
            $t->c5 = ($t->c5 / $c[5]) * $criterias[4]->weight;
            $t->c6 = ($t->c6 / $c[6]) * $criterias[5]->weight;
            $t->c7 = ($t->c7 / $c[7]) * $criterias[6]->weight;
            $t->c8 = ($t->c8 / $c[8]) * $criterias[7]->weight;
            $t->c9 = ($t->c9 / $c[9]) * $criterias[8]->weight;
            $t->c10 = ($t->c10 / $c[10]) * $criterias[9]->weight;
        }

        // menghitung hasil skor akhir penilaian moora
        $results = [];
        foreach ($temp2 as $t) {
            if ($criterias[0]->type == 'Cost') {
                $t->c1 = $t->c1 * -1;
            }
            if ($criterias[1]->type == 'Cost') {
                $t->c2 = $t->c2 * -1;
            }
            if ($criterias[2]->type == 'Cost') {
                $t->c3 = $t->c3 * -1;
            }
            if ($criterias[3]->type == 'Cost') {
                $t->c3 = $t->c3 * -1;
            }
            if ($criterias[3]->type == 'Cost') {
                $t->c4 = $t->c4 * -1;
            }
            if ($criterias[4]->type == 'Cost') {
                $t->c5 = $t->c5 * -1;
            }
            if ($criterias[5]->type == 'Cost') {
                $t->c6 = $t->c6 * -1;
            }
            if ($criterias[6]->type == 'Cost') {
                $t->c7 = $t->c7 * -1;
            }
            if ($criterias[7]->type == 'Cost') {
                $t->c8 = $t->c8 * -1;
            }
            if ($criterias[8]->type == 'Cost') {
                $t->c9 = $t->c9 * -1;
            }
            if ($criterias[9]->type == 'Cost') {
                $t->c10 = $t->c10 * -1;
            }
            $results[] = [
                'name' => $t->name,
                'y' => $t->c1 + $t->c2 + $t->c3 + $t->c4 + $t->c5 + $t->c6 + $t->c7 + $t->c8 + $t->c9 + $t->c10
            ];
        }
        
        // mengurutkan skor akhir berdasarkan nilai y
        usort($results, function($a, $b) {
            return $b['y'] <=> $a['y'];
        });
    
        return $results;
    }

    public function get_alternatives($alternatives) {
        $temp = [];
        foreach ($alternatives as $alternative) {
            $temp[] = clone $alternative;
        }
        return $temp;
    }
    
}
