<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy books', 'buy books from store.', 'current_timestamp()');
// Connect to the Database  
$servername = "localhost";
$username="root";
$password="";
$database ="notes";
$insert = false;

//create a connection
$conn = mysqli_connect($servername,$username,$password,$database);

//Die if connection was not successfull
if(!$conn){
  die("sorry failed to connect: ".mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['snoEdit'])){
    // Update the record
    $title=$_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

  // sql query to be executed
  $sql = "UPDATE `notes` SET `title` = '$title' AND `description` = '$description' WHERE `notes`.`sno` = $sno;";
  $result = mysqli_query($conn,$sql);


    }
else{
    $title=$_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

  // sql query to be executed
  $sql = "INSERT INTO `notes`(`title`,`description`) VALUES ('$title','$description')";
  $result = mysqli_query($conn,$sql);

  //Add a new trip to the trip table in the database
  if($result){
    // echo "The record has been inserted successfully! <br>";
    $insert = true;
  }
  else{
    echo "The record was not inserted successfully because of this error ----->".mysqli_error($conn);
  }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <title>iNotes - Notes taking made easy</title>
  </head>
  <body>
    <!-- Button trigger modal -->
<!----<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button>------>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="snoEdit" id="snoEdit">
      <form action="/crud/index.php" method="post">
        <div class="form-group">
          <label for="title">Note title</label>
          <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="desc">Note Description</label>
          <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Note</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
    <?php
    if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your note has been inserted successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }

    ?>

    <div class="container my-4">
      <h2>Add a Note</h2>
      <form action="/crud/index.php" method="post">
        <div class="form-group">
          <label for="title">Note title</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="desc">Note Description</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>

    <div class="container my-4">
      <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $sql = "SELECT * FROM `notes`";
      $result = mysqli_query($conn,$sql);
      $sno = 0;
      while($row = mysqli_fetch_assoc($result)){
        $sno = $sno +1;
        echo "<tr>
        <th scope='row'>".$sno."</th>
        <td>".$row['title']."</td>
        <td>".$row['description']."</td>
        <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <a href='/delete'>Delete </a></td>
      </tr>";
    }
    
      ?>
      </tbody>
    </table>
    </div>
    <hr>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready( function () {
    $('#myTable').DataTable();
    } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
          console.log("edit ", );
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })
    </script>
  </body>
</html>

 $('#editModal').modal('toggle');
        })
      })
    </script>
  </body>
</html>