<?php 

include 'library.php';

function code_matcher($val, $code) {
    $code = strpos($val, $code); 
}

$output = "";
function program_name($val) {
    global $output;

    $code = "O";

    $program_full_name = code_matcher($val, $code);



    if($program_full_name !== false) {
        $output .= "Program name is true.<br>";

        if (str_starts_with($val, 'O')) {
            $program_num = explode("O", $val);
            $char = isset($program_num[1]) ? strlen($program_num[1]) : 0;
        } else {
            $output .= "The program name must start with 'O'.<br>";
        }

        $val_char = strlen($val);
    
        if($char === 4) {
            if($val_char === 5) {
                $output .= "There is no problem. Program name is correct fully.<br>";
            }else {
                $output .=  "The full name must be 5 characters long<br>";
            }
        }else {
            $output .=  "The name must be 4 characters long<br>";
        }
    }else {
        $output .= "Program name is false check it!<br>";
    }

}

$line_number = 0;
function check_codes($val) {

    global $output;

    if (!is_array($val)) {
        $val = [$val]; 
    }

    foreach($val as $code) {

        // Here is starter codes
        $starter_codes = explode('G01', $code)[0];

        $is_there_m3 = str_contains($starter_codes, "M03");
        $is_there_t0 = str_contains($starter_codes, "T0");
        $is_there_g40 = str_contains($starter_codes, "G40");
        $is_there_g50 = str_contains($starter_codes, "G50");

        $g_ref = ['G54', 'G55', 'G56', 'G57', 'G58', 'G58', 'G59'];

        $is_there_reference = false;

        foreach($g_ref as $ref) {
            $is_there_reference = str_contains($starter_codes, $ref);
            $is_there_reference = true;
            break;
        }

        $is_there_g80 = str_contains($starter_codes, "G80");
        $is_there_g96 = str_contains($starter_codes, "G96");
        $is_there_g97 = str_contains($starter_codes, "G97");

        // Here is main codes
        $lines = preg_split("/\r\n|\r|\n/", $code);
        $g01_lines = [];
        $g00_lines = [];


        $g1_lines = 0;
        $g0_lines = 0;


        foreach($lines as $line) {
            $g1_lines++;
            if(str_starts_with(trim($line), 'G01')) {
                $g01_lines[] = $line . $g1_lines;
            }
        }

        foreach($lines as $line) {
            $g0_lines++;
            if(str_starts_with(trim($line), 'G00')) {
                $g00_lines[] = $line . $g0_lines;
            }
        }

        echo implode("\n", $g01_lines);
        echo implode("\n", $g00_lines);
    }

    // Check starter codes
    if($is_there_g40 || $is_there_g80) {
        $output .= "G40 or G80 detected.<br>";
    }else {
        $output .= "If you want can add G40 or G80 for security.<br>";
    }

    if($is_there_reference) {
        $output .= "Reference is detected.<br>";
    }else {
        $output .= "Reference is not detected.<br>";
    }

    if($is_there_g96) {
        $output .= "G96 detected.<br>";
    }else {
        $output .= "G96 not detected.<br>";
    }

    if($is_there_g50) {
        $output .= "G50 detected.<br>";
    }else {
        if($is_there_g97) {
            $output .= "G97 detected.<br>";
        }else {
            $output .= "You must add G50 or G97<br>";
        }
    }

    if($is_there_m3) {
        $output .= "There is no problem. M03 detected.<br>";
    }else {
        $output .= "There is no M03. You need it.<br>";
    }

    if($is_there_t0) {
        $output .= "There is no problem. T0 detected.<br>";
    }else {
        $output .= "There is no T0. You need it.<br>";
    }

    

echo $output . "<br>";

}



?>