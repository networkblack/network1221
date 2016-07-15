<?php
include_once('assets/intconn.php');
$profile_ref = '<span href="#" class="login" style="cursor:pointer;">Login</span>';
$signup_ref = '<a href="signup/">Sign Up</a>';
$annc_ref='login/';
if (isset($_COOKIE['webcademy_login'])) {
    $user_id = $_COOKIE['webcademy_login'];
    $user_type = $_COOKIE['webcademy_user_type'];
    setcookie('webcademy_login', $user_id, time() + 7200, '/');
    setcookie('webcademy_user_type', $user_type, time() + 7200, '/');
    if ($user_type == 'admin') {
        $ref = 'dashboard/admin/';
	$annc_ref='dashboard/admin/announcement/';
    } else if ($user_type == 'instructor') {
        $ref = 'dashboard/instructor/';
	$annc_ref='dashboard/instructor/announcement/';
    } else if ($user_type == 'student') {
        $ref = 'dashboard/student/';
	$annc_ref='dashboard/student/announcement/';
    }
    $profile_ref = '<a href="' . $ref . '">My Account</a>';
    $signup_ref = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php include_once('header.php'); ?>
    <title>Webcademy</title>
</head>
<body>
<div class="site-container">
    <div class="site-pusher">
        <!--Menu-->
        <header class="header md-bg-blue">
            <span class="header__icon" id="header__icon"></span>
            <a href="index.php" class="header__logo"><i class="fa fa-graduation-cap"></i> Webcademy</a>
            <nav class="menu">
                <a href="courses/" class="">Courses</a>
                <a href="<?php echo $annc_ref; ?>">Announcements*******</a>
            
                <?php echo $profile_ref; ?>
                <?php echo $signup_ref; ?>
            </nav>
        </header>
        <!--hMenu-->

        <!--Site Content-->

        <!--Header-->
        <div class="container-fluid" id="header">
            <div class="card center-block">
                <div class="card-head">
                    <div class="card-title">
                        <h1>What course would you like to learn?</h1>
                    </div>
                </div>
                <div class="card-body">
                    <form action="search.php" method="get">
                        <div class="grid">
                            <div class="col-2">

                            </div>
                            <div class="col-8 col-xs-10">
                                <input type="search" class="form-md-ctrl search-md" name="q"
                                       placeholder="ITEC316, ITEC229, ITEC230..." required/>
                            </div>
                            <div class="col-2 col-xs-2">
                                <button class="btn-md btn-md-blue btn-md-shadowed" type="submit" name="search"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Header-->

        <!--Description-->
        <div class="container-fluid" id="features">
            <div class="container">
                <h1 class="md-header text-center">Features</h1>

                <div class="grid">
                    <div class="col-4">
                        <div class="card center-block">
                            <i class="fa fa-users fa-2x"></i>

                            <h3>Join thousands of students like yourself, learn and share your experiences.</h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card center-block">
                            <i class="fa fa-book fa-2x"></i>

                            <h3>Over 500 courses to choose from.</h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card center-block">
                            <i class="fa fa-bookmark fa-2x"></i>

                            <h3>Learn anywhere, anytime.</h3>
                        </div>
                    </div>

                </div>
            </div>
            <div class="grid">
                <h1 class="md-header text-center">Why Webcademy?</h1>
                <i></i>

                <div class="col-12" id="desc-1">
                    <h1>Learn At Your Convenience.</h1>

                    <h2>Webcademy is available anywhere, anytime. So learning is made convenient for all kind users</h2>
                </div>
                <div class="col-12" id="desc-2">
                    <h1>Learn At Your Pace.</h1>

                    <h2>With this much ease, all kind of users can take their time to learn any course in-depth.</h2>
                </div>

            </div>
        </div>
        <!--Description-->

        <!--Courses-->
        <div class="container-fluid" id="courses">
            <!--Course List-->
            <div class="container" id="course-list">
                <h1 class="md-header text-center">
                    Available Courses
                </h1>

                <div class="grid">
                    <!--Course Card-->
                    <?php
                    $fetchCourse = "SELECT * FROM course WHERE show_course=1 LIMIT 3";
                    $result = $conn->query($fetchCourse) or die("There was an error<br/>Error Code : " . $conn->errno . "<br/>Error Message : " . $conn->error);
                    if ($result->num_rows > 0) {
                        while ($record = $result->fetch_assoc()) {
                            ?>
                            <div class="col-4">
                                <div class="card course-card center-block">
                                    <div class="card-head course-card-head"
                                         style="background: url(courses/assets/img/course_cover/<?php echo $record['course_cover']; ?>)center center no-repeat;">
                                        <div class="card-title">
                                            <h1 class="md-white"><?php echo strtoupper($record['course_code']); ?></h1>
                                        </div>

                                    </div>
                                    <div class="card-body" style="height:150px;">
                                        <p><strong>Course Title:</strong>
                                            <?php echo $record['course_title']; ?>
                                        </p>

                                        <p><strong>Course Description:</strong>
                                            <?php
                                            $desc = $record['course_desc'];
                                            if (strlen($desc) > 38) {
                                                $maxLength = 38;
                                                $desc = substr($desc, 0, $maxLength) . '...';
                                            }
                                            echo $desc;
                                            ?>
                                        </p>
                                        <h5><strong>Date Added:</strong>
                                            <?php echo $record['date_added']; ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="grid">
                                            <div class="col-12">
                                                <button type="button"
                                                        onclick="location.href='courses/course.php?&c_id=<?php echo $record['id']; ?>'"
                                                        class="btn-md btn-md-green center-block btn-md-shadowed">
                                                    <i class="fa fa-eye"></i> View Course
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <button class="btn-md btn-md-shadowed center-block btn-md-blue"
                                onclick="location.href='courses/'">
                            See More <i class="fa fa-chevron-circle-right"></i>
                        </button>
                        <?php
                    } elseif ($result->num_rows < 1) {
                        ?>
                        <div class='col-12'><p class='md-grey'>There are currently no courses.</p></div>
                        <?php
                    }
                    ?>
                    <!--Course Card-->
                </div>
            </div>
            <!--Course List-->
        </div>
        <!--Courses-->
        <div class="container-fluid md-bg-green" id="footer">
            <i class="fa fa-graduation-cap center-block text-center fa-2x"></i>

            <h1 class="center-block text-center">Webcademy Development Team</h1>

            <div class="grid">
                <div class="container-fluid">

                    <div class="col-6">
                        <img src="assets/img/bg/dev-team.jpg" alt="" class="img-sive"/>
                    </div>
                    <div class="col-6">
                        <ul>
                            <h2 class="md-header">Team:</h2>
                            <li><h2>Burak GONEN - 090754</h2></li>
                            <li><h2>Alen SANCAR - 071441</h2></li>
				<li><h2>Simon Deke</h2></li>
                            <h2 class="md-header">Supervised By:</h2>
                            <li><h2>Cantas OZEREK</h2></li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>


        <!--Site Content-->
    </div>
</div>

<!--External Includes-->
<?php include_once('login.html'); ?>
<!--External Includes-->

</body>
</html>
