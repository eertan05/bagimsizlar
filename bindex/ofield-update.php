<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$EN = "";
$TR = "";
$help_TR = "";
$help_EN = "";

$EN_err = "";
$TR_err = "";
$help_TR_err = "";
$help_EN_err = "";


// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Field validation

    // Check input errors before inserting in database
//    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an update statement
        
        $EN = trim($_POST["EN"]);
		$TR = trim($_POST["TR"]);
		$help_TR = trim($_POST["help_TR"]);
		$help_EN = trim($_POST["help_EN"]);
		

        $dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
        $options = [
          PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        try {
          $pdo = new PDO($dsn, $db_user, $db_password, $options);
        } catch (Exception $e) {
          error_log($e->getMessage());
          exit('Something weird happened'); //something a user can understand
        }
        $stmt = $pdo->prepare("UPDATE ofield SET EN=?,TR=?,help_TR=?,help_EN=? WHERE id=?");


        if(!$stmt->execute([ $EN,$TR,$help_TR,$help_EN,$id  ])) {
                echo "Something went wrong. Please try again later.";
                header("location: error.php");
            } else{
                $stmt = null;
                header("location: ofield-index.php");
            }
} else {
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM ofield WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value

                    $EN = $row["EN"];
					$TR = $row["TR"];
					$help_TR = $row["help_TR"];
					$help_EN = $row["help_EN"];
					

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);

    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                            <label>EN</label>
                            <textarea name="EN" class="form-control"><?php echo $EN ; ?></textarea>
                            <span class="form-text"><?php echo $EN_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>TR</label>
                            <textarea name="TR" class="form-control"><?php echo $TR ; ?></textarea>
                            <span class="form-text"><?php echo $TR_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>help_TR</label>
                            <textarea name="help_TR" class="form-control"><?php echo $help_TR ; ?></textarea>
                            <span class="form-text"><?php echo $help_TR_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>help_EN</label>
                            <textarea name="help_EN" class="form-control"><?php echo $help_EN ; ?></textarea>
                            <span class="form-text"><?php echo $help_EN_err; ?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="ofield-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
