<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Byte Side - Car Rental Management System</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

    <?php include '_nav.php' ?>

    <div class="home">
        <div class="main-sec">
            <div class="left">
                <p class="txt1">Easy And Fast Way To <span class="text-primary">Rent</span> Your Car</p>
                <p>First ever time in Gujranwala to effectively rent a car. Knowing the today's vital need to hire cabs and to travel
                    all across the world we are very keen to introduce you the car renting system.
                    </p>
                <div class="btn">
                <a href="carslist.php"><button class='btn btn-primary'>Rent Car</button></a>
                </div>
            </div>

            <div class="right">
                <img src="img/bmw-22428.png" alt="">
            </div>
        </div>
    </div>

    <section class="car-sec">
        <div class="txt">
            <p class="txt1">Latest <span class="text-primary">Inventory</span></p>
            <p class="txt2">Here are the Latest inventory taking hot deals!</p>
        </div>

        <div class="main-sec">

        <?php
            include '_dbconnect.php';
            $sqlcar = "SELECT * FROM `tblcar` LIMIT 6";
            $result = mysqli_query($conn, $sqlcar);
            while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="box">
                <img style="width: 325px;"
                    src="<?php echo "/crms/admin/img/".$row['image'];?>" width="100%" height="225">
                <div class="details">

                    <p class="car-name"><?php echo $row['model'];?></p>


                    <div class="price">
                        <p><?php echo number_format($row['rental_price']);?> PKR</p>
                        <a href="selectedcar.php?selected=<?php echo $row['car_id']; ?>"><button type="button" class="btn btn-sm btn-primary">View</button></a>
                    </div>
                </div>
            </div>
        <?php } ?>
        
            
        </div>
        <div class="btn">
                <a href="carslist.php"><input type="button" value="View All"></a>
            </div>
    </section> 

    <section class="support-sec">
        <div class="txt">
            <p class="txt1">Why <span>Choose</span> Us</p>
            <p>Our platform stands out for its seamless user experience, extensive vehicle options, and commitment to customer satisfaction.</p>
        </div>

        <div class="main-sec">
            <div class="box">
                <i class="fa-solid fa-phone"></i>
                <div class="txt-sec">
                    <p class="txt1">24 Hour Support</p>
                    <p>Our dedicated support team is available around the clock to address any queries or issues,
                         ensuring assistance throughout your rental experience.</p>
                </div>
            </div>

            <div class="box">
                <i class="fa-regular fa-square-check"></i>
                <div class="txt-sec">
                    <p class="txt1">Quick Reservation</p>
                    <p>Streamlined reservation process with minimal steps,
                        allowing users to quickly check vehicle availability, select options, and confirm bookings.</p>
                </div>
            </div>

            <div class="box">
                <i class="fa-solid fa-flag-checkered"></i>
                <div class="txt-sec">
                    <p class="txt1">Best Price</p>
                    <p>We offer the most competitive rates in the market, ensuring affordability without compromising
                         on quality or service standards, making us your ultimate cost-effective choice for car rentals.</p>
                </div>
            </div>

            <div class="box">
                <i class="fa-solid fa-certificate"></i>
                <div class="txt-sec">
                    <p class="txt1">Verified License</p>
                    <p>Rest assured with our stringent verification process, guaranteeing that all drivers possess
                    valid licenses, prioritizing safety and compliance for a worry-free journey.</p>
                </div>
            </div>

            
        </div>
    </section>

    <section class="achie-sec">
        <div class="txt">
            <p class="txt1">Our <span>Achievement</span></p>
        </div>

        <div class="main-sec">
            <div class="box">
                <p class="txt1">4000+</p>
                <p>Active Member</p>
            </div>

            <div class="box">
                <p class="txt1">3000+</p>
                <p>Car Color</p>
            </div>

            <div class="box">
                <p class="txt1">6000+</p>
                <p>Car Model</p>
            </div>

            <div class="box">
                <p class="txt1">10k</p>
                <p>Positive Rating</p>
            </div>
        </div>
    </section>

    <section class="start-sec">
        <div class="main-sec">
            <div class="left">
                <p class="txt1">Ready To Get Started?</p>
                <p class="txt2">Premium vehicles without premium prices.We have 100 rental vehicles in our fleet,which hosts models from some of the best car manufacturers,including german favourit such as BMW, Mercedes, Audi and more</p>

            </div>

            <div class="right">
                <img src="img/verna.png" alt="">
            </div>
        </div>
    </section>

<?php include '_footer.php'; ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
</body>

</html>