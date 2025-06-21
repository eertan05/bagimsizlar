<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6b773fe9e4.js" crossorigin="anonymous"></script>
    <style type="text/css">
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 5px;
        }
        body {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="float-left">Organizations Details</h2>
                        <a href="organizations-create.php" class="btn btn-success float-right">Add New Record</a>
                        <a href="organizations-index.php" class="btn btn-info float-right mr-2">Reset View</a>
                        <a href="index.php" class="btn btn-secondary float-right mr-2">Back</a>
                    </div>

                    <div class="form-row">
                        <form action="organizations-index.php" method="get">
                        <div class="col">
                          <input type="text" class="form-control" placeholder="Search this table" name="search">
                        </div>
                    </div>
                        </form>
                    <br>

                    <?php
                    // Include config file
                    require_once "config.php";

                    //Pagination
                    if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    $no_of_records_per_page = 10;
                    $offset = ($pageno-1) * $no_of_records_per_page;

                    $total_pages_sql = "SELECT COUNT(*) FROM organizations";
                    $result = mysqli_query($link,$total_pages_sql);
                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);
                    
                    //Column sorting on column name
                    $orderBy = array('oname', 'oDescription', 'oaddress', 'ocities', 'owebsite', 'oemail', 'ophone', 'oInstagram', 'oTwitter', 'oFacebook', 'oType', 'oField', 'oServices', 'oDefinition', 'oTarget', 'oEvents', 'oSpaces', 'oEquipment', 'oentity', 'ofunding'); 
                    $order = 'id';
                    if (isset($_GET['order']) && in_array($_GET['order'], $orderBy)) {
                            $order = $_GET['order'];
                        }

                    //Column sort order
                    $sortBy = array('asc', 'desc'); $sort = 'desc';
                    if (isset($_GET['sort']) && in_array($_GET['sort'], $sortBy)) {                                                                    
                          if($_GET['sort']=='asc') {                                                                                                                            
                            $sort='desc';
                            }                                                                                   
                    else {
                        $sort='asc';
                        }                                                                                                                           
                    }
                    // Attempt select query execution
                    $sql = "SELECT * FROM organizations ORDER BY $order $sort LIMIT $offset, $no_of_records_per_page";
                    
                    if(!empty($_GET['search'])) {
                        $search = ($_GET['search']);
                        $sql = "SELECT * FROM organizations
                            WHERE CONCAT (oname,oDescription,oaddress,ocities,owebsite,oemail,ophone,oInstagram,oTwitter,oFacebook,oType,oField,oServices,oDefinition,oTarget,oEvents,oSpaces,oEquipment,oentity,ofunding)
                            LIKE '%$search%'
                            ORDER BY $order $sort 
                            LIMIT $offset, $no_of_records_per_page";
                    }
                    else {
                        $search = "";
                    }

                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th><a href=?search=$search&sort=&order=oname&sort=$sort>Name</th>";
										echo "<th><a href=?search=$search&sort=&order=oDescription&sort=$sort>oDescription</th>";
										echo "<th><a href=?search=$search&sort=&order=oaddress&sort=$sort>oaddress</th>";
										echo "<th><a href=?search=$search&sort=&order=ocities&sort=$sort>ocities</th>";
										echo "<th><a href=?search=$search&sort=&order=owebsite&sort=$sort>owebsite</th>";
										echo "<th><a href=?search=$search&sort=&order=oemail&sort=$sort>oemail</th>";
										echo "<th><a href=?search=$search&sort=&order=ophone&sort=$sort>ophone</th>";
										echo "<th><a href=?search=$search&sort=&order=oInstagram&sort=$sort>oInstagram</th>";
										echo "<th><a href=?search=$search&sort=&order=oTwitter&sort=$sort>oTwitter</th>";
										echo "<th><a href=?search=$search&sort=&order=oFacebook&sort=$sort>oFacebook</th>";
										echo "<th><a href=?search=$search&sort=&order=oType&sort=$sort>oType</th>";
										echo "<th><a href=?search=$search&sort=&order=oField&sort=$sort>oField</th>";
										echo "<th><a href=?search=$search&sort=&order=oServices&sort=$sort>oServices</th>";
										echo "<th><a href=?search=$search&sort=&order=oDefinition&sort=$sort>oDefinition</th>";
										echo "<th><a href=?search=$search&sort=&order=oTarget&sort=$sort>oTarget</th>";
										echo "<th><a href=?search=$search&sort=&order=oEvents&sort=$sort>oEvents</th>";
										echo "<th><a href=?search=$search&sort=&order=oSpaces&sort=$sort>oSpaces</th>";
										echo "<th><a href=?search=$search&sort=&order=oEquipment&sort=$sort>oEquipment</th>";
										echo "<th><a href=?search=$search&sort=&order=oentity&sort=$sort>oentity</th>";
										echo "<th><a href=?search=$search&sort=&order=ofunding&sort=$sort>ofunding</th>";
										
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['oname'] . "</td>";echo "<td>" . $row['oDescription'] . "</td>";echo "<td>" . $row['oaddress'] . "</td>";echo "<td>" . $row['ocities'] . "</td>";echo "<td>" . $row['owebsite'] . "</td>";echo "<td>" . $row['oemail'] . "</td>";echo "<td>" . $row['ophone'] . "</td>";echo "<td>" . $row['oInstagram'] . "</td>";echo "<td>" . $row['oTwitter'] . "</td>";echo "<td>" . $row['oFacebook'] . "</td>";echo "<td>" . $row['oType'] . "</td>";echo "<td>" . $row['oField'] . "</td>";echo "<td>" . $row['oServices'] . "</td>";echo "<td>" . $row['oDefinition'] . "</td>";echo "<td>" . $row['oTarget'] . "</td>";echo "<td>" . $row['oEvents'] . "</td>";echo "<td>" . $row['oSpaces'] . "</td>";echo "<td>" . $row['oEquipment'] . "</td>";echo "<td>" . $row['oentity'] . "</td>";echo "<td>" . $row['ofunding'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='organizations-read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><i class='far fa-eye'></i></a>";
                                            echo "<a href='organizations-update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                                            echo "<a href='organizations-delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><i class='far fa-trash-alt'></i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                              ?> <ul class="pagination" align-right>
                                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                                    <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                        <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                                    </li>
                                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                        <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                                </ul>
<?php
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
</html>