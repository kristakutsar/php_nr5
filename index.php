<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Kodutöö nr5</title>
</head>
<style>
    .bg-light-pink-radial-gradient {
      background: radial-gradient(circle, #ffe4e1, #ffcccb);
    }
    .custom-btn {
      background-color: red;
      border-color: red;
      color: white;
    }

  </style>
</head>
<body>
        <div class="jumbotron jumbotron-fluid bg-light-pink-radial-gradient p-5">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <a class="navbar-brand " href="#">Sinunimi.com</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Avaleht</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="tooted.php">Tooted</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="kontakt.php">Kontakt</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin.php">Admin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                       <div class="row mt-4">
                    <div class="col-md-6 d-flex flex-column align-items-center">
                        <?php
                            $pakkumised = array("SUPER ALE", "ALLAHINDLUS","HINNAD ALL");
                            $tekst = $pakkumised[array_rand($pakkumised)];
                        ?>
                        <h1 class="text-start text-dark"><?php echo $tekst; ?></h1>
                        <h2 class="text-start text-dark">-20% kõik tooted!</h2>
                        <p class="text-start text-dark">Kasuta ilma taustata pilti ja kindlasti võta kasutusele BS5.
                        </p>
                        <button class="btn custom-btn rounded-pill d-inline-flex align-items-center" type="button">
                         Vaata pakkumisi -> </button>
                    </div>
                    <div class="col-md-6 ">
                        <?php
                            $pilt = array("pilt2.png", "avaleht.png");
                            $pildid = $pilt[array_rand($pilt)];
                        ?>
                        <img src="<?php echo $pildid; ?>" height="300" alt="Image 1">
                    </div>
                </div>
            </div>
        </div>
        <h1 class="text-center fs-4 mt-4 mb-5">Parimad pakkumised</h1>
        <div class="container" style="max-width: 800px; margin: 0 auto;">
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php
$tooted = "tooted.csv";

if (file_exists($tooted) && ($minu_csv = fopen($tooted, "r")) !== FALSE) {
    while (($rida = fgetcsv($minu_csv, 1000, ",")) !== FALSE) {
        if (count($rida) >= 3) {
            $toode = $rida[0];
            $hind = $rida[1];
            $pilt = $rida[2];

            // Use the provided image path without checking if it exists
            $imagePath = $pilt;

            echo '
            <div class="col">
                <div class="card border-0">
                    <img src="' . htmlspecialchars($imagePath) . '" class="card-img-top" alt="' . htmlspecialchars($toode) . '">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($toode) . '</h5>
                        <p class="card-text">' . htmlspecialchars($hind) . '</p>
                    </div>
                </div>
            </div>
            ';
        }
    }

    fclose($minu_csv);
}
?>





        </div>
    </div>

  <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <span class="mb-3 mb-md-0 text-body-secondary">© 2024 Krista Kutsar ITS-23</span>
    </footer>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 
</body>š