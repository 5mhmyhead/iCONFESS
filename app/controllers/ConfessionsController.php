<?php
    class ConfessionsController extends Controller
    {
        private ConfessionsService $confessionsService;

        public function __construct()
        {
            $this -> layout = 'index';
            $this -> confessionsService = new ConfessionsService();
        }

        public function index()
        {
            $confessions = $this -> confessionsService -> getConfessions();

            $this -> view('confessions/index', [
                'confessions' => $confessions
            ]);
        }
    }
?>