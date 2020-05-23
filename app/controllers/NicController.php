<?php 

                class NicController extends Controller{

                    public $ass_code = 'nic';

                    public function __construct() {
                        parent::__construct();
                        allowPageAccessByUser(['test_taker']);
                    }

                }