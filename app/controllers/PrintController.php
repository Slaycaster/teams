<?php
class PrintController extends \BaseController 
{
    public function index()
    {
        $pdf = PDF::loadView('empbyhierarchy');
        return $pdf->stream();
        
    }
}