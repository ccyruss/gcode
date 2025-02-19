<?php 

    // Check it, is there a any request.
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // Take all values
        $g_codes = $_POST['gcode'];

        // Explode the taken values.
        $codes = explode(";", $g_codes);

        // List of taken values.
        foreach($codes as $code) {
            // These will checking by function here.
            echo $code . "<br>";

            // The functions will give all result to us.   
        }
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
                    <textarea id="gcode" name="gcode" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Encoder</button>
            </form>
        </div>
    
        <div class="mt-4">
            <?php
            
            ?>
        </div>
    </div>


    <footer class="text-center ">
        <p>Developed by <a href="#">Cahit Çelebi</a></p>
    </footer>
    
    </body>
</html>