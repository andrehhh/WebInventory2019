<?php
function run($query)
    {
      $conn = mysqli_connect("localhost", "root", "", "inventory");
      $result = mysqli_query($conn, $query);
      return $result;
    }

if(isset($_POST['search']))
  {
    $keyword = $_POST['keyword'];
    $col = $_POST['sel'];
    if($col == 'all')
    {
      
      $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` WHERE CONCAT(`Date`, `Kode`, `Quantity`, `Status`) LIKE '%".$keyword."%' ORDER BY `history`.`Date` DESC";
    }
    elseif($col == 'date')
    {
      if(isset($_POST['dates']))
      {
        $date = $_POST['dates'];
        $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` WHERE `Date` = '$date' ";
      }
      else
        $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` ORDER BY `history`.`Date` DESC";
    }
    elseif($col == 'code')
    {
      if(isset($_POST['dates']))
      {
        $date = $_POST['dates'];
        $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` WHERE `Kode` = $keyword AND `Date` = '$date' ORDER BY `history`.`Date` DESC";
      }
      else
      $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` WHERE `Kode` = $keyword ORDER BY `history`.`Date` DESC";
    }
    elseif($col == 'status')
    {
      if(isset($_POST['dates']))
      {
        $date = $_POST['dates'];
        $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` WHERE `Status` = $keyword `Date` = '$date' ORDER BY `history`.`Date` DESC";
      }
      else
      $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` WHERE `Status` = $keyword ORDER BY `history`.`Date` DESC";
    }
    $result = run($query);
    $count = mysqli_num_rows($result);
  }
  else
  {
    $query = "SELECT *, date_format(`Date`, '%d-%m-%Y') AS `Date` from `history` ORDER BY `history`.`Date` DESC";
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
    <link rel="stylesheet" href="lib/bootstrap-datepicker.css">

    <script>
      $(function(){
        $('#user1').datepicker({ });
      });
    </script>

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
      <form action="history.php" method="post">
        <div class="form-inline">
          <label>Enter Keyword:</label>&nbsp&nbsp&nbsp
          <input type="text" class="form-control" placeholder="Keyword" name="keyword">
          <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Date:&nbsp&nbsp&nbsp</label>
          <input type="text" id="user1" class="form-control" placeholder="Date" name="dates" autocomplete="off">
          <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspIn Column:&nbsp&nbsp&nbsp</label>
          <select class="form-control" name="sel">
            <option value="all">ALL</option>
            <option value="date">Date</option>
            <option value="code">Code</option>
            <option value="status">Status</option>
          </select>
          <button type="submit" class="btn btn-default" name="search">Search</button>
          <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo 'Total: ' . $count . ' Records';?></label>
        </div>
      <hr>
      <h1 class="text-center">History</h1>
      <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
          <tr>
            <th>Date</th>
            <th>Code</th>
            <th>Quantity</th>
            <th>Quantity (Pcs)</th>
            <th>Status</th>
          </tr>
          <?php while($row = mysqli_fetch_array($result)):?>
          <tr>
            <td><?php echo $row['Date'];?></td>
            <td><?php echo $row['Kode'];?></td>
            <td><?php echo floor($row['Quantity']/12) . " ls " . $row['Quantity']%12 . " pcs";?></td>
            <td><?php echo $row['Quantity'];?></td>
            <td><?php echo $row['Status'];?></td>
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
  <script src="lib/bootstrap-datepicker.js"></script>
  <script>
    $('#user1').datepicker({'format':'yyyy-mm-dd'});
  </script>
  </body>
  </html>