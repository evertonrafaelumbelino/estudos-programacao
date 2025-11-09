<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BandController extends Controller
{
    public function getAll() {
        $bands = $this->getBands();

        return response()->json([$bands]);
    }

    public function getById($id) {
        $band = null;

        foreach($this->getBands() as $_band) {
            if ($_band['id'] == $id) {
                $band = $_band;
            }
        }

        return $band ? response()->json($band) : abort(code: 404);
    }

    public function getBandsByGender($gender) {
        $bands = [];

        foreach($this->getBands() as $_band) {
            if ($_band['gender'] == $gender) {
                $bands[] = $_band;
            }
        }

        return response()->json($bands);
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'id' => 'numeric',
                'name' => 'required|min:3'
            ]);

            return response()->json(['data' => $request->all()]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

    }

    protected function getBands() {
        return [
            [
                'id' => 1, 'name' => 'dream teather', 'gender' => 'progressivo'
            ],
            [
                'id' => 2, 'name' => 'mega tech', 'gender' => 'trash metal'
            ],
            [
                'id' => 3, 'name' => 'dio', 'gender' => 'heavy metal'
            ],
            [
                'id' => 4, 'name' => 'metallica', 'gender' => 'heavy metal'
            ],
            [
                'id' => 5, 'name' => 'barões da pisadinha', 'gender' => 'tecno forrô'
            ]
            ];
    }
}
