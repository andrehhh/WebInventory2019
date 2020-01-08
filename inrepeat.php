<?php
    $conn1 = mysqli_connect("localhost", "root", "", "inventory");
    $query1 = "SELECT * FROM `inventory`";
    $result1 = mysqli_query($conn1, $query1);
    $kode = FALSE;
    if(isset($_POST['kode']))
        $kode = $_POST['kode'];
    $select = "SELECT * from `inventory` WHERE `Kode` = '$kode'";
    if(isset($_POST['submit']))
    {
        $result = mysqli_query($conn1, $select);
        $table = mysqli_fetch_array($result);
        if($table == TRUE)
        {
            $sisa = $table['Quantity'];
            $qty = $_POST['lqty']*12 + $_POST['pqty'];
            $newqty = $sisa + $qty;
            $query = "UPDATE inventory SET `Quantity` = '$newqty' WHERE `Kode` = '$kode'";
            $result = mysqli_query($conn1, $query);
            $query = "INSERT INTO `history` (`Date`, `Kode`, `Quantity`, `Status`) values (CURRENT_DATE, '$kode', '$qty', 'Masuk Repeat')";
            $result = mysqli_query($conn1, $query);
            header("location:inrepeat.php?success=1");
        }
        else
        {
            header("location:inrepeat.php?error=1");
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Inventory</title>
  </head>
  <body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Inventory</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
             
            <li><a href="index.php">Stock <span class="sr-only">(current)</span></a></li>
            <li><a href="inbaru.php">Masuk Barang <span class="sr-only">(current)</span></a></li>
            <li><a href="out.php">Keluar Barang <span class="sr-only">(current)</span></a></li>
            <li><a href="history.php">History <span class="sr-only">(current)</span></a></li>
            </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        <h1 class="page-header">Masuk Barang Repeat
        <a href="inrepeat.php" class="btn btn-default pull-right" role="button">Barang Repeat</a>
        <a href="inbaru.php" class="btn btn-default pull-right" role="button">Barang Baru</a>
        </h1>
        <form action="inrepeat.php" method="post">
        <div class="form-group">
          <label>Kode Barang (Repeat) :</label>
          <input list="kodekode" type="text" class="form-control" placeholder="Kode Barang" name="kode" autocomplete="off"><br>
          <datalist id="kodekode">
          <?php while($row = mysqli_fetch_array($result1)):?>
            <option value="<?php echo $row['Kode'];?>">
            <?php endwhile;?>
          </datalist>
          <label>Quantity (Lusin) :</label>
          <input type="text" class="form-control" placeholder="Quantity dalam lusin" name="lqty"><br>
          <label>Quantity (Pcs) :</label>
          <input type="text" class="form-control" placeholder="Quantity dalam pcs" name="pqty"><br>
          <?php
            if(isset($_GET['error']) == True)
            {
                echo '<font color="#FF0000"><p align="center">Record failed! Ini barang baru</p></font>';
            }
            if(isset($_GET['success']) == True)
            {
                echo '<font color="#00FF00"><p align="center">Record success!</p></font>';
            }
          ?><br>
          <button type="submit" class="btn btn-default" name="submit">Submit</button>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap.min.js"></script>
  </body>
</html>