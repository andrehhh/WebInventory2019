<?php
    $count = 0;
    function run($query)
    {
      $conn = mysqli_connect("localhost", "root", "", "inventory");
      $result = mysqli_query($conn, $query);
      return $result;
    }
    $query1 = "SELECT * FROM `inventory`";
    $result1 = run($query1);
    if(isset($_POST['search']))
    {
      $keyword = $_POST['keyword'];
      $query = "SELECT * from `inventory` WHERE `Kode` LIKE '%".$keyword."%'";
      $result = run($query);
      $count = mysqli_num_rows($result);
    }
    else
    {
      $query = "SELECT * FROM `inventory`";
      $result = run($query);
      $count = mysqli_num_rows($result);
    }

    if(isset($_POST['save']))
      exec('C:\wamp64\bin\mysql\mysql5.7.26\bin\mysqldump -u root -pansenjo --opt inventory > C:\Inventory_Backup\\'.date('d-m-Y').'.sql');

  	if(isset($_POST['sortcode']))
  	{
  		$query = "SELECT * FROM `inventory` ORDER BY `Kode` ASC";
      	$result = run($query);
      	$count = mysqli_num_rows($result);
  	}
  	if(isset($_POST['sortquantity']))
  	{
  		$query = "SELECT * FROM `inventory` ORDER BY `Quantity` ASC";
      	$result = run($query);
      	$count = mysqli_num_rows($result);
  	}

?>
<!doctype html>
<html>
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
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" length="100%">
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
      <form action="index.php" method="post">
        <div class="form-inline">
          <label>Enter Code:</label>&nbsp&nbsp&nbsp
          <input list="kodekode" type="text" class="form-control" placeholder="Code" name="keyword" autocomplete="off">
          <datalist id="kodekode">
          <?php while($row = mysqli_fetch_array($result1)):?>
            <option value="<?php echo $row['Kode'];?>">
            <?php endwhile;?>
          </datalist>
          <button type="submit" class="btn btn-default" name="search">Search</button>
          <button type="submit" class="btn btn-default pull-right" name="save">Save</button>
          <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo 'Total: ' . $count . ' Models';?></label>
        </div>
      <hr>
      <h1 class="text-center">Stock</h1>
      <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
          <tr>
            <th><button type="submit" href="index.php" name="sortcode" class="btn btn-link">Code</button></th>
            <th><button type="submit" href="index.php" name="sortquantity" class="btn btn-link">Quantity</button></th>
            <th><button type="submit" href="index.php" name="sortquantity" class="btn btn-link">Quantity (Pcs)</button></th>
          </tr>
          <?php while($row = mysqli_fetch_array($result)):?>
          <tr>
            <td><?php echo $row['Kode'];?></td>
            <td><?php echo floor($row['Quantity']/12) . " ls " . $row['Quantity']%12 . " pcs";?></td>
            <td><?php echo $row['Quantity'];?></td>
          </tr>
          <?php endwhile;?>
      </table>
      </div>
      </form>
    </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="bootstrap.min.js"></script>
  </body>
</html>