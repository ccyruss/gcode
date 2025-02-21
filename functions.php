<?php 

include 'library.php';


$g01_lines = [];

function code_matcher($val, $code) {
    $code = strpos($val, $code); 
}

$output = [];

function output($msg, $type) {
    
}

function program_name($val) {
    global $output;

    $code = "O";

    $program_full_name = code_matcher($val, $code);



    if($program_full_name !== false) {
        $output = '<div class="alert alert-success" role="alert">Program name is true.</div>';

        if (str_starts_with($val, 'O')) {
            $program_num = explode("O", $val);
            $char = isset($program_num[1]) ? strlen($program_num[1]) : 0;
        } else {
            $output .= '<div class="alert alert-danger" role="alert">The program name must start with `O`.</div>';
        }

        $val_char = strlen($val);
    
        if($char === 4) {
            if($val_char === 5) {
                $output .= '<div class="alert alert-success" role="alert">There is no problem. Program name is correct fully.</div>';
            }else {
                $output .=  '<div class="alert alert-danger" role="alert">The full name must be 5 characters long.</div>';
            }
        }else {
            $output .=  '<div class="alert alert-danger" role="alert">The name must be 4 characters long.</div>';
        }
    }else {
        $output .= '<div class="alert alert-danger" role="alert">Program name is false check it.</div>';
    }

}

function coord_to_svg($val) {
    // Reference point
    $startX = 0;
    $startZ = 0;
    $lines = "";

    // Lines for SVG
    $lines = "";
    foreach ($val as $line) {
        if (preg_match('/G01.*X([-+]?\d+\.?\d*).*Z([-+]?\d+\.?\d*)/', $line, $matches)) {
            $deltaX = isset($matches[1]) ? floatval(value: $matches[1]) : $startX;
            $deltaZ = isset($matches[2]) ? floatval(value: $matches[2]) : $startZ;

            $newX = $matches[1] !== "" ? $deltaX : $startX;
            $newZ = $matches[2] !== "" ? $deltaZ : $startZ;

            $lines .= "<line x1=\"$startZ\" y1=\"-$startX\" x2=\"$newZ\" y2=\"-$newX\" stroke=\"blue\" stroke-width=\"2\" />\n";

            $startX = $newX;
            $startZ = $newZ;
        }
    }

    return $lines;
}



$line_number = 0;
function check_codes($val) {

    global $output;
    global $g01_lines;
    global $g00_lines;


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



        $g1_lines = 0;
        $g0_lines = 0;


        foreach($lines as $line) {
            $g1_lines++;
            if(str_starts_with(trim($line), 'G01')) {
                $g01_lines[] = $line;
            }
        }

        foreach($lines as $line) {
            $g0_lines++;
            if(str_starts_with(trim($line), 'G00')) {
                $g00_lines[] = $line;
            }
        }
    }
    

    // Check starter codes
    if($is_there_g40 || $is_there_g80) {
        $output .= '<div class="alert alert-success" role="alert">G40 or G80 detected.</div>';
    }else {
        $output .= '<div class="alert alert-warning" role="alert">If you want can add G40 or G80 for security.</div>';
    }

    if($is_there_reference) {
        $output .= '<div class="alert alert-success" role="alert">Reference is detected.</div>';
    }else {
        $output .= '<div class="alert alert-warning" role="alert">Reference is not detected.</div>';
    }

    if($is_there_g96) {
        $output .= '<div class="alert alert-success" role="alert">G96 detected.</div>';
    }else {
        $output .= '<div class="alert alert-danger" role="alert">G96 not detected.</div>';
    }

    if($is_there_g50) {
        $output .= '<div class="alert alert-success" role="alert">G50 detected.</div>';
    }else {
        if($is_there_g97) {
            $output .= '<div class="alert alert-success" role="alert">G97 detected.</div>';
        }else {
            $output .= '<div class="alert alert-danger" role="alert">You must add G50 or G97.</div>';
        }
    }

    if($is_there_m3) {
        $output .= '<div class="alert alert-success" role="alert">There is no problem, M03 detected.</div>';
    }else {
        $output .= '<div class="alert alert-danger" role="alert">There is no M03, you need it.</div>';
    }

    if($is_there_t0) {
        $output .= '<div class="alert alert-success" role="alert">There is no problem, T0 detected</div>';
    }else {
        $output .= '<div class="alert alert-danger" role="alert">There is no T0 you need it</div>';
    }

}




?>