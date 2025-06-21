<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$oname = "";
$oDescription = "";
$oaddress = "";
$ocities = "";
$owebsite = "";
$oemail = "";
$ophone = "";
$oInstagram = "";
$oTwitter = "";
$oFacebook = "";
$oType = "";
$oField = "";
$oServices = "";
$oDefinition = "";
$oTarget = "";
$oEvents = "";
$oSpaces = "";
$oEquipment = "";
$oentity = "";
$ofunding = "";

$oname_err = "";
$oDescription_err = "";
$oaddress_err = "";
$ocities_err = "";
$owebsite_err = "";
$oemail_err = "";
$ophone_err = "";
$oInstagram_err = "";
$oTwitter_err = "";
$oFacebook_err = "";
$oType_err = "";
$oField_err = "";
$oServices_err = "";
$oDefinition_err = "";
$oTarget_err = "";
$oEvents_err = "";
$oSpaces_err = "";
$oEquipment_err = "";
$oentity_err = "";
$ofunding_err = "";


// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Field validation

    // Check input errors before inserting in database
//    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an update statement
        
        $oname = trim($_POST["oname"]);
		$oDescription = trim($_POST["oDescription"]);
		$oaddress = trim($_POST["oaddress"]);
		$ocities = trim($_POST["ocities"]);
		$owebsite = trim($_POST["owebsite"]);
		$oemail = trim($_POST["oemail"]);
		$ophone = trim($_POST["ophone"]);
		$oInstagram = trim($_POST["oInstagram"]);
		$oTwitter = trim($_POST["oTwitter"]);
		$oFacebook = trim($_POST["oFacebook"]);
		$oType = trim($_POST["oType"]);
		$oField = trim($_POST["oField"]);
		$oServices = trim($_POST["oServices"]);
		$oDefinition = trim($_POST["oDefinition"]);
		$oTarget = trim($_POST["oTarget"]);
		$oEvents = trim($_POST["oEvents"]);
		$oSpaces = trim($_POST["oSpaces"]);
		$oEquipment = trim($_POST["oEquipment"]);
		$oentity = trim($_POST["oentity"]);
		$ofunding = trim($_POST["ofunding"]);
		

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
        $stmt = $pdo->prepare("UPDATE organizations SET oname=?,oDescription=?,oaddress=?,ocities=?,owebsite=?,oemail=?,ophone=?,oInstagram=?,oTwitter=?,oFacebook=?,oType=?,oField=?,oServices=?,oDefinition=?,oTarget=?,oEvents=?,oSpaces=?,oEquipment=?,oentity=?,ofunding=? WHERE id=?");


        if(!$stmt->execute([ $oname,$oDescription,$oaddress,$ocities,$owebsite,$oemail,$ophone,$oInstagram,$oTwitter,$oFacebook,$oType,$oField,$oServices,$oDefinition,$oTarget,$oEvents,$oSpaces,$oEquipment,$oentity,$ofunding,$id  ])) {
                echo "Something went wrong. Please try again later.";
                header("location: error.php");
            } else{
                $stmt = null;
                header("location: organizations-index.php");
            }
} else {
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM organizations WHERE id = ?";
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

                    $oname = $row["oname"];
					$oDescription = $row["oDescription"];
					$oaddress = $row["oaddress"];
					$ocities = $row["ocities"];
					$owebsite = $row["owebsite"];
					$oemail = $row["oemail"];
					$ophone = $row["ophone"];
					$oInstagram = $row["oInstagram"];
					$oTwitter = $row["oTwitter"];
					$oFacebook = $row["oFacebook"];
					$oType = $row["oType"];
					$oField = $row["oField"];
					$oServices = $row["oServices"];
					$oDefinition = $row["oDefinition"];
					$oTarget = $row["oTarget"];
					$oEvents = $row["oEvents"];
					$oSpaces = $row["oSpaces"];
					$oEquipment = $row["oEquipment"];
					$oentity = $row["oentity"];
					$ofunding = $row["ofunding"];
					

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
                            <label>Name</label>
                            <textarea name="oname" class="form-control"><?php echo $oname ; ?></textarea>
                            <span class="form-text"><?php echo $oname_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oDescription</label>
                            <textarea name="oDescription" class="form-control"><?php echo $oDescription ; ?></textarea>
                            <span class="form-text"><?php echo $oDescription_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oaddress</label>
                            <textarea name="oaddress" class="form-control"><?php echo $oaddress ; ?></textarea>
                            <span class="form-text"><?php echo $oaddress_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>ocities</label>
                            <textarea name="ocities" class="form-control"><?php echo $ocities ; ?></textarea>
                            <span class="form-text"><?php echo $ocities_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>owebsite</label>
                            <textarea name="owebsite" class="form-control"><?php echo $owebsite ; ?></textarea>
                            <span class="form-text"><?php echo $owebsite_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oemail</label>
                            <textarea name="oemail" class="form-control"><?php echo $oemail ; ?></textarea>
                            <span class="form-text"><?php echo $oemail_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>ophone</label>
                            <textarea name="ophone" class="form-control"><?php echo $ophone ; ?></textarea>
                            <span class="form-text"><?php echo $ophone_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oInstagram</label>
                            <textarea name="oInstagram" class="form-control"><?php echo $oInstagram ; ?></textarea>
                            <span class="form-text"><?php echo $oInstagram_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oTwitter</label>
                            <textarea name="oTwitter" class="form-control"><?php echo $oTwitter ; ?></textarea>
                            <span class="form-text"><?php echo $oTwitter_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oFacebook</label>
                            <textarea name="oFacebook" class="form-control"><?php echo $oFacebook ; ?></textarea>
                            <span class="form-text"><?php echo $oFacebook_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oType</label>
                            <textarea name="oType" class="form-control"><?php echo $oType ; ?></textarea>
                            <span class="form-text"><?php echo $oType_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oField</label>
                            <textarea name="oField" class="form-control"><?php echo $oField ; ?></textarea>
                            <span class="form-text"><?php echo $oField_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oServices</label>
                            <textarea name="oServices" class="form-control"><?php echo $oServices ; ?></textarea>
                            <span class="form-text"><?php echo $oServices_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oDefinition</label>
                            <textarea name="oDefinition" class="form-control"><?php echo $oDefinition ; ?></textarea>
                            <span class="form-text"><?php echo $oDefinition_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oTarget</label>
                            <textarea name="oTarget" class="form-control"><?php echo $oTarget ; ?></textarea>
                            <span class="form-text"><?php echo $oTarget_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oEvents</label>
                            <textarea name="oEvents" class="form-control"><?php echo $oEvents ; ?></textarea>
                            <span class="form-text"><?php echo $oEvents_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oSpaces</label>
                            <textarea name="oSpaces" class="form-control"><?php echo $oSpaces ; ?></textarea>
                            <span class="form-text"><?php echo $oSpaces_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oEquipment</label>
                            <textarea name="oEquipment" class="form-control"><?php echo $oEquipment ; ?></textarea>
                            <span class="form-text"><?php echo $oEquipment_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>oentity</label>
                            <textarea name="oentity" class="form-control"><?php echo $oentity ; ?></textarea>
                            <span class="form-text"><?php echo $oentity_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>ofunding</label>
                            <textarea name="ofunding" class="form-control"><?php echo $ofunding ; ?></textarea>
                            <span class="form-text"><?php echo $ofunding_err; ?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="organizations-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
