<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function getReservations() {
        $array = ['error' => '', 'list' => []];
        $daysHelper = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

        $areas = Area::where('allowed', 1)->get();

        foreach ($areas as $area) {
            $dayList = explode(',', $area['days']);

            $dayGroups = [];

            // Adicionando o primeiro dia
            $lastDay = intval(current($dayList));
            $dayGroups[] = $daysHelper[$lastDay];
            array_shift($dayList);

            // Adicionando dias relevantes
            foreach ($dayList as $day) {
                if(intval($day) != $lastDay+1) {
                    $dayGroups[] = $daysHelper[$lastDay];
                    $dayGroups[] = $daysHelper[$day];
                }
                $lastDay = intval($day);
            }

            // Adicionando o ultimo dia
            $dayGroups[] = $daysHelper[end($dayList)];

            // Juntando as datas (Dia1-Dia2)
            $dates = '';
            $close = 0;
            foreach ($dayGroups as $group) {
                if($close === 0) {
                    $dates .= $group;
                } else {
                    $dates .= '-'.$group.',';
                }
                $close = 1 - $close;
            }

            $dates = explode(',', $dates);
            array_pop($dates);

            // Adicionando time
            $start = date('H:i', strtotime($area['start_time']));
            $end = date('H:i', strtotime($area['end_time']));

            foreach ($dates as $dKey => $dValue) {
                $dates[$dKey] .= ' '.$start.' às '.$end;
            }

            $array['list'][] = [
                'id' => $area['id'],
                'cover' => asset('storage/'.$area['cover']),
                'title' => $area['title'],
                'dates' => $dates
            ];
        }

        return $array;
    }

    public function setReservation($id, Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i:s',
            'property' => 'required'
        ]);
        if(!$validator->fails()) {

            $date = $request->input('date');
            $time = $request->input('time');
            $property = $request->input('property');

            $unit = Unit::find($property);
            $area = Area::find($id);

            if($unit && $area) {
                $can = true;

                $weekday = date('w', strtotime($date));

                // Verificar se esta dentro da disponibilidade padrão
                $allowedDays = explode(',', $area['days']);
                if(!in_array($weekday, $allowedDays)) {
                    $can = false;
                }

                // Verificar se esta dentro dos disabled days

                // Verificar se não outra reserva no mesmo dia/hora

                if($can) {

                } else {
                    $array['error'] = 'Reserva não permitida neste dia/horário';
                    return $array;
                }
            } else {
                $array['error'] = 'Dados incorretos';
                return $array;
            }

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }
}
