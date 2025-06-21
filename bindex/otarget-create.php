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
if($_SERVER["REQUEST_METHOD"] == "POST"){
/*    
    // Validate input
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";
    } else{
        $address = $input_address;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
 */
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
        $stmt = $pdo->prepare("INSERT INTO otarget (EN,TR,help_TR,help_EN) VALUES (?,?,?,?)"); 
        
        if($stmt->execute([ $EN,$TR,$help_TR,$help_EN  ])) {
                $stmt = null;
                header("location: otarget-index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add a record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="otarget-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>