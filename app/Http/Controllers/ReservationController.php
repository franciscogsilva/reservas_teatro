<?php

namespace App\Http\Controllers;

use App\Chair;
use App\Reservation;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return view('front.reservations.index')
            ->with('reservations', $reservations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chairs = Chair::orderBy('id', 'ASC')->get();
        if($chairs->count()<=0){
            $chairs = setChairs();
        }

        return view('front.reservations.create')
            ->with('chairs', $chairs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));

        if(count($request->selectedChairs) != $request->numPersons){            
            $errors = collect(['El númerro de sillas seleccionadas y el número de personas no son iguales.']);
            return back()
                ->withInput()
                ->with('errors', $errors);
        }

        $reservation = new Reservation();
        $this->setReservation($reservation, $request);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('session_msg', 'Se ha creado correctamente la reserva.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){        
        try {
            $reservation = Reservation::findOrFail($id);            
        }catch (ModelNotFoundException $e){
            $errors = collect(['La Reserva con ID '.$id.' no se encuentra.']);
            return back()
                ->withInput()
                ->with('errors', $errors);
        }

        return view('front.reservations.show')
            ->with('reservation', $reservation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));

        if($request->selectedChairs->count() != $request->numPersons){            
            $errors = collect(['El númerro de sillas seleccionadas y el número de personas no son iguales.']);
            return back()
                ->withInput()
                ->with('errors', $errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function setReservation($reservation, $request){
        $reservation->num_persons = $request->numPersons;
        $reservation->user_id = Auth::user()->id;
        $reservation->save();

        if($reservation->chairs->count()>0){
            foreach ($reservation->chairs as $chair){
                if(!in_array($chair->id, $request->selectedChairs)){
                    $chair->reservation_id = null;
                    $chair->save();
                }
            }
        }

        foreach($request->selectedChairs as $selected){
            $chair = Chair::where('id', $selected)->first();
            $chair->reservation_id = $reservation->id;
            $chair->save();
            
        }

        return $reservation->save();
    }

    private function getValidationRules($request){
        return [
            'numPersons' => 'required',
            'selectedChairs' => 'required'
        ];
    }

    private function getValidationMessages($request){
        return [
                'numPersons.required' => 'El número de personas es requerido.',
                'selectedChairs.required' => 'Las sillas seleccionadas son requeridas.'
            ];
    }
}
