<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>tickets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Tickets Details</h2>
                </div>
                <?php
                require_once "config.php";
                echo '<input id="search">';
                $sql = "SELECT * FROM tikets";
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Content</th>";
                        echo "<th>Date</th>";
                        echo "<th>User Name</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody id='load_data'>";
                        echo "</tbody>";
                        echo "</table>";
                        echo "<div id=load_data_message></div>";
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function () {
        var limit = 2;
        var start = 0;
        var action = 'inactive';
        function load_country_data(limit, start) {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                data: {limit: limit, start: start},
                cache: false,
                success: function (data) {
                    $('#load_data').append(data);
                    if (data == '') {
                        $('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
                        action = 'active';
                    } else {
                        $('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
                        action = "inactive";
                    }
                }
            });
        }
        if (action == 'inactive') {
            action = 'active';
            load_country_data(limit, start);
        }
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive') {
                action = 'active';
                start = start + limit;
                setTimeout(function () {
                    load_country_data(limit, start);
                }, 1000);
            }
        });
        function autocomplete(searchStr) {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                data: {str:searchStr},
                cache: false,
                success: function (data) {
                    $('#load_data').html(data);
                }
            });
        }
        $("#search").on("keyup change", function(e) {
            autocomplete($('#search').val());
        })
    });
</script>
