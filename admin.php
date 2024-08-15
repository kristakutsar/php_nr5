<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Kodutöö nr5</title>
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
    <?php
    ob_start();
    ?>

    <div class="jumbotron jumbotron-fluid bg-light-pink-radial-gradient p-5">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Sinunimi.com</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="index.php">Avaleht</a></li>
                            <li class="nav-item"><a class="nav-link" href="tooted.php">Tooted</a></li>
                            <li class="nav-item"><a class="nav-link" href="kontakt.php">Kontakt</a></li>
                            <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
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

            <div class="container mt-5">
                <h1>Admin</h1>
                <?php
                    if (isset($_GET['ok'])) {
                        echo '<div class="alert alert-success" role="alert">Toote lisamine õnnestus!</div>';
                    }
                ?>

                <!-- Vorm uue toote lisamiseks -->
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="nimi">Toote nimi</label>
                    <input type="text" name="nimi" required><br>

                    <label for="hind">Toote hind</label>
                    <input type="number" min="0.00" max="1000.00" step="0.01" name="hind" required><br>

                    <label for="pilt">Lisa pilt</label>
                    <input type="file" name="pilt" required><br>

                    <input type="hidden" name="page" value="services">

                    <input class="btn btn-success" type="submit" value="Lisa uus toode">
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nimi'])) {
                    $upload_dir = 'images/';
                    $pildi_nimi = basename($_FILES['pilt']['name']);
                    $upload_file = $upload_dir . $pildi_nimi;

                    if (move_uploaded_file($_FILES['pilt']['tmp_name'], $upload_file)) {
                        // Lisatud toote andmed CSV faili
                        $read = array($_POST['nimi'], $_POST['hind'], $upload_dir . $pildi_nimi);
                        $path = 'tooted.csv';
                        $fp = fopen($path, 'a');
                        if ($fp !== FALSE) {
                            fputcsv($fp, $read);
                            fclose($fp);
                        } else {
                            echo '<div class="alert alert-danger" role="alert">CSV file could not be opened.</div>';
                        }

                        // Tagasi admin lehele
                        header('Location: admin.php?ok');
                        exit();
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Image upload failed.</div>';
                    }
                }
                ?>

                <!-- Tooted kustutamiseks -->
                <div class="row row-cols-1 row-cols-md-4 g-4 pt-5">
                    <?php
                    $tooted = "tooted.csv";
                    if (file_exists($tooted) && ($minu_csv = fopen($tooted, "r")) !== FALSE) {
                        while (($rida = fgetcsv($minu_csv, 1000, ",")) !== FALSE) {
                            if (count($rida) == 3) {
                                $productName = htmlspecialchars($rida[0]);
                                $productPrice = htmlspecialchars($rida[1]);
                                $imagePath = htmlspecialchars($rida[2]);

                            
                                if (file_exists($imagePath)) {
                                    echo '
                                    <div class="col">
                                        <div class="card">
                                            <img src="' . $imagePath . '" class="card-img-top" alt="' . $productName . '">
                                            <div class="card-body">
                                                <h5 class="card-title">' . $productName . '</h5>
                                                <p class="card-text">' . $productPrice . '€</p>
                                                <form method="POST">
                                                    <input type="hidden" name="delete_product" value="' . $productName . '">
                                                    <button class="btn btn-danger" type="submit">Kustuta</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="col">
                                        <div class="card">
                                            <img src="images/placeholder.png" class="card-img-top" alt="No Image Available">
                                            <div class="card-body">
                                                <h5 class="card-title">' . $productName . '</h5>
                                                <p class="card-text">' . $productPrice . '€</p>
                                                <form method="POST">
                                                    <input type="hidden" name="delete_product" value="' . $productName . '">
                                                    <button class="btn btn-danger" type="submit">Kustuta</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                        }
                        fclose($minu_csv);
                    } else {
                        echo '<div class="alert alert-warning" role="alert">No products found or CSV file cannot be opened.</div>';
                    }

                    if (isset($_POST['delete_product'])) {
                        $delete_product_name = $_POST['delete_product'];

                        // eemalda toode CSV failist
                        $file = file($tooted);
                        $fp = fopen($tooted, 'w');

                        foreach ($file as $line) {
                            $data = str_getcsv($line);
                            if ($data[0] != $delete_product_name) {
                                fputcsv($fp, $data);
                            }
                        }

                        fclose($fp);
                        header("Location: admin.php");
                        exit();
                    }
                    ?>
                </div>
            </div> 
        </div>
    </div>

</body>
</html>