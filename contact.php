<?php
include("header.php");
?>

<section id="contact-billboard" class="jumbotron billboard parallax">
    <div class="background artwork"></div>
    <div class="background overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-10 col-xs-12">
                <h1>Get in touch</h1>
                <h2 class="font-normal l-h-1x">Please send a message if you have something suitable.</h2>
            </div>
        </div>
    </div>
</section>
    <section class="content-stripe">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-xs-12">
                    <h1 class="font-normal text-primary l-h-1x m-t-none m-b">Please get in touch</h1>
                    <h3 class="m-b-lg">If you would prefer to email me directly, click <a
                            href="mailto:mytimelearningcontact@gmail.com">here</a>.</h3>
                    <h3 class="m-b-lg">mytimelearningcontact@gmail.com</h3>
                </div>
                <div class="col-lg-5 col-md-6 col-xs-12">
                    <h2 class="font-normal l-h-1x text-primary primary-header-underline m-t-none m-b">Message
                        Me</h2>
                    <p class="font-normal m-b-lg">Thanks for getting in touch. I'll respond to your message as soon
                        as
                        possible.</p>

                    <form id="form" method="post">
                        <div id="form-messages"></div>
                        <div class="form-group form-group-lg">
                            <label for="fullname">Full name</label>
                            <input type="text" name="fullname" class="form-control" id="fullname" required>
                        </div>
                        <div class="form-group form-group-lg">
                            <label for="email">E-mail address</label>
                            <input type="text" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="form-group form-group-lg">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" class="form-control" id="subject" required>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="form-group form-group-lg">
                                <label for="message">Message</label>
                                <textarea name="message" class="form-control" id="message">Write a message...</textarea><br/>
                            </div>
                        </div>
                        <div class="form-group form-group-lg m-b-lg">
                            <button type="submit" name="submit" class="submit" onclick="submitdata()">Send</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
include("footer.php");
?>