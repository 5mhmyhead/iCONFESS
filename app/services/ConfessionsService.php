<?php
    class ConfessionsService
    {
        private Confession $confessionModel;

        public function __construct()
        {
            $this -> confessionModel = new Confession();
        }

        public function getConfessions(): array
        {
            $confessions = $this -> confessionModel -> getAllConfessions();

            return $confessions;
        }
    }
?>