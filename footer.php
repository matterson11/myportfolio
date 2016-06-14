

<footer class="footer sticky-footer-navbar">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <ul class="list-unstyled list-inline">
                    <li><a href="home.php" class="text-white">Home</a></li>
                    <li><a href="about.php" class="text-white">About Us</a></li>
                    <li><a href="contact.php" class="text-white">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-sm-6 col-sm-offset-0 col-xs-8 col-xs-offset-2 text-right">
                <ul class="list-unstyled list-inline">
                    <li><a href="https://www.linkedin.com/in/matthewmatterson?trk=nav_responsive_tab_profile" target="_blank" class="text-white">LinkedIn</a></li>
                    <li><a href="https://twitter.com/HereisMGM" target="_blank" class="text-white">Twitter</a></li>
                </ul>
            </div>
        </div>
    </div>

</footer>


<script>
    function submitdata() {

        var formMessages = $('#form-messages');

        var fullname = document.getElementById("fullname").value;
        var email = document.getElementById("email").value;
        var subject = document.getElementById("subject").value;
        var message = document.getElementById("message").value;
        var dataString = 'fullname=' + fullname + '&email=' + email + '&subject=' + subject + '&message=' + message;

        if (fullname == '' || email == '' || subject == '' || message == '') {
            alert("Complete form");
        }
        else {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "email.php",
                data: dataString,
                cache: false,
                success: function(html){
                    //alert(html);
                    $(formMessages).removeClass('error');
                    $(formMessages).addClass('alert alert-success');

                    $(formMessages).text(html).delay(2500)
                        .fadeOut();

                    $('#fullname').val('');
                    $('#email').val('');
                    $('#subject').val('');
                    $('#message').val('');
                }

            });
        }
        return false;
    }

</script>


<!--<script src="app.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>