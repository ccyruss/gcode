<?php 
    require_once('functions.php');

    // Check it, is there a any request.
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // Take all values
        $g_codes = $_POST['gcode'];

        // Explode the taken values.
        $codes = explode(";", $g_codes);

        // Check the program name.
        program_name($codes[0]);

        check_codes($g_codes);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>GCode</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h1 class="text-center mb-4">G Code Encoder</h1>
    
        <div class="card p-4">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="gcode" class="form-label">Enter G Codes:</label>
                    <textarea id="gcode" name="gcode" class="form-control" rows="10" required>
O1234;
G54 G40 G80;
M03;
T0101;
G96 S400 F0.1;
G97 S1200;
G01 X0 Z0;
G01 X50 Z0;
G01 X50 Z-50;
G01 X80 Z-50;
G01 X80 Z-200;

                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Encoder</button>
            </form>
        </div>

        <div class="outout">
            
            <?php

            echo $output;

            
            // $clean_output = trim($output);
            // $outputs = explode(".", $clean_output);

            // foreach($outputs as $out) {
            //     echo '<div class="alert alert-danger" role="alert">';
            //     echo trim($out);
            //     echo '</div>';
            // }
            
            ?>
        </div>

        <div class="svg-container" style="margin-top:3rem;height: 600px; width: 100%; display: flex; justify-content: center; align-items: center; background-color: #f8f8f8; overflow: hidden;">
            <svg viewBox="-500 -500 1000 1000" preserveAspectRatio="xMidYMid meet" style="width: 100%; height: 100%; max-width: 1000px; max-height: 1000px; border: 1px solid #ccc;">
                <line style="opacity:0.4;" x1="-500" y1="0" x2="500" y2="0" stroke="black" stroke-width="2"/> 
                <line style="opacity:0.4;" x1="0" y1="-500" x2="0" y2="500" stroke="black" stroke-width="2"/> 

                <circle cx="0" cy="0" r="5" fill="red"/>
                <?php 
                
                 echo coord_to_svg($g01_lines);
                
                ?>
            </svg>
        </div>
    
        <div class="mt-4">
            <?php
            
            ?>
        </div>
    </div>


    <footer class="text-center">
        <p>Developed by <a target="_blank" href="https://www.linkedin.com/in/cahitc/">Cahit Celebi</a></p>
        <p class="small">Open Source <a target="_blank" href="https://github.com/ccyruss/gcode">Project</a>.</p>
    </footer>
    
    </body>
</html>